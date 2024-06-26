<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * PHP interface to MimerSQL Validator
 *
 * Copyright 2002, 2003 Robin Johnson <robbat2@users.sourceforge.net>
 * http://www.orbis-terrarum.net/?l=people.robbat2
 *
 * All data is transported over HTTP-SOAP
 * And uses the PEAR SOAP Module
 *
 * Install instructions for PEAR SOAP
 * Make sure you have a really recent PHP with PEAR support
 * run this: "pear install Mail_Mime Net_DIME SOAP"
 *
 * If you got this file from somewhere other than phpMyAdmin
 * please be aware that the latest copy will always be in the
 * phpMyAdmin subversion tree as
 * $HeadURL: https://phpmyadmin.svn.sourceforge.net/svnroot/phpmyadmin/trunk/phpMyAdmin/libraries/sqlvalidator.class.php $
 *
 * This code that also used to depend on the PHP overload module, but that has been
 * removed now.
 *
 * @access   public
 *
 * @author   Robin Johnson <robbat2@users.sourceforge.net>
 *
 * @version  $Id: sqlvalidator.class.php 11990 2008-11-24 11:12:52Z nijel $
 * @package phpMyAdmin
 */
if (! defined('PHPMYADMIN')) {
    exit;
}

/**
 * Load SOAP client.
 */
@include_once 'SOAP/Client.php';

