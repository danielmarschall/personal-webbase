<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * SQL Validator interface for phpMyAdmin
 *
 * Copyright 2002 Robin Johnson <robbat2@users.sourceforge.net>
 * http://www.orbis-terrarum.net/?l=people.robbat2
 *
 * This function uses the Mimer SQL Validator service
 * <http://developer.mimer.com/validator/index.htm> from phpMyAdmin
 *
 * Copyright for Server side validator systems:
 * "All SQL statements are stored anonymously for statistical purposes.
 * Mimer SQL Validator, Copyright 2002 Upright Database Technology.
 * All rights reserved."
 *
 * All data is transported over HTTP-SOAP
 * And uses the PEAR SOAP Module
 *
 * Install instructions for PEAR SOAP
 * Make sure you have a really recent PHP with PEAR support
 * run this: "pear install Mail_Mime Net_DIME SOAP"
 *
 * Enable the SQL Validator options in the configuration file
 * $cfg['SQLQuery']['Validate'] = TRUE;
 * $cfg['SQLValidator']['use']  = FALSE;
 *
 * Also set a username and password if you have a private one
 *
 * @version $Id: sqlvalidator.lib.php 11986 2008-11-24 11:05:40Z nijel $
 * @package phpMyAdmin
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 * We need the PEAR libraries, so do a minimum version check first
 * I'm not sure if PEAR was available before this point
 * For now we actually use a configuration flag
 */
if ($cfg['SQLValidator']['use'] == TRUE)  {
    require_once './libraries/sqlvalidator.class.php';
} // if ($cfg['SQLValidator']['use'] == TRUE)


/**
 * This function utilizes the Mimer SQL Validator service
 * to validate an SQL query
 *
 * <http://developer.mimer.com/validator/index.htm>
 *
 * @param   string   SQL query to validate
 *
 * @return  string   Validator result string
 *
 * @global  array    The PMA configuration array
 */
function PMA_validateSQL($sql)
{
    global $cfg;

    $str = '';

    if ($cfg['SQLValidator']['use']) {
        if (isset($GLOBALS['sqlvalidator_error'])
            && $GLOBALS['sqlvalidator_error']) {
            $str = sprintf($GLOBALS['strValidatorError'], '<a href="./Documentation.html#faqsqlvalidator" target="documentation">', '</a>');
        } else {
            // create new class instance
            $srv = new PMA_SQLValidator();

            // Checks for username settings
            // The class defaults to anonymous with an empty password
            // automatically
            if ($cfg['SQLValidator']['username'] != '') {
                $srv->setCredentials($cfg['SQLValidator']['username'], $cfg['SQLValidator']['password']);
            }

            // Identify ourselves to the server properly...
            $srv->appendCallingProgram('phpMyAdmin', PMA_VERSION);

            // ... and specify what database system we are using
            $srv->setTargetDbms('MySQL', PMA_MYSQL_STR_VERSION);

            // Log on to service
            $srv->start();

            // Do service validation
            $str = $srv->validationString($sql);
        }

    } // end if

    // Gives string back to caller
    return $str;
} // end of the "PMA_validateSQL()" function

?>