if (!function_exists('class_exists') || !class_exists('SOAP_Client')) {
    $GLOBALS['sqlvalidator_error'] = TRUE;
} else {
    // Ok, we have SOAP Support, so let's use it!

/**
 * @package phpMyAdmin
 */
    class PMA_SQLValidator {

        var $url;
        var $service_name;
        var $wsdl;
        var $output_type;

        var $username;
        var $password;
        var $calling_program;
        var $calling_program_version;
        var $target_dbms;
        var $target_dbms_version;
        var $connectionTechnology;
        var $connection_technology_version;
        var $interactive;

        var $service_link = null;
        var $session_data = null;


        /**
         * Private functions - You don't need to mess with these
         */

        /**
         * Service opening
         *
         * @param  string  URL of Mimer SQL Validator WSDL file
         *
         * @return object  Object to use
         *
         * @access private
         */
        function _openService($url)
        {
            $obj = new SOAP_Client($url, TRUE);
            return $obj;
        } // end of the "openService()" function


        /**
         * Service initializer to connect to server
         *
         * @param  object   Service object
         * @param  string   Username
         * @param  string   Password
         * @param  string   Name of calling program
         * @param  string   Version of calling program
         * @param  string   Target DBMS
         * @param  string   Version of target DBMS
         * @param  string   Connection Technology
         * @param  string   version of Connection Technology
         * @param  integer  boolean of 1/0 to specify if we are an interactive system
         *
         * @return object   stdClass return object with data
         *
         * @access private
         */
        function _openSession($obj, $username, $password,
                                      $calling_program, $calling_program_version,
                                      $target_dbms, $target_dbms_version,
                                      $connection_technology, $connection_technology_version,
                                      $interactive)
        {
    $use_array = array("a_userName" => $username, "a_password" => $password, "a_callingProgram" => $calling_program, "a_callingProgramVersion" => $calling_program_version, "a_targetDbms" => $target_dbms, "a_targetDbmsVersion" => $target_dbms_version, "a_connectionTechnology" => $connection_technology, "a_connectionTechnologyVersion" => $connection_technology_version, "a_interactive" => $interactive);
            $ret = $obj->call("openSession", $use_array);

           // This is the old version that needed the overload extension
           /* $ret = $obj->openSession($username, $password,
                                     $calling_program, $calling_program_version,
                                     $target_dbms, $target_dbms_version,
                                     $connection_technology, $connection_technology_version,
                                     $interactive); */

            return $ret;
        } // end of the "_openSession()" function


        /**
         * Validator sytem call
         *
         * @param  object  Service object
         * @param  object  Session object
         * @param  string  SQL Query to validate
         * @param  string  Data return type
         *
         * @return object  stClass return with data
         *
         * @access private
         */
        function _validateSQL($obj, $session, $sql, $method)
        {
    $use_array = array("a_sessionId" => $session->sessionId, "a_sessionKey" => $session->sessionKey, "a_SQL" => $sql, "a_resultType" => $this->output_type);
            $res = $obj->call("validateSQL", $use_array);

           // This is the old version that needed the overload extension
           // $res = $obj->validateSQL($session->sessionId, $session->sessionKey, $sql, $this->output_type);
            return $res;
        } // end of the "validateSQL()" function


        /**
         * Validator sytem call
         *
         * @param  string  SQL Query to validate
         *
         * @return object  stdClass return with data
         *
         * @access private
         *
         * @see    validateSQL()
         */
        function _validate($sql)
        {
            $ret = $this->_validateSQL($this->service_link, $this->session_data,
                                               $sql, $this->output_type);
            return $ret;
        } // end of the "validate()" function


        /**
         * Public functions
         */

        /**
         * Constructor
         *
         * @access public
         */
        function __construct()
        {
            $this->url                           = 'http://sqlvalidator.mimer.com/v1/services';
            $this->service_name                  = 'SQL99Validator';
            $this->wsdl                          = '?wsdl';

            $this->output_type                   = 'html';

            $this->username                      = 'anonymous';
            $this->password                      = '';
            $this->calling_program               = 'PHP_SQLValidator';
            $this->calling_program_version       = '$Revision: 11990 $';
            $this->target_dbms                   = 'N/A';
            $this->target_dbms_version           = 'N/A';
            $this->connection_technology         = 'PHP';
            $this->connection_technology_version = phpversion();
            $this->interactive = 1;

            $this->service_link = null;
            $this->session_data = null;
        } // end of the "PMA_SQLValidator()" function


        /**
         * Sets credentials
         *
         * @param  string  the username
         * @param  string  the password
         *
         * @access public
         */
        function setCredentials($username, $password)
        {
            $this->username = $username;
            $this->password = $password;
        } // end of the "setCredentials()" function


        /**
         * Sets the calling program
         *
         * @param  string  the calling program name
         * @param  string  the calling program revision
         *
         * @access public
         */
        function setCallingProgram($calling_program, $calling_program_version)
        {
            $this->calling_program         = $calling_program;
            $this->calling_program_version = $calling_program_version;
        } // end of the "setCallingProgram()" function


        /**
         * Appends the calling program
         *
         * @param  string  the calling program name
         * @param  string  the calling program revision
         *
         * @access public
         */
        function appendCallingProgram($calling_program, $calling_program_version)
        {
            $this->calling_program         .= ' - ' . $calling_program;
            $this->calling_program_version .= ' - ' . $calling_program_version;
        } // end of the "appendCallingProgram()" function


        /**
         * Sets the target DBMS
         *
         * @param  string  the target DBMS name
         * @param  string  the target DBMS revision
         *
         * @access public
         */
        function setTargetDbms($target_dbms, $target_dbms_version)
        {
            $this->target_dbms         = $target_dbms;
            $this->target_dbms_version = $target_dbms_version;
        } // end of the "setTargetDbms()" function


        /**
         * Appends the target DBMS
         *
         * @param  string  the target DBMS name
         * @param  string  the target DBMS revision
         *
         * @access public
         */
        function appendTargetDbms($target_dbms, $target_dbms_version)
        {
            $this->target_dbms         .= ' - ' . $target_dbms;
            $this->target_dbms_version .= ' - ' . $target_dbms_version;
        } // end of the "appendTargetDbms()" function


        /**
         * Sets the connection technology used
         *
         * @param  string  the connection technology name
         * @param  string  the connection technology revision
         *
         * @access public
         */
        function setConnectionTechnology($connection_technology, $connection_technology_version)
        {
            $this->connection_technology         = $connection_technology;
            $this->connection_technology_version = $connection_technology_version;
        } // end of the "setConnectionTechnology()" function


        /**
         * Appends the connection technology used
         *
         * @param  string  the connection technology name
         * @param  string  the connection technology revision
         *
         * @access public
         */
        function appendConnectionTechnology($connection_technology, $connection_technology_version)
        {
            $this->connection_technology         .= ' - ' . $connection_technology;
            $this->connection_technology_version .= ' - ' . $connection_technology_version;
        } // end of the "appendConnectionTechnology()" function


        /**
         * Sets whether interactive mode should be used or not
         *
         * @param  integer  whether interactive mode should be used or not
         *
         * @access public
         */
        function setInteractive($interactive)
        {
            $this->interactive = $interactive;
        } // end of the "setInteractive()" function


        /**
         * Sets the output type to use
         *
         * @param  string  the output type to use
         *
         * @access public
         */
        function setOutputType($output_type)
        {
            $this->output_type = $output_type;
        } // end of the "setOutputType()" function


        /**
         * Starts service
         *
         * @access public
         */
        function startService()
        {

            $this->service_link = $this->_openService($this->url . '/' . $this->service_name . $this->wsdl);

        } // end of the "startService()" function


        /**
         * Starts session
         *
         * @access public
         */
        function startSession()
        {
            $this->session_data = $this->_openSession($this->service_link, $this->username, $this->password,
                                                              $this->calling_program, $this->calling_program_version,
                                                              $this->target_dbms, $this->target_dbms_version,
                                                              $this->connection_technology, $this->connection_technology_version,
                                                              $this->interactive);

            if (isset($this->session_data) && ($this->session_data != null)
                && ($this->session_data->target != $this->url)) {
                // Reopens the service on the new URL that was provided
                $url = $this->session_data->target;
                $this->startService();
            }
        } // end of the "startSession()" function


        /**
         * Do start service and session
         *
         * @access public
         */
        function start()
        {
            $this->startService();
            $this->startSession();
        } // end of the "start()" function


        /**
         * Call to determine just if a query is valid or not.
         *
         * @param  string SQL statement to validate
         *
         * @return string Validator string from Mimer
         *
         * @see _validate
         */
        function isValid($sql)
        {
            $res = $this->_validate($sql);
            return $res->standard;
        } // end of the "isValid()" function


        /**
         * Call for complete validator response
         *
         * @param  string SQL statement to validate
         *
         * @return string Validator string from Mimer
         *
         * @see _validate
         */
        function validationString($sql)
        {
            $res = $this->_validate($sql);
            return $res->data;

        } // end of the "validationString()" function
    } // end class PMA_SQLValidator

    //add an extra check to ensure that the class was defined without errors
    if (!class_exists('PMA_SQLValidator')) {
        $GLOBALS['sqlvalidator_error'] = TRUE;
    }

} // end else

?>
