<?php

//   -------------------------------------------------------------------------------
//  |                  net2ftp: a web based FTP client                              |
//  |              Copyright (c) 2003-2009 by David Gartner                         |
//  |                                                                               |
//  | This program is free software; you can redistribute it and/or                 |
//  | modify it under the terms of the GNU General Public License                   |
//  | as published by the Free Software Foundation; either version 2                |
//  | of the License, or (at your option) any later version.                        |
//  |                                                                               |
//   -------------------------------------------------------------------------------

//   -------------------------------------------------------------------------------
//  | For credits, see the credits.txt file                                         |
//   -------------------------------------------------------------------------------
//  |                                                                               |
//  |                              INSTRUCTIONS                                     |
//  |                                                                               |
//  |  The messages to translate are listed below.                                  |
//  |  The structure of each line is like this:                                     |
//  |     $message["Hello world!"] = "Hello world!";                                |
//  |                                                                               |
//  |  Keep the text between square brackets [] as it is.                           |
//  |  Translate the 2nd part, keeping the same punctuation and HTML tags.          |
//  |                                                                               |
//  |  The English message, for example                                             |
//  |     $message["net2ftp is written in PHP!"] = "net2ftp is written in PHP!";    |
//  |  should become after translation:                                             |
//  |     $message["net2ftp is written in PHP!"] = "net2ftp est ecrit en PHP!";     |
//  |     $message["net2ftp is written in PHP!"] = "net2ftp is geschreven in PHP!"; |
//  |                                                                               |
//  |  Note that the variable starts with a dollar sign $, that the value is        |
//  |  enclosed in double quotes " and that the line ends with a semi-colon ;       |
//  |  Be careful when editing this file, do not erase those special characters.    |
//  |                                                                               |
//  |  Some messages also contain one or more variables which start with a percent  |
//  |  sign, for example %1\$s or %2\$s. The English message, for example           |
//  |     $messages[...] = ["The file %1\$s was copied to %2\$s "]                  |
//  |  should becomes after translation:                                            |
//  |     $messages[...] = ["Le fichier %1\$s a �t� copi� vers %2\$s "]             |
//  |                                                                               |
//  |  When a real percent sign % is needed in the text it is entered as %%         |
//  |  otherwise it is interpreted as a variable. So no, it's not a mistake.        |
//  |                                                                               |
//  |  Between the messages to translate there is additional PHP code, for example: |
//  |      if ($net2ftp_globals["state2"] == "rename") {           // <-- PHP code  |
//  |          $net2ftp_messages["Rename file"] = "Rename file";   // <-- message   |
//  |      }                                                       // <-- PHP code  |
//  |  This code is needed to load the messages only when they are actually needed. |
//  |  There is no need to change or delete any of that PHP code; translate only    |
//  |  the message.                                                                 |
//  |                                                                               |
//  |  Thanks in advance to all the translators!                                    |
//  |  David.                                                                       |
//  |                                                                               |
//   -------------------------------------------------------------------------------


// -------------------------------------------------------------------------
// Language settings
// -------------------------------------------------------------------------

// HTML lang attribute
$net2ftp_messages["en"] = "da";

// HTML dir attribute: left-to-right (LTR) or right-to-left (RTL)
$net2ftp_messages["ltr"] = "ltr";

// CSS style: align left or right (use in combination with LTR or RTL)
$net2ftp_messages["left"] = "left";
$net2ftp_messages["right"] = "right";

// Encoding
$net2ftp_messages["iso-8859-1"] = "UTF-8";


// -------------------------------------------------------------------------
// Status messages
// -------------------------------------------------------------------------

// When translating these messages, keep in mind that the text should not be too long
// It should fit in the status textbox

$net2ftp_messages["Connecting to the FTP server"] = "Forbinder til FTP serveren";
$net2ftp_messages["Logging into the FTP server"] = "Logger p&aring; FTP serveren";
$net2ftp_messages["Setting the passive mode"] = "Sætter passiv modus";
$net2ftp_messages["Getting the FTP system type"] = "Henter FTP system type";
$net2ftp_messages["Changing the directory"] = "Ændrer mappevisning";
$net2ftp_messages["Getting the current directory"] = "Henter aktuelle mappevisning";
$net2ftp_messages["Getting the list of directories and files"] = "Henter liste over mapper og filer";
$net2ftp_messages["Parsing the list of directories and files"] = "Indsætter liste over mapper og filer";
$net2ftp_messages["Logging out of the FTP server"] = "Logger af FTP serveren";
$net2ftp_messages["Getting the list of directories and files"] = "Henter liste over mapper og filer";
$net2ftp_messages["Printing the list of directories and files"] = "Viser liste over mapper og filer";
$net2ftp_messages["Processing the entries"] = "Bearbejder opgaver";
$net2ftp_messages["Processing entry %1\$s"] = "Bearbejder opgave %1\$s";
$net2ftp_messages["Checking files"] = "Kontrollerer filer";
$net2ftp_messages["Transferring files to the FTP server"] = "Overfører filer til FTP serveren";
$net2ftp_messages["Decompressing archives and transferring files"] = "Udpakker arkiver og overfører filer";
$net2ftp_messages["Searching the files..."] = "Søger i filer...";
$net2ftp_messages["Uploading new file"] = "Uploader ny fil";
$net2ftp_messages["Reading the file"] = "Læser fil";
$net2ftp_messages["Parsing the file"] = "Indsætter fil";
$net2ftp_messages["Reading the new file"] = "Læser den nye fil";
$net2ftp_messages["Reading the old file"] = "Læser den gamle fil";
$net2ftp_messages["Comparing the 2 files"] = "Sammenligner filer";
$net2ftp_messages["Printing the comparison"] = "Viser sammenligning";
$net2ftp_messages["Sending FTP command %1\$s of %2\$s"] = "Sender FTP kommando %1\$s ud af %2\$s";
$net2ftp_messages["Getting archive %1\$s of %2\$s from the FTP server"] = "Henter %1\$s ud af %2\$s arkiver fra FTP serveren";
$net2ftp_messages["Creating a temporary directory on the FTP server"] = "Opretter midlertidig mappe på FTP serveren";
$net2ftp_messages["Setting the permissions of the temporary directory"] = "Retter tilladelser for den midlertidige mappe";
$net2ftp_messages["Copying the net2ftp installer script to the FTP server"] = "Kopierer net2ftp installer scriptet til FTP serveren";
$net2ftp_messages["Script finished in %1\$s seconds"] = "Script udført om %1\$s sekunder";
$net2ftp_messages["Script halted"] = "Script afbrudt";

// Used on various screens
$net2ftp_messages["Please wait..."] = "Vent venligst...";


// -------------------------------------------------------------------------
// index.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unexpected state string: %1\$s. Exiting."] = "Uventet strengtilstand: %1\$s. Afbryder.";
$net2ftp_messages["This beta function is not activated on this server."] = "Denne beta funktion er ikke aktiveret på denne server.";
$net2ftp_messages["This function has been disabled by the Administrator of this website."] = "Denne funktion er blevet deaktiveret af websidens administrator.";


// -------------------------------------------------------------------------
// /includes/browse.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["The directory <b>%1\$s</b> does not exist or could not be selected, so the directory <b>%2\$s</b> is shown instead."] = "Mappen <b>%1\$s</b> findes enten ikke, eller kunne ikke hentes, mappen <b>%2\$s</b> vises i stedet for.";
$net2ftp_messages["Your root directory <b>%1\$s</b> does not exist or could not be selected."] = "Rodmappen <b>%1\$s</b> findes enten ikke eller kunne ikke hentes.";
$net2ftp_messages["The directory <b>%1\$s</b> could not be selected - you may not have sufficient rights to view this directory, or it may not exist."] = "Mappen <b>%1\$s</b> kunne ikke hentes - du har måske ikke tilstrækkelige rettigheder for at se denne mappe, eller også findes mappen ikke.";
$net2ftp_messages["Entries which contain banned keywords can't be managed using net2ftp. This is to avoid Paypal or Ebay scams from being uploaded through net2ftp."] = "Mapper og filer der indeholder blokkerede nøgleord kan ikke håndteres i net2ftp. Dette er for at undgå misbrug med bl.a. Paypal eller Ebay.";
$net2ftp_messages["Files which are too big can't be downloaded, uploaded, copied, moved, searched, zipped, unzipped, viewed or edited; they can only be renamed, chmodded or deleted."] = "Filer som er for store kan ikke downloades, uploades, kopieres, flyttes, gennemsøges, komprimeres, udpakkes, vises eller redigeres. De kan kun omdøbes, slettes eller du kan rette filens chmod-rettigheder.";
$net2ftp_messages["Execute %1\$s in a new window"] = "Udfør %1\$s i et nyt vindue";


// -------------------------------------------------------------------------
// /includes/main.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Please select at least one directory or file!"] = "Vælg mindst en mappe eller fil!";


// -------------------------------------------------------------------------
// /includes/authorizations.inc.php
// -------------------------------------------------------------------------

// checkAuthorization()
$net2ftp_messages["The FTP server <b>%1\$s</b> is not in the list of allowed FTP servers."] = "FTP serveren <b>%1\$s</b> er ikke på listen over tilladte FTP servere.";
$net2ftp_messages["The FTP server <b>%1\$s</b> is in the list of banned FTP servers."] = "FTP serveren <b>%1\$s</b> er på listen over blokerede FTP servere.";
$net2ftp_messages["The FTP server port %1\$s may not be used."] = "FTP serverporten: %1\$s kan ikke benyttes.";
$net2ftp_messages["Your IP address (%1\$s) is not in the list of allowed IP addresses."] = "Din IP adresse (%1\$s) er ikke på listen over tilladte IP adresser.";
$net2ftp_messages["Your IP address (%1\$s) is in the list of banned IP addresses."] = "Din IP adresse (%1\$s) er på listen over blokerede IP adresser.";

// isAuthorizedDirectory()
$net2ftp_messages["Table net2ftp_users contains duplicate rows."] = "Tabellen net2ftp_users Indeholder dubletter.";

// logAccess(), logLogin(), logError()
$net2ftp_messages["Unable to execute the SQL query."] = "Kunne ikke udføre SQL forespørgsel.";
$net2ftp_messages["Unable to open the system log."] = "Kan ikke åbne system loggen.";
$net2ftp_messages["Unable to write a message to the system log."] = "Kan ikke skrive i system loggen.";

// checkAdminUsernamePassword()
$net2ftp_messages["You did not enter your Administrator username or password."] = "Du fik ikke indtastet dit brugernavn eller din adgangskode.";
$net2ftp_messages["Wrong username or password. Please try again."] = "Forkert brugernavn eller adgangskode. Prøv igen.";


// -------------------------------------------------------------------------
// /includes/consumption.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unable to determine your IP address."] = "Kan ikke afgøre din IP adresses ophav.";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress contains duplicate rows."] = "Tabellen net2ftp_log_consumption_ipaddress indeholder dubletter.";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver contains duplicate rows."] = "Tabellen net2ftp_log_consumption_ftpserver indeholder dubletter.";
$net2ftp_messages["The variable <b>consumption_ipaddress_datatransfer</b> is not numeric."] = "Variablen  <b>consumption_ipaddress_datatransfer</b> er ikke nummerisk.";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress could not be updated."] = "Tabellen net2ftp_log_consumption_ipaddress kunne ikke opdateres.";
$net2ftp_messages["Table net2ftp_log_consumption_ipaddress contains duplicate entries."] = "Tabellen net2ftp_log_consumption_ipaddress indeholder dubletter.";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver could not be updated."] = "Tabellen net2ftp_log_consumption_ftpserver kunne ikke opdateres.";
$net2ftp_messages["Table net2ftp_log_consumption_ftpserver contains duplicate entries."] = "Tabellen net2ftp_log_consumption_ftpserver indeholder dubletter.";
$net2ftp_messages["Table net2ftp_log_access could not be updated."] = "Tabellen net2ftp_log_access kunne ikke opdateres.";
$net2ftp_messages["Table net2ftp_log_access contains duplicate entries."] = "Tabellen net2ftp_log_access indeholder dubletter.";


// -------------------------------------------------------------------------
// /includes/database.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Unable to connect to the MySQL database. Please check your MySQL database settings in net2ftp's configuration file settings.inc.php."] = "Kunne ikke få forbindelse til MySQL databasen. Kontrollér dine MySQL indstillinger i net2ftp's konfigurationsfil settings.inc.php.";
$net2ftp_messages["Unable to select the MySQL database. Please check your MySQL database settings in net2ftp's configuration file settings.inc.php."] = "Kunne ikke vælge MySQL databasen. Kontrollér dine MySQL indstillinger i net2ftp's konfigurationsfil settings.inc.php.";


// -------------------------------------------------------------------------
// /includes/errorhandling.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["An error has occured"] = "En fejl er opstået";
$net2ftp_messages["Go back"] = "Tilbage";
$net2ftp_messages["Go to the login page"] = "Gå til login siden";


// -------------------------------------------------------------------------
// /includes/filesystem.inc.php
// -------------------------------------------------------------------------

// ftp_openconnection()
$net2ftp_messages["The <a href=\"http://www.php.net/manual/en/ref.ftp.php\" target=\"_blank\">FTP module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this FTP module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ref.ftp.php\" target=\"_blank\">php.net</a><br />"] = "The <a href=\"http://www.php.net/manual/en/ref.ftp.php\" target=\"_blank\">FTP module of PHP</a> is not installed.<br /><br /> The administrator of this website should install this FTP module. Installation instructions are given on <a href=\"http://www.php.net/manual/en/ref.ftp.php\" target=\"_blank\">php.net</a><br />";
$net2ftp_messages["Unable to connect to FTP server <b>%1\$s</b> on port <b>%2\$s</b>.<br /><br />Are you sure this is the address of the FTP server? This is often different from that of the HTTP (web) server. Please contact your ISP helpdesk or system administrator for help.<br />"] = "Unable to connect to FTP server <b>%1\$s</b> on port <b>%2\$s</b>.<br /><br />Are you sure this is the address of the FTP server? This is often different from that of the HTTP (web) server. Please contact your ISP helpdesk or system administrator for help.<br />";
$net2ftp_messages["Unable to login to FTP server <b>%1\$s</b> with username <b>%2\$s</b>.<br /><br />Are you sure your username and password are correct? Please contact your ISP helpdesk or system administrator for help.<br />"] = "Unable to login to FTP server <b>%1\$s</b> with username <b>%2\$s</b>.<br /><br />Are you sure your username and password are correct? Please contact your ISP helpdesk or system administrator for help.<br />";
$net2ftp_messages["Unable to switch to the passive mode on FTP server <b>%1\$s</b>."] = "Unable to switch to the passive mode on FTP server <b>%1\$s</b>.";

// ftp_openconnection2()
$net2ftp_messages["Unable to connect to the second (target) FTP server <b>%1\$s</b> on port <b>%2\$s</b>.<br /><br />Are you sure this is the address of the second (target) FTP server? This is often different from that of the HTTP (web) server. Please contact your ISP helpdesk or system administrator for help.<br />"] = "Unable to connect to the second (target) FTP server <b>%1\$s</b> on port <b>%2\$s</b>.<br /><br />Are you sure this is the address of the second (target) FTP server? This is often different from that of the HTTP (web) server. Please contact your ISP helpdesk or system administrator for help.<br />";
$net2ftp_messages["Unable to login to the second (target) FTP server <b>%1\$s</b> with username <b>%2\$s</b>.<br /><br />Are you sure your username and password are correct? Please contact your ISP helpdesk or system administrator for help.<br />"] = "Unable to login to the second (target) FTP server <b>%1\$s</b> with username <b>%2\$s</b>.<br /><br />Are you sure your username and password are correct? Please contact your ISP helpdesk or system administrator for help.<br />";
$net2ftp_messages["Unable to switch to the passive mode on the second (target) FTP server <b>%1\$s</b>."] = "Unable to switch to the passive mode on the second (target) FTP server <b>%1\$s</b>.";

// ftp_myrename()
$net2ftp_messages["Unable to rename directory or file <b>%1\$s</b> into <b>%2\$s</b>"] = "Unable to rename directory or file <b>%1\$s</b> into <b>%2\$s</b>";

// ftp_mychmod()
$net2ftp_messages["Unable to execute site command <b>%1\$s</b>. Note that the CHMOD command is only available on Unix FTP servers, not on Windows FTP servers."] = "Unable to execute site command <b>%1\$s</b>. Note that the CHMOD command is only available on Unix FTP servers, not on Windows FTP servers.";
$net2ftp_messages["Directory <b>%1\$s</b> successfully chmodded to <b>%2\$s</b>"] = "Directory <b>%1\$s</b> successfully chmodded to <b>%2\$s</b>";
$net2ftp_messages["Processing entries within directory <b>%1\$s</b>:"] = "Processing entries within directory <b>%1\$s</b>:";
$net2ftp_messages["File <b>%1\$s</b> was successfully chmodded to <b>%2\$s</b>"] = "File <b>%1\$s</b> was successfully chmodded to <b>%2\$s</b>";
$net2ftp_messages["All the selected directories and files have been processed."] = "All the selected directories and files have been processed.";

// ftp_rmdir2()
$net2ftp_messages["Unable to delete the directory <b>%1\$s</b>"] = "Unable to delete the directory <b>%1\$s</b>";

// ftp_delete2()
$net2ftp_messages["Unable to delete the file <b>%1\$s</b>"] = "Unable to delete the file <b>%1\$s</b>";

// ftp_newdirectory()
$net2ftp_messages["Unable to create the directory <b>%1\$s</b>"] = "Unable to create the directory <b>%1\$s</b>";

// ftp_readfile()
$net2ftp_messages["Unable to create the temporary file"] = "Unable to create the temporary file";
$net2ftp_messages["Unable to get the file <b>%1\$s</b> from the FTP server and to save it as temporary file <b>%2\$s</b>.<br />Check the permissions of the %3\$s directory.<br />"] = "Unable to get the file <b>%1\$s</b> from the FTP server and to save it as temporary file <b>%2\$s</b>.<br />Check the permissions of the %3\$s directory.<br />";
$net2ftp_messages["Unable to open the temporary file. Check the permissions of the %1\$s directory."] = "Unable to open the temporary file. Check the permissions of the %1\$s directory.";
$net2ftp_messages["Unable to read the temporary file"] = "Unable to read the temporary file";
$net2ftp_messages["Unable to close the handle of the temporary file"] = "Unable to close the handle of the temporary file";
$net2ftp_messages["Unable to delete the temporary file"] = "Unable to delete the temporary file";

// ftp_writefile()
$net2ftp_messages["Unable to create the temporary file. Check the permissions of the %1\$s directory."] = "Unable to create the temporary file. Check the permissions of the %1\$s directory.";
$net2ftp_messages["Unable to open the temporary file. Check the permissions of the %1\$s directory."] = "Unable to open the temporary file. Check the permissions of the %1\$s directory.";
$net2ftp_messages["Unable to write the string to the temporary file <b>%1\$s</b>.<br />Check the permissions of the %2\$s directory."] = "Unable to write the string to the temporary file <b>%1\$s</b>.<br />Check the permissions of the %2\$s directory.";
$net2ftp_messages["Unable to close the handle of the temporary file"] = "Unable to close the handle of the temporary file";
$net2ftp_messages["Unable to put the file <b>%1\$s</b> on the FTP server.<br />You may not have write permissions on the directory."] = "Unable to put the file <b>%1\$s</b> on the FTP server.<br />You may not have write permissions on the directory.";
$net2ftp_messages["Unable to delete the temporary file"] = "Unable to delete the temporary file";

// ftp_copymovedelete()
$net2ftp_messages["Processing directory <b>%1\$s</b>"] = "Processing directory <b>%1\$s</b>";
$net2ftp_messages["The target directory <b>%1\$s</b> is the same as or a subdirectory of the source directory <b>%2\$s</b>, so this directory will be skipped"] = "The target directory <b>%1\$s</b> is the same as or a subdirectory of the source directory <b>%2\$s</b>, so this directory will be skipped";
$net2ftp_messages["The directory <b>%1\$s</b> contains a banned keyword, so this directory will be skipped"] = "The directory <b>%1\$s</b> contains a banned keyword, so this directory will be skipped";
$net2ftp_messages["The directory <b>%1\$s</b> contains a banned keyword, aborting the move"] = "The directory <b>%1\$s</b> contains a banned keyword, aborting the move";
$net2ftp_messages["Unable to create the subdirectory <b>%1\$s</b>. It may already exist. Continuing the copy/move process..."] = "Unable to create the subdirectory <b>%1\$s</b>. It may already exist. Continuing the copy/move process...";
$net2ftp_messages["Created target subdirectory <b>%1\$s</b>"] = "Created target subdirectory <b>%1\$s</b>";
$net2ftp_messages["The directory <b>%1\$s</b> could not be selected, so this directory will be skipped"] = "The directory <b>%1\$s</b> could not be selected, so this directory will be skipped";
$net2ftp_messages["Unable to delete the subdirectory <b>%1\$s</b> - it may not be empty"] = "Unable to delete the subdirectory <b>%1\$s</b> - it may not be empty";
$net2ftp_messages["Deleted subdirectory <b>%1\$s</b>"] = "Deleted subdirectory <b>%1\$s</b>";
$net2ftp_messages["Processing of directory <b>%1\$s</b> completed"] = "Processing of directory <b>%1\$s</b> completed";
$net2ftp_messages["The target for file <b>%1\$s</b> is the same as the source, so this file will be skipped"] = "The target for file <b>%1\$s</b> is the same as the source, so this file will be skipped";
$net2ftp_messages["The file <b>%1\$s</b> contains a banned keyword, so this file will be skipped"] = "The file <b>%1\$s</b> contains a banned keyword, so this file will be skipped";
$net2ftp_messages["The file <b>%1\$s</b> contains a banned keyword, aborting the move"] = "The file <b>%1\$s</b> contains a banned keyword, aborting the move";
$net2ftp_messages["The file <b>%1\$s</b> is too big to be copied, so this file will be skipped"] = "The file <b>%1\$s</b> is too big to be copied, so this file will be skipped";
$net2ftp_messages["The file <b>%1\$s</b> is too big to be moved, aborting the move"] = "The file <b>%1\$s</b> is too big to be moved, aborting the move";
$net2ftp_messages["Unable to copy the file <b>%1\$s</b>"] = "Unable to copy the file <b>%1\$s</b>";
$net2ftp_messages["Copied file <b>%1\$s</b>"] = "Copied file <b>%1\$s</b>";
$net2ftp_messages["Unable to move the file <b>%1\$s</b>, aborting the move"] = "Unable to move the file <b>%1\$s</b>, aborting the move";
$net2ftp_messages["Moved file <b>%1\$s</b>"] = "Moved file <b>%1\$s</b>";
$net2ftp_messages["Unable to delete the file <b>%1\$s</b>"] = "Unable to delete the file <b>%1\$s</b>";
$net2ftp_messages["Deleted file <b>%1\$s</b>"] = "Deleted file <b>%1\$s</b>";
$net2ftp_messages["All the selected directories and files have been processed."] = "All the selected directories and files have been processed.";

// ftp_processfiles()

// ftp_getfile()
$net2ftp_messages["Unable to copy the remote file <b>%1\$s</b> to the local file using FTP mode <b>%2\$s</b>"] = "Unable to copy the remote file <b>%1\$s</b> to the local file using FTP mode <b>%2\$s</b>";
$net2ftp_messages["Unable to delete file <b>%1\$s</b>"] = "Unable to delete file <b>%1\$s</b>";

// ftp_putfile()
$net2ftp_messages["The file is too big to be transferred"] = "The file is too big to be transferred";
$net2ftp_messages["Daily limit reached: the file <b>%1\$s</b> will not be transferred"] = "Daily limit reached: the file <b>%1\$s</b> will not be transferred";
$net2ftp_messages["Unable to copy the local file to the remote file <b>%1\$s</b> using FTP mode <b>%2\$s</b>"] = "Unable to copy the local file to the remote file <b>%1\$s</b> using FTP mode <b>%2\$s</b>";
$net2ftp_messages["Unable to delete the local file"] = "Unable to delete the local file";

// ftp_downloadfile()
$net2ftp_messages["Unable to delete the temporary file"] = "Unable to delete the temporary file";
$net2ftp_messages["Unable to send the file to the browser"] = "Unable to send the file to the browser";

// ftp_zip()
$net2ftp_messages["Unable to create the temporary file"] = "Unable to create the temporary file";
$net2ftp_messages["The zip file has been saved on the FTP server as <b>%1\$s</b>"] = "The zip file has been saved on the FTP server as <b>%1\$s</b>";
$net2ftp_messages["Requested files"] = "Requested files";

$net2ftp_messages["Dear,"] = "Dear,";
$net2ftp_messages["Someone has requested the files in attachment to be sent to this email account (%1\$s)."] = "Someone has requested the files in attachment to be sent to this email account (%1\$s).";
$net2ftp_messages["If you know nothing about this or if you don't trust that person, please delete this email without opening the Zip file in attachment."] = "If you know nothing about this or if you don't trust that person, please delete this email without opening the Zip file in attachment.";
$net2ftp_messages["Note that if you don't open the Zip file, the files inside cannot harm your computer."] = "Note that if you don't open the Zip file, the files inside cannot harm your computer.";
$net2ftp_messages["Information about the sender: "] = "Information about the sender: ";
$net2ftp_messages["IP address: "] = "IP address: ";
$net2ftp_messages["Time of sending: "] = "Time of sending: ";
$net2ftp_messages["Sent via the net2ftp application installed on this website: "] = "Sent via the net2ftp application installed on this website: ";
$net2ftp_messages["Webmaster's email: "] = "Webmaster's email: ";
$net2ftp_messages["Message of the sender: "] = "Message of the sender: ";
$net2ftp_messages["net2ftp is free software, released under the GNU/GPL license. For more information, go to http://www.net2ftp.com."] = "net2ftp is free software, released under the GNU/GPL license. For more information, go to http://www.net2ftp.com.";

$net2ftp_messages["The zip file has been sent to <b>%1\$s</b>."] = "The zip file has been sent to <b>%1\$s</b>.";

// acceptFiles()
$net2ftp_messages["File <b>%1\$s</b> is too big. This file will not be uploaded."] = "File <b>%1\$s</b> is too big. This file will not be uploaded.";
$net2ftp_messages["File <b>%1\$s</b> is contains a banned keyword. This file will not be uploaded."] = "File <b>%1\$s</b> is contains a banned keyword. This file will not be uploaded.";
$net2ftp_messages["Could not generate a temporary file."] = "Could not generate a temporary file.";
$net2ftp_messages["File <b>%1\$s</b> could not be moved"] = "File <b>%1\$s</b> could not be moved";
$net2ftp_messages["File <b>%1\$s</b> is OK"] = "File <b>%1\$s</b> is OK";
$net2ftp_messages["Unable to move the uploaded file to the temp directory.<br /><br />The administrator of this website has to <b>chmod 777</b> the /temp directory of net2ftp."] = "Unable to move the uploaded file to the temp directory.<br /><br />The administrator of this website has to <b>chmod 777</b> the /temp directory of net2ftp.";
$net2ftp_messages["You did not provide any file to upload."] = "You did not provide any file to upload.";

// ftp_transferfiles()
$net2ftp_messages["File <b>%1\$s</b> could not be transferred to the FTP server"] = "File <b>%1\$s</b> could not be transferred to the FTP server";
$net2ftp_messages["File <b>%1\$s</b> has been transferred to the FTP server using FTP mode <b>%2\$s</b>"] = "File <b>%1\$s</b> has been transferred to the FTP server using FTP mode <b>%2\$s</b>";
$net2ftp_messages["Transferring files to the FTP server"] = "Overfører filer til FTP serveren";

// ftp_unziptransferfiles()
$net2ftp_messages["Processing archive nr %1\$s: <b>%2\$s</b>"] = "Processing archive nr %1\$s: <b>%2\$s</b>";
$net2ftp_messages["Archive <b>%1\$s</b> was not processed because its filename extension was not recognized. Only zip, tar, tgz and gz archives are supported at the moment."] = "Archive <b>%1\$s</b> was not processed because its filename extension was not recognized. Only zip, tar, tgz and gz archives are supported at the moment.";
$net2ftp_messages["Unable to extract the files and directories from the archive"] = "Unable to extract the files and directories from the archive";
$net2ftp_messages["Archive contains filenames with ../ or ..\\ - aborting the extraction"] = "Archive contains filenames with ../ or ..\\ - aborting the extraction";
$net2ftp_messages["Created directory %1\$s"] = "Created directory %1\$s";
$net2ftp_messages["Could not create directory %1\$s"] = "Could not create directory %1\$s";
$net2ftp_messages["Copied file %1\$s"] = "Copied file %1\$s";
$net2ftp_messages["Could not copy file %1\$s"] = "Could not copy file %1\$s";
$net2ftp_messages["Unable to delete the temporary directory"] = "Unable to delete the temporary directory";
$net2ftp_messages["Unable to delete the temporary file %1\$s"] = "Unable to delete the temporary file %1\$s";

// ftp_mysite()
$net2ftp_messages["Unable to execute site command <b>%1\$s</b>"] = "Unable to execute site command <b>%1\$s</b>";

// shutdown()
$net2ftp_messages["Your task was stopped"] = "Your task was stopped";
$net2ftp_messages["The task you wanted to perform with net2ftp took more time than the allowed %1\$s seconds, and therefor that task was stopped."] = "The task you wanted to perform with net2ftp took more time than the allowed %1\$s seconds, and therefor that task was stopped.";
$net2ftp_messages["This time limit guarantees the fair use of the web server for everyone."] = "This time limit guarantees the fair use of the web server for everyone.";
$net2ftp_messages["Try to split your task in smaller tasks: restrict your selection of files, and omit the biggest files."] = "Try to split your task in smaller tasks: restrict your selection of files, and omit the biggest files.";
$net2ftp_messages["If you really need net2ftp to be able to handle big tasks which take a long time, consider installing net2ftp on your own server."] = "If you really need net2ftp to be able to handle big tasks which take a long time, consider installing net2ftp on your own server.";

// SendMail()
$net2ftp_messages["You did not provide any text to send by email!"] = "You did not provide any text to send by email!";
$net2ftp_messages["You did not supply a From address."] = "You did not supply a From address.";
$net2ftp_messages["You did not supply a To address."] = "You did not supply a To address.";
$net2ftp_messages["Due to technical problems the email to <b>%1\$s</b> could not be sent."] = "Due to technical problems the email to <b>%1\$s</b> could not be sent.";


// -------------------------------------------------------------------------
// /includes/registerglobals.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Please enter your username and password for FTP server "] = "Please enter your username and password for FTP server ";
$net2ftp_messages["You did not fill in your login information in the popup window.<br />Click on \"Go to the login page\" below."] = "You did not fill in your login information in the popup window.<br />Click on \"Go to the login page\" below.";
$net2ftp_messages["Access to the net2ftp Admin panel is disabled, because no password has been set in the file settings.inc.php. Enter a password in that file, and reload this page."] = "Access to the net2ftp Admin panel is disabled, because no password has been set in the file settings.inc.php. Enter a password in that file, and reload this page.";
$net2ftp_messages["Please enter your Admin username and password"] = "Please enter your Admin username and password"; 
$net2ftp_messages["You did not fill in your login information in the popup window.<br />Click on \"Go to the login page\" below."] = "You did not fill in your login information in the popup window.<br />Click on \"Go to the login page\" below.";
$net2ftp_messages["Wrong username or password for the net2ftp Admin panel. The username and password can be set in the file settings.inc.php."] = "Wrong username or password for the net2ftp Admin panel. The username and password can be set in the file settings.inc.php.";


// -------------------------------------------------------------------------
// /skins/skins.inc.php
// -------------------------------------------------------------------------
$net2ftp_messages["Blue"] = "Blå";
$net2ftp_messages["Grey"] = "Grå";
$net2ftp_messages["Black"] = "Sort";
$net2ftp_messages["Yellow"] = "Gul";
$net2ftp_messages["Pastel"] = "Pastel";

// getMime()
$net2ftp_messages["Directory"] = "Mappe";
$net2ftp_messages["Symlink"] = "Symlink";
$net2ftp_messages["ASP script"] = "ASP script";
$net2ftp_messages["Cascading Style Sheet"] = "Cascading Style Sheet";
$net2ftp_messages["HTML file"] = "HTML fil";
$net2ftp_messages["Java source file"] = "Java source fil";
$net2ftp_messages["JavaScript file"] = "JavaScript fil";
$net2ftp_messages["PHP Source"] = "PHP Source";
$net2ftp_messages["PHP script"] = "PHP script";
$net2ftp_messages["Text file"] = "Tekstfil";
$net2ftp_messages["Bitmap file"] = "Bitmap fil";
$net2ftp_messages["GIF file"] = "GIF fil";
$net2ftp_messages["JPEG file"] = "JPEG fil";
$net2ftp_messages["PNG file"] = "PNG fil";
$net2ftp_messages["TIF file"] = "TIF fil";
$net2ftp_messages["GIMP file"] = "GIMP fil";
$net2ftp_messages["Executable"] = "Program";
$net2ftp_messages["Shell script"] = "Shell script";
$net2ftp_messages["MS Office - Word document"] = "MS Office - Word dokument";
$net2ftp_messages["MS Office - Excel spreadsheet"] = "MS Office - Excel regneark";
$net2ftp_messages["MS Office - PowerPoint presentation"] = "MS Office - PowerPoint præsentation";
$net2ftp_messages["MS Office - Access database"] = "MS Office - Access database";
$net2ftp_messages["MS Office - Visio drawing"] = "MS Office - Visio tegning";
$net2ftp_messages["MS Office - Project file"] = "MS Office - Project fil";
$net2ftp_messages["OpenOffice - Writer 6.0 document"] = "OpenOffice - Writer 6.0 dokument";
$net2ftp_messages["OpenOffice - Writer 6.0 template"] = "OpenOffice - Writer 6.0 skabelon";
$net2ftp_messages["OpenOffice - Calc 6.0 spreadsheet"] = "OpenOffice - Calc 6.0 regneark";
$net2ftp_messages["OpenOffice - Calc 6.0 template"] = "OpenOffice - Calc 6.0 skabelon";
$net2ftp_messages["OpenOffice - Draw 6.0 document"] = "OpenOffice - Draw 6.0 dokument";
$net2ftp_messages["OpenOffice - Draw 6.0 template"] = "OpenOffice - Draw 6.0 skabelon";
$net2ftp_messages["OpenOffice - Impress 6.0 presentation"] = "OpenOffice - Impress 6.0 præsentation";
$net2ftp_messages["OpenOffice - Impress 6.0 template"] = "OpenOffice - Impress 6.0 skabelon";
$net2ftp_messages["OpenOffice - Writer 6.0 global document"] = "OpenOffice - Writer 6.0 globalt dokument";
$net2ftp_messages["OpenOffice - Math 6.0 document"] = "OpenOffice - Math 6.0 dokument";
$net2ftp_messages["StarOffice - StarWriter 5.x document"] = "StarOffice - StarWriter 5.x dokument";
$net2ftp_messages["StarOffice - StarWriter 5.x global document"] = "StarOffice - StarWriter 5.x globalt dokument";
$net2ftp_messages["StarOffice - StarCalc 5.x spreadsheet"] = "StarOffice - StarCalc 5.x regneark";
$net2ftp_messages["StarOffice - StarDraw 5.x document"] = "StarOffice - StarDraw 5.x dokument";
$net2ftp_messages["StarOffice - StarImpress 5.x presentation"] = "StarOffice - StarImpress 5.x præsentation";
$net2ftp_messages["StarOffice - StarImpress Packed 5.x file"] = "StarOffice - StarImpress pakket 5.x fil";
$net2ftp_messages["StarOffice - StarMath 5.x document"] = "StarOffice - StarMath 5.x dokument";
$net2ftp_messages["StarOffice - StarChart 5.x document"] = "StarOffice - StarChart 5.x dokument";
$net2ftp_messages["StarOffice - StarMail 5.x mail file"] = "StarOffice - StarMail 5.x mail fil";
$net2ftp_messages["Adobe Acrobat document"] = "Adobe Acrobat dokument";
$net2ftp_messages["ARC archive"] = "ARC arkiv";
$net2ftp_messages["ARJ archive"] = "ARJ arkiv";
$net2ftp_messages["RPM"] = "RPM";
$net2ftp_messages["GZ archive"] = "GZ arkiv";
$net2ftp_messages["TAR archive"] = "TAR arkiv";
$net2ftp_messages["Zip archive"] = "Zip arkiv";
$net2ftp_messages["MOV movie file"] = "MOV film";
$net2ftp_messages["MPEG movie file"] = "MPEG film";
$net2ftp_messages["Real movie file"] = "Real film";
$net2ftp_messages["Quicktime movie file"] = "Quicktime film";
$net2ftp_messages["Shockwave flash file"] = "Shockwave flash fil";
$net2ftp_messages["Shockwave file"] = "Shockwave fil";
$net2ftp_messages["WAV sound file"] = "WAV lydfil";
$net2ftp_messages["Font file"] = "Font fil";
$net2ftp_messages["%1\$s File"] = "%1\$s Fil";
$net2ftp_messages["File"] = "Fil";

// getAction()
$net2ftp_messages["Back"] = "Tilbage";
$net2ftp_messages["Submit"] = "Udfør";
$net2ftp_messages["Refresh"] = "Opdater";
$net2ftp_messages["Details"] = "Detalier";
$net2ftp_messages["Icons"] = "Ikoner";
$net2ftp_messages["List"] = "Liste";
$net2ftp_messages["Logout"] = "Log ud";
$net2ftp_messages["Help"] = "Hjælp";
$net2ftp_messages["Bookmark"] = "bogmærke";
$net2ftp_messages["Save"] = "Gem";
$net2ftp_messages["Default"] = "Standard";


// -------------------------------------------------------------------------
// /skins/[skin]/footer.template.php and statusbar.template.php
// -------------------------------------------------------------------------
$net2ftp_messages["Help Guide"] = "Hjælp";
$net2ftp_messages["Forums"] = "Forum";
$net2ftp_messages["License"] = "Licens";
$net2ftp_messages["Powered by"] = "Styres via";
$net2ftp_messages["You are now taken to the net2ftp forums. These forums are for net2ftp related topics only - not for generic webhosting questions."] = "Du sendes videre til net2ftp forummet. Dette forum er kun for net2ftp relatede emner - det er IKKE for generelle spørgsmål om webhosting.";


// -------------------------------------------------------------------------
// Admin module
if ($net2ftp_globals["state"] == "admin") {
// -------------------------------------------------------------------------

// /modules/admin/admin.inc.php
$net2ftp_messages["Admin functions"] = "Admin functions";

// /skins/[skin]/admin1.template.php
$net2ftp_messages["Version information"] = "Version information";
$net2ftp_messages["This version of net2ftp is up-to-date."] = "This version of net2ftp is up-to-date.";
$net2ftp_messages["The latest version information could not be retrieved from the net2ftp.com server. Check the security settings of your browser, which may prevent the loading of a small file from the net2ftp.com server."] = "The latest version information could not be retrieved from the net2ftp.com server. Check the security settings of your browser, which may prevent the loading of a small file from the net2ftp.com server.";
$net2ftp_messages["Logging"] = "Logging";
$net2ftp_messages["Date from:"] = "Date from:";
$net2ftp_messages["to:"] = "to:";
$net2ftp_messages["Empty logs"] = "Empty logs";
$net2ftp_messages["View logs"] = "View logs";
$net2ftp_messages["Go"] = "Go";
$net2ftp_messages["Setup MySQL tables"] = "Setup MySQL tables";
$net2ftp_messages["Create the MySQL database tables"] = "Create the MySQL database tables";

} // end admin

// -------------------------------------------------------------------------
// Admin_createtables module
if ($net2ftp_globals["state"] == "admin_createtables") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_createtables.inc.php
$net2ftp_messages["Admin functions"] = "Admin functions";
$net2ftp_messages["The handle of file %1\$s could not be opened."] = "The handle of file %1\$s could not be opened.";
$net2ftp_messages["The file %1\$s could not be opened."] = "The file %1\$s could not be opened.";
$net2ftp_messages["The handle of file %1\$s could not be closed."] = "The handle of file %1\$s could not be closed.";
$net2ftp_messages["The connection to the server <b>%1\$s</b> could not be set up. Please check the database settings you've entered."] = "The connection to the server <b>%1\$s</b> could not be set up. Please check the database settings you've entered.";
$net2ftp_messages["Unable to select the database <b>%1\$s</b>."] = "Unable to select the database <b>%1\$s</b>.";
$net2ftp_messages["The SQL query nr <b>%1\$s</b> could not be executed."] = "The SQL query nr <b>%1\$s</b> could not be executed.";
$net2ftp_messages["The SQL query nr <b>%1\$s</b> was executed successfully."] = "The SQL query nr <b>%1\$s</b> was executed successfully.";

// /skins/[skin]/admin_createtables1.template.php
$net2ftp_messages["Please enter your MySQL settings:"] = "Please enter your MySQL settings:";
$net2ftp_messages["MySQL username"] = "MySQL username";
$net2ftp_messages["MySQL password"] = "MySQL password";
$net2ftp_messages["MySQL database"] = "MySQL database";
$net2ftp_messages["MySQL server"] = "MySQL server";
$net2ftp_messages["This SQL query is going to be executed:"] = "This SQL query is going to be executed:";
$net2ftp_messages["Execute"] = "Execute";

// /skins/[skin]/admin_createtables2.template.php
$net2ftp_messages["Settings used:"] = "Settings used:";
$net2ftp_messages["MySQL password length"] = "MySQL password length";
$net2ftp_messages["Results:"] = "Results:";

} // end admin_createtables


// -------------------------------------------------------------------------
// Admin_viewlogs module
if ($net2ftp_globals["state"] == "admin_viewlogs") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_viewlogs.inc.php
$net2ftp_messages["Admin functions"] = "Admin functions";
$net2ftp_messages["Unable to execute the SQL query <b>%1\$s</b>."] = "Unable to execute the SQL query <b>%1\$s</b>.";
$net2ftp_messages["No data"] = "No data";

} // end admin_viewlogs


// -------------------------------------------------------------------------
// Admin_emptylogs module
if ($net2ftp_globals["state"] == "admin_emptylogs") {
// -------------------------------------------------------------------------

// /modules/admin_createtables/admin_emptylogs.inc.php
$net2ftp_messages["Admin functions"] = "Admin functions";
$net2ftp_messages["The table <b>%1\$s</b> was emptied successfully."] = "The table <b>%1\$s</b> was emptied successfully.";
$net2ftp_messages["The table <b>%1\$s</b> could not be emptied."] = "The table <b>%1\$s</b> could not be emptied.";
$net2ftp_messages["The table <b>%1\$s</b> was optimized successfully."] = "The table <b>%1\$s</b> was optimized successfully.";
$net2ftp_messages["The table <b>%1\$s</b> could not be optimized."] = "The table <b>%1\$s</b> could not be optimized.";

} // end admin_emptylogs


// -------------------------------------------------------------------------
// Advanced module
if ($net2ftp_globals["state"] == "advanced") {
// -------------------------------------------------------------------------

// /modules/advanced/advanced.inc.php
$net2ftp_messages["Advanced functions"] = "Advanced functions";

// /skins/[skin]/advanced1.template.php
$net2ftp_messages["Go"] = "Go";
$net2ftp_messages["Disabled"] = "Disabled";
$net2ftp_messages["Advanced FTP functions"] = "Advanced FTP functions";
$net2ftp_messages["Send arbitrary FTP commands to the FTP server"] = "Send arbitrary FTP commands to the FTP server";
$net2ftp_messages["This function is available on PHP 5 only"] = "This function is available on PHP 5 only";
$net2ftp_messages["Troubleshooting functions"] = "Troubleshooting functions";
$net2ftp_messages["Troubleshoot net2ftp on this webserver"] = "Troubleshoot net2ftp on this webserver";
$net2ftp_messages["Troubleshoot an FTP server"] = "Troubleshoot an FTP server";
$net2ftp_messages["Test the net2ftp list parsing rules"] = "Test the net2ftp list parsing rules";
$net2ftp_messages["Translation functions"] = "Translation functions";
$net2ftp_messages["Introduction to the translation functions"] = "Introduction to the translation functions";
$net2ftp_messages["Extract messages to translate from code files"] = "Extract messages to translate from code files";
$net2ftp_messages["Check if there are new or obsolete messages"] = "Check if there are new or obsolete messages";

$net2ftp_messages["Beta functions"] = "Beta functions";
$net2ftp_messages["Send a site command to the FTP server"] = "Send a site command to the FTP server";
$net2ftp_messages["Apache: password-protect a directory, create custom error pages"] = "Apache: password-protect a directory, create custom error pages";
$net2ftp_messages["MySQL: execute an SQL query"] = "MySQL: execute an SQL query";


// advanced()
$net2ftp_messages["The site command functions are not available on this webserver."] = "The site command functions are not available on this webserver.";
$net2ftp_messages["The Apache functions are not available on this webserver."] = "The Apache functions are not available on this webserver.";
$net2ftp_messages["The MySQL functions are not available on this webserver."] = "The MySQL functions are not available on this webserver.";
$net2ftp_messages["Unexpected state2 string. Exiting."] = "Unexpected state2 string. Exiting.";

} // end advanced


// -------------------------------------------------------------------------
// Advanced_ftpserver module
if ($net2ftp_globals["state"] == "advanced_ftpserver") {
// -------------------------------------------------------------------------

// /modules/advanced_ftpserver/advanced_ftpserver.inc.php
$net2ftp_messages["Troubleshoot an FTP server"] = "Troubleshoot an FTP server";

// /skins/[skin]/advanced_ftpserver1.template.php
$net2ftp_messages["Connection settings:"] = "Connection settings:";
$net2ftp_messages["FTP server"] = "FTP server";
$net2ftp_messages["FTP server port"] = "FTP server port";
$net2ftp_messages["Username"] = "Username";
$net2ftp_messages["Password"] = "Password";
$net2ftp_messages["Password length"] = "Password length";
$net2ftp_messages["Passive mode"] = "Passive mode";
$net2ftp_messages["Directory"] = "Mappe";
$net2ftp_messages["Printing the result"] = "Printing the result";

// /skins/[skin]/advanced_ftpserver2.template.php
$net2ftp_messages["Connecting to the FTP server: "] = "Connecting to the FTP server: ";
$net2ftp_messages["Logging into the FTP server: "] = "Logging into the FTP server: ";
$net2ftp_messages["Setting the passive mode: "] = "Setting the passive mode: ";
$net2ftp_messages["Getting the FTP server system type: "] = "Getting the FTP server system type: ";
$net2ftp_messages["Changing to the directory %1\$s: "] = "Changing to the directory %1\$s: ";
$net2ftp_messages["The directory from the FTP server is: %1\$s "] = "The directory from the FTP server is: %1\$s ";
$net2ftp_messages["Getting the raw list of directories and files: "] = "Getting the raw list of directories and files: ";
$net2ftp_messages["Trying a second time to get the raw list of directories and files: "] = "Trying a second time to get the raw list of directories and files: ";
$net2ftp_messages["Closing the connection: "] = "Closing the connection: ";
$net2ftp_messages["Raw list of directories and files:"] = "Raw list of directories and files:";
$net2ftp_messages["Parsed list of directories and files:"] = "Parsed list of directories and files:";

$net2ftp_messages["OK"] = "OK";
$net2ftp_messages["not OK"] = "ej OK";

} // end advanced_ftpserver


// -------------------------------------------------------------------------
// Advanced_parsing module
if ($net2ftp_globals["state"] == "advanced_parsing") {
// -------------------------------------------------------------------------

$net2ftp_messages["Test the net2ftp list parsing rules"] = "Test the net2ftp list parsing rules";
$net2ftp_messages["Sample input"] = "Sample input";
$net2ftp_messages["Parsed output"] = "Parsed output";

} // end advanced_parsing


// -------------------------------------------------------------------------
// Advanced_webserver module
if ($net2ftp_globals["state"] == "advanced_webserver") {
// -------------------------------------------------------------------------

$net2ftp_messages["Troubleshoot your net2ftp installation"] = "Troubleshoot your net2ftp installation";
$net2ftp_messages["Printing the result"] = "Printing the result";

$net2ftp_messages["Checking if the FTP module of PHP is installed: "] = "Checking if the FTP module of PHP is installed: ";
$net2ftp_messages["yes"] = "yes";
$net2ftp_messages["no - please install it!"] = "no - please install it!";

$net2ftp_messages["Checking the permissions of the directory on the web server: a small file will be written to the /temp folder and then deleted."] = "Checking the permissions of the directory on the web server: a small file will be written to the /temp folder and then deleted.";
$net2ftp_messages["Creating filename: "] = "Creating filename: ";
$net2ftp_messages["OK. Filename: %1\$s"] = "OK. Filename: %1\$s";
$net2ftp_messages["not OK"] = "ej OK";
$net2ftp_messages["OK"] = "OK";
$net2ftp_messages["not OK. Check the permissions of the %1\$s directory"] = "not OK. Check the permissions of the %1\$s directory";
$net2ftp_messages["Opening the file in write mode: "] = "Opening the file in write mode: ";
$net2ftp_messages["Writing some text to the file: "] = "Writing some text to the file: ";
$net2ftp_messages["Closing the file: "] = "Closing the file: ";
$net2ftp_messages["Deleting the file: "] = "Deleting the file: ";

$net2ftp_messages["Testing the FTP functions"] = "Testing the FTP functions";
$net2ftp_messages["Connecting to a test FTP server: "] = "Connecting to a test FTP server: ";
$net2ftp_messages["Connecting to the FTP server: "] = "Connecting to the FTP server: ";
$net2ftp_messages["Logging into the FTP server: "] = "Logging into the FTP server: ";
$net2ftp_messages["Setting the passive mode: "] = "Setting the passive mode: ";
$net2ftp_messages["Getting the FTP server system type: "] = "Getting the FTP server system type: ";
$net2ftp_messages["Changing to the directory %1\$s: "] = "Changing to the directory %1\$s: ";
$net2ftp_messages["The directory from the FTP server is: %1\$s "] = "The directory from the FTP server is: %1\$s ";
$net2ftp_messages["Getting the raw list of directories and files: "] = "Getting the raw list of directories and files: ";
$net2ftp_messages["Trying a second time to get the raw list of directories and files: "] = "Trying a second time to get the raw list of directories and files: ";
$net2ftp_messages["Closing the connection: "] = "Closing the connection: ";
$net2ftp_messages["Raw list of directories and files:"] = "Raw list of directories and files:";
$net2ftp_messages["Parsed list of directories and files:"] = "Parsed list of directories and files:";
$net2ftp_messages["OK"] = "OK";
$net2ftp_messages["not OK"] = "ej OK";

} // end advanced_webserver


// -------------------------------------------------------------------------
// Bookmark module
if ($net2ftp_globals["state"] == "bookmark") {
// -------------------------------------------------------------------------
$net2ftp_messages["Add this link to your bookmarks:"] = "Add this link to your bookmarks:";
$net2ftp_messages["Internet Explorer: right-click on the link and choose \"Add to Favorites...\""] = "Internet Explorer: right-click on the link and choose \"Add to Favorites...\"";
$net2ftp_messages["Netscape, Mozilla, Firefox: right-click on the link and choose \"Bookmark This Link...\""] = "Netscape, Mozilla, Firefox: right-click on the link and choose \"Bookmark This Link...\"";
$net2ftp_messages["Note: when you will use this bookmark, a popup window will ask you for your username and password."] = "Note: when you will use this bookmark, a popup window will ask you for your username and password.";

} // end bookmark


// -------------------------------------------------------------------------
// Browse module
if ($net2ftp_globals["state"] == "browse") {
// -------------------------------------------------------------------------

// /modules/browse/browse.inc.php
$net2ftp_messages["Choose a directory"] = "Vælg en mappe";
$net2ftp_messages["Please wait..."] = "Vent venligst...";

// browse()
$net2ftp_messages["Directories with names containing \' cannot be displayed correctly. They can only be deleted. Please go back and select another subdirectory."] = "Mapper der indeholder tegnet \' kan ikke vises korrekt. De kan kun slettes. Gå tilbage og vælg en anden mappe.";

$net2ftp_messages["Daily limit reached: you will not be able to transfer data"] = "Daglig datagrænse nået: Du kan ikke overføre mere data i dag";
$net2ftp_messages["In order to guarantee the fair use of the web server for everyone, the data transfer volume and script execution time are limited per user, and per day. Once this limit is reached, you can still browse the FTP server but not transfer data to/from it."] = "For at håndhæve et fair forbrug af vores webserver er der sat begrænsninger på hvor meget data hver bruger kan overføre pr. dag. Når grænsen er nået kan du stadig bruge net2ftp, men du kan ikke overføre data til eller fra serveren.";
$net2ftp_messages["If you need unlimited usage, please install net2ftp on your own web server."] = "Har du behov for ubegrænset forbrug så kan du installere net2ftp på din egen server.";

// printdirfilelist()
// Keep this short, it must fit in a small button!
$net2ftp_messages["New dir"] = "Ny mappe";
$net2ftp_messages["New file"] = "Ny fil";
$net2ftp_messages["HTML templates"] = "HTML skabeloner";
$net2ftp_messages["Upload"] = "Upload";
$net2ftp_messages["Java Upload"] = "Upload Java";
$net2ftp_messages["Flash Upload"] = "Upload Flash";
$net2ftp_messages["Install"] = "Overfør net2ftp Installer";
$net2ftp_messages["Advanced"] = "Udvidede indstillinger.";
$net2ftp_messages["Copy"] = "Kopiér";
$net2ftp_messages["Move"] = "Flyt";
$net2ftp_messages["Delete"] = "Slet";
$net2ftp_messages["Rename"] = "Omdøb";
$net2ftp_messages["Chmod"] = "Ret chmod";
$net2ftp_messages["Download"] = "Download";
$net2ftp_messages["Unzip"] = "Udpak";
$net2ftp_messages["Zip"] = "Komprimer";
$net2ftp_messages["Size"] = "Størrelse";
$net2ftp_messages["Search"] = "Søg";
$net2ftp_messages["Go to the parent directory"] = "Gå til øvre mappe";
$net2ftp_messages["Go"] = "Go";
$net2ftp_messages["Transform selected entries: "] = "Transformér valgte: ";
$net2ftp_messages["Transform selected entry: "] = "Transformér den valgte: ";
$net2ftp_messages["Make a new subdirectory in directory %1\$s"] = "Lav en undermappe i mappen: %1\$s";
$net2ftp_messages["Create a new file in directory %1\$s"] = "Lav en ny fil i mappen: %1\$s";
$net2ftp_messages["Create a website easily using ready-made templates"] = "Lav hurtigt en webside via eksisterende skabeloner";
$net2ftp_messages["Upload new files in directory %1\$s"] = "Upload nye filer til mappen: %1\$s";
$net2ftp_messages["Upload directories and files using a Java applet"] = "Upload mapper og filer via et Java applet";
$net2ftp_messages["Upload files using a Flash applet"] = "Upload filer via et Flash applet";
$net2ftp_messages["Install software packages (requires PHP on web server)"] = "Installér software pakker (kræver PHP installeret på denne server)";
$net2ftp_messages["Go to the advanced functions"] = "Gå til de udvidede indstillinger";
$net2ftp_messages["Copy the selected entries"] = "Kopiér valgte";
$net2ftp_messages["Move the selected entries"] = "Flyt valgte";
$net2ftp_messages["Delete the selected entries"] = "Slet valgte";
$net2ftp_messages["Rename the selected entries"] = "Omdøb valgte";
$net2ftp_messages["Chmod the selected entries (only works on Unix/Linux/BSD servers)"] = "Ret rettigheder (Chmod) for de valgte mapper og filer (virker kun på Unix/Linux/BSD servere)";
$net2ftp_messages["Download a zip file containing all selected entries"] = "Download en zip fil med alle filer og mapper";
$net2ftp_messages["Unzip the selected archives on the FTP server"] = "Udpak det valgte arkiv på FTP serveren";
$net2ftp_messages["Zip the selected entries to save or email them"] = "Komprimer de valgte filer og mapper og enten gem eller email dem";
$net2ftp_messages["Calculate the size of the selected entries"] = "Udregn størrelsen på det valgte";
$net2ftp_messages["Find files which contain a particular word"] = "Find filer som indeholder et bestemt ord";
$net2ftp_messages["Click to sort by %1\$s in descending order"] = "Klik for at sortere via %1\$s i faldende orden";
$net2ftp_messages["Click to sort by %1\$s in ascending order"] = "Klik for at sortere via %1\$s i stigende orden";
$net2ftp_messages["Ascending order"] = "Stigende orden";
$net2ftp_messages["Descending order"] = "Faldende orden";
$net2ftp_messages["Upload files"] = "Upload filer";
$net2ftp_messages["Up"] = "Op";
$net2ftp_messages["Click to check or uncheck all rows"] = "Markér alle, eller fjern alle markeringer";
$net2ftp_messages["All"] = "Alt";
$net2ftp_messages["Name"] = "Navn";
$net2ftp_messages["Type"] = "Type";
//$net2ftp_messages["Size"] = "Size";
$net2ftp_messages["Owner"] = "Ejer";
$net2ftp_messages["Group"] = "Gruppe";
$net2ftp_messages["Perms"] = "Rettighed";
$net2ftp_messages["Mod Time"] = "Sidst redigeret";
$net2ftp_messages["Actions"] = "Handlinger";
$net2ftp_messages["Select the directory %1\$s"] = "Vælg mappen: %1\$s";
$net2ftp_messages["Select the file %1\$s"] = "Vælg filen: %1\$s";
$net2ftp_messages["Select the symlink %1\$s"] = "Vælg symlinket: %1\$s";
$net2ftp_messages["Go to the subdirectory %1\$s"] = "Gå til mappen: %1\$s";
$net2ftp_messages["Download the file %1\$s"] = "Download filen: %1\$s";
$net2ftp_messages["Follow symlink %1\$s"] = "Følg symlinket: %1\$s";
$net2ftp_messages["View"] = "Vis kildekode";
$net2ftp_messages["Edit"] = "Redigér";
$net2ftp_messages["Update"] = "Opdatér";
$net2ftp_messages["Open"] = "Åben";
$net2ftp_messages["View the highlighted source code of file %1\$s"] = "Se den fremhævede kildekode for filen: %1\$s";
$net2ftp_messages["Edit the source code of file %1\$s"] = "Rediger kildekoden for filen: %1\$s";
$net2ftp_messages["Upload a new version of the file %1\$s and merge the changes"] = "Upload en ny version af filen: %1\$s og sammenflet ændringerne med den nuværende fil";
$net2ftp_messages["View image %1\$s"] = "Se billedet: %1\$s";
$net2ftp_messages["View the file %1\$s from your HTTP web server"] = "Se filen: %1\$s fra din HTTP web server";
$net2ftp_messages["(Note: This link may not work if you don't have your own domain name.)"] = "(Bemærk: Dette link virker måske ikke hvis du ikke har dit eget internetdomæne.)";
$net2ftp_messages["This folder is empty"] = "Denne mappe er tom";

// printSeparatorRow()
$net2ftp_messages["Directories"] = "Mapper";
$net2ftp_messages["Files"] = "Filer";
$net2ftp_messages["Symlinks"] = "Symlinks";
$net2ftp_messages["Unrecognized FTP output"] = "Ukendt FTP output";
$net2ftp_messages["Number"] = "Nummer";
$net2ftp_messages["Size"] = "Størrelse";
$net2ftp_messages["Skipped"] = "Spring over";
$net2ftp_messages["Data transferred from this IP address today"] = "Data overført fra denne IP adresse i dag";
$net2ftp_messages["Data transferred to this FTP server today"] = "Data overført til denne FTP server i dag";

// printLocationActions()
$net2ftp_messages["Language:"] = "Sprig:";
$net2ftp_messages["Skin:"] = "Tema:";
$net2ftp_messages["View mode:"] = "Se modus:";
$net2ftp_messages["Directory Tree"] = "Mappeoversigt";

// ftp2http()
$net2ftp_messages["Execute %1\$s in a new window"] = "Udfør %1\$s i et nyt vindue";
$net2ftp_messages["This file is not accessible from the web"] = "Denne fil kan ikke bruges på nettet";

// printDirectorySelect()
$net2ftp_messages["Double-click to go to a subdirectory:"] = "Dobbeltklik for at gå til en mappe:";
$net2ftp_messages["Choose"] = "Vælg";
$net2ftp_messages["Up"] = "Op";

} // end browse


// -------------------------------------------------------------------------
// Calculate size module
if ($net2ftp_globals["state"] == "calculatesize") {
// -------------------------------------------------------------------------
$net2ftp_messages["Size of selected directories and files"] = "Størrelse på valgte filer og mapper";
$net2ftp_messages["The total size taken by the selected directories and files is:"] = "Den samlede størrelse på de valgte filer og mapper er:";
$net2ftp_messages["The number of files which were skipped is:"] = "Antal filer der ikke blev regnet med:";

} // end calculatesize


// -------------------------------------------------------------------------
// Chmod module
if ($net2ftp_globals["state"] == "chmod") {
// -------------------------------------------------------------------------
$net2ftp_messages["Chmod directories and files"] = "Ret rettigheder (Chmod) for filer og mapper";
$net2ftp_messages["Set all permissions"] = "Sæt alt til dette";
$net2ftp_messages["Read"] = "Læs";
$net2ftp_messages["Write"] = "Skriv";
$net2ftp_messages["Execute"] = "Execute";
$net2ftp_messages["Owner"] = "Ejer";
$net2ftp_messages["Group"] = "Gruppe";
$net2ftp_messages["Everyone"] = "Alle";
$net2ftp_messages["To set all permissions to the same values, enter those permissions and click on the button \"Set all permissions\""] = "To set all permissions to the same values, enter those permissions and click on the button \"Set all permissions\"";
$net2ftp_messages["Set the permissions of directory <b>%1\$s</b> to: "] = "Set the permissions of directory <b>%1\$s</b> to: ";
$net2ftp_messages["Set the permissions of file <b>%1\$s</b> to: "] = "Sæt rettigheder for filen: <b>%1\$s</b> til: ";
$net2ftp_messages["Set the permissions of symlink <b>%1\$s</b> to: "] = "Sæt rettigheder for symlinket: <b>%1\$s</b> til: ";
$net2ftp_messages["Chmod value"] = "Chmod værdi";
$net2ftp_messages["Chmod also the subdirectories within this directory"] = "Ret også undermapper i denne mappe";
$net2ftp_messages["Chmod also the files within this directory"] = "Ret også filer i denne mappe";
$net2ftp_messages["The chmod nr <b>%1\$s</b> is out of the range 000-777. Please try again."] = "Indtastningen: <b>%1\$s</b> Er ugyldig. (fra 000 til 777). Prøv igen.";

} // end chmod


// -------------------------------------------------------------------------
// Clear cookies module
// -------------------------------------------------------------------------
// No messages


// -------------------------------------------------------------------------
// Copy/Move/Delete module
if ($net2ftp_globals["state"] == "copymovedelete") {
// -------------------------------------------------------------------------
$net2ftp_messages["Choose a directory"] = "Vælg en mappe";
$net2ftp_messages["Copy directories and files"] = "Kopiér mapper og filer";
$net2ftp_messages["Move directories and files"] = "Flyt mapper og filer";
$net2ftp_messages["Delete directories and files"] = "Slet mapper og filer";
$net2ftp_messages["Are you sure you want to delete these directories and files?"] = "Er du sikker på du vil slette disse mapper og filer?";
$net2ftp_messages["All the subdirectories and files of the selected directories will also be deleted!"] = "Alle undermapper og filer vil også blive slettet!";
$net2ftp_messages["Set all targetdirectories"] = "Ret alles nye placering";
$net2ftp_messages["To set a common target directory, enter that target directory in the textbox above and click on the button \"Set all targetdirectories\"."] = "For at rette alles nye placering så indtast placeringen i feltet herover og klik på \"Ret alles nye placering\".";
$net2ftp_messages["Note: the target directory must already exist before anything can be copied into it."] = "Bemærk: placeringen skal være oprettet i forvejen før du kan kopiere noget dertil.";
$net2ftp_messages["Different target FTP server:"] = "Anden FTP server:";
$net2ftp_messages["Username"] = "Username";
$net2ftp_messages["Password"] = "Password";
$net2ftp_messages["Leave empty if you want to copy the files to the same FTP server."] = "Efterlad disse felter blanke hvis du ikke vil kopiere noget til andre FTP servere.";
$net2ftp_messages["If you want to copy the files to another FTP server, enter your login data."] = "Hvis du vil kopiere filerne til en anden FTP server skal du angive FTP serverens login oplysninger.";
$net2ftp_messages["Leave empty if you want to move the files to the same FTP server."] = "Efterlad disse felter blanke hvis du ikke vil flytte noget til andre FTP servere.";
$net2ftp_messages["If you want to move the files to another FTP server, enter your login data."] = "Hvis du vil flytte filerne til en anden FTP server skal du angive FTP serverens login oplysninger.";
$net2ftp_messages["Copy directory <b>%1\$s</b> to:"] = "Kopiér mappen: <b>%1\$s</b> til:";
$net2ftp_messages["Move directory <b>%1\$s</b> to:"] = "Flyt mappen: <b>%1\$s</b> til:";
$net2ftp_messages["Directory <b>%1\$s</b>"] = "Mappe: <b>%1\$s</b>";
$net2ftp_messages["Copy file <b>%1\$s</b> to:"] = "Kopiér fil <b>%1\$s</b> til:";
$net2ftp_messages["Move file <b>%1\$s</b> to:"] = "Flyt fil <b>%1\$s</b> til:";
$net2ftp_messages["File <b>%1\$s</b>"] = "File <b>%1\$s</b>";
$net2ftp_messages["Copy symlink <b>%1\$s</b> to:"] = "Kopiér symlink <b>%1\$s</b> til:";
$net2ftp_messages["Move symlink <b>%1\$s</b> to:"] = "Flyt symlink <b>%1\$s</b> til:";
$net2ftp_messages["Symlink <b>%1\$s</b>"] = "Symlink <b>%1\$s</b>";
$net2ftp_messages["Target directory:"] = "Placering:";
$net2ftp_messages["Target name:"] = "Navn:";
$net2ftp_messages["Processing the entries:"] = "Behandler opgave:";

} // end copymovedelete


// -------------------------------------------------------------------------
// Download file module
// -------------------------------------------------------------------------
// No messages


// -------------------------------------------------------------------------
// EasyWebsite module
if ($net2ftp_globals["state"] == "easyWebsite") {
// -------------------------------------------------------------------------
$net2ftp_messages["Create a website in 4 easy steps"] = "Create a website in 4 easy steps";
$net2ftp_messages["Template overview"] = "Template overview";
$net2ftp_messages["Template details"] = "Template details";
$net2ftp_messages["Files are copied"] = "Files are copied";
$net2ftp_messages["Edit your pages"] = "Edit your pages";

// Screen 1 - printTemplateOverview
$net2ftp_messages["Click on the image to view the details of a template."] = "Click on the image to view the details of a template.";
$net2ftp_messages["Back to the Browse screen"] = "Back to the Browse screen";
$net2ftp_messages["Template"] = "Template";
$net2ftp_messages["Copyright"] = "Copyright";
$net2ftp_messages["Click on the image to view the details of this template"] = "Click on the image to view the details of this template";

// Screen 2 - printTemplateDetails
$net2ftp_messages["The template files will be copied to your FTP server. Existing files with the same filename will be overwritten. Do you want to continue?"] = "The template files will be copied to your FTP server. Existing files with the same filename will be overwritten. Do you want to continue?";
$net2ftp_messages["Install template to directory: "] = "Install template to directory: ";
$net2ftp_messages["Install"] = "Overfør net2ftp Installer";
$net2ftp_messages["Size"] = "Størrelse";
$net2ftp_messages["Preview page"] = "Preview page";
$net2ftp_messages["opens in a new window"] = "opens in a new window";

// Screen 3
$net2ftp_messages["Please wait while the template files are being transferred to your server: "] = "Please wait while the template files are being transferred to your server: ";
$net2ftp_messages["Done."] = "Done.";
$net2ftp_messages["Continue"] = "Continue";

// Screen 4 - printEasyAdminPanel
$net2ftp_messages["Edit page"] = "Edit page";
$net2ftp_messages["Browse the FTP server"] = "Browse the FTP server";
$net2ftp_messages["Add this link to your favorites to return to this page later on!"] = "Add this link to your favorites to return to this page later on!";
$net2ftp_messages["Edit website at %1\$s"] = "Edit website at %1\$s";
$net2ftp_messages["Internet Explorer: right-click on the link and choose \"Add to Favorites...\""] = "Internet Explorer: right-click on the link and choose \"Add to Favorites...\"";
$net2ftp_messages["Netscape, Mozilla, Firefox: right-click on the link and choose \"Bookmark This Link...\""] = "Netscape, Mozilla, Firefox: right-click on the link and choose \"Bookmark This Link...\"";

// ftp_copy_local2ftp
$net2ftp_messages["WARNING: Unable to create the subdirectory <b>%1\$s</b>. It may already exist. Continuing..."] = "WARNING: Unable to create the subdirectory <b>%1\$s</b>. It may already exist. Continuing...";
$net2ftp_messages["Created target subdirectory <b>%1\$s</b>"] = "Created target subdirectory <b>%1\$s</b>";
$net2ftp_messages["WARNING: Unable to copy the file <b>%1\$s</b>. Continuing..."] = "WARNING: Unable to copy the file <b>%1\$s</b>. Continuing...";
$net2ftp_messages["Copied file <b>%1\$s</b>"] = "Copied file <b>%1\$s</b>";
}


// -------------------------------------------------------------------------
// Edit module
if ($net2ftp_globals["state"] == "edit") {
// -------------------------------------------------------------------------

// /modules/edit/edit.inc.php
$net2ftp_messages["Unable to open the template file"] = "Unable to open the template file";
$net2ftp_messages["Unable to read the template file"] = "Unable to read the template file";
$net2ftp_messages["Please specify a filename"] = "Please specify a filename";
$net2ftp_messages["Status: This file has not yet been saved"] = "Status: This file has not yet been saved";
$net2ftp_messages["Status: Saved on <b>%1\$s</b> using mode %2\$s"] = "Status: Saved on <b>%1\$s</b> using mode %2\$s";
$net2ftp_messages["Status: <b>This file could not be saved</b>"] = "Status: <b>This file could not be saved</b>";
$net2ftp_messages["Not yet saved"] = "Not yet saved";
$net2ftp_messages["Could not be saved"] = "Could not be saved";
$net2ftp_messages["Saved at %1\$s"] = "Saved at %1\$s";

// /skins/[skin]/edit.template.php
$net2ftp_messages["Directory: "] = "Directory: ";
$net2ftp_messages["File: "] = "File: ";
$net2ftp_messages["New file name: "] = "New file name: ";
$net2ftp_messages["Character encoding: "] = "Character encoding: ";
$net2ftp_messages["Note: changing the textarea type will save the changes"] = "Note: changing the textarea type will save the changes";
$net2ftp_messages["Copy up"] = "Copy up";
$net2ftp_messages["Copy down"] = "Copy down";

} // end if edit


// -------------------------------------------------------------------------
// Find string module
if ($net2ftp_globals["state"] == "findstring") {
// -------------------------------------------------------------------------

// /modules/findstring/findstring.inc.php 
$net2ftp_messages["Search directories and files"] = "Search directories and files";
$net2ftp_messages["Search again"] = "Search again";
$net2ftp_messages["Search results"] = "Search results";
$net2ftp_messages["Please enter a valid search word or phrase."] = "Please enter a valid search word or phrase.";
$net2ftp_messages["Please enter a valid filename."] = "Please enter a valid filename.";
$net2ftp_messages["Please enter a valid file size in the \"from\" textbox, for example 0."] = "Please enter a valid file size in the \"from\" textbox, for example 0.";
$net2ftp_messages["Please enter a valid file size in the \"to\" textbox, for example 500000."] = "Please enter a valid file size in the \"to\" textbox, for example 500000.";
$net2ftp_messages["Please enter a valid date in Y-m-d format in the \"from\" textbox."] = "Please enter a valid date in Y-m-d format in the \"from\" textbox.";
$net2ftp_messages["Please enter a valid date in Y-m-d format in the \"to\" textbox."] = "Please enter a valid date in Y-m-d format in the \"to\" textbox.";
$net2ftp_messages["The word <b>%1\$s</b> was not found in the selected directories and files."] = "The word <b>%1\$s</b> was not found in the selected directories and files.";
$net2ftp_messages["The word <b>%1\$s</b> was found in the following files:"] = "The word <b>%1\$s</b> was found in the following files:";

// /skins/[skin]/findstring1.template.php
$net2ftp_messages["Search for a word or phrase"] = "Search for a word or phrase";
$net2ftp_messages["Case sensitive search"] = "Case sensitive search";
$net2ftp_messages["Restrict the search to:"] = "Restrict the search to:";
$net2ftp_messages["files with a filename like"] = "files with a filename like";
$net2ftp_messages["(wildcard character is *)"] = "(wildcard character is *)";
$net2ftp_messages["files with a size"] = "files with a size";
$net2ftp_messages["files which were last modified"] = "files which were last modified";
$net2ftp_messages["from"] = "from";
$net2ftp_messages["to"] = "to";

$net2ftp_messages["Directory"] = "Mappe";
$net2ftp_messages["File"] = "Fil";
$net2ftp_messages["Line"] = "Line";
$net2ftp_messages["Action"] = "Action";
$net2ftp_messages["View"] = "Vis kildekode";
$net2ftp_messages["Edit"] = "Redigér";
$net2ftp_messages["View the highlighted source code of file %1\$s"] = "Se den fremhævede kildekode for filen: %1\$s";
$net2ftp_messages["Edit the source code of file %1\$s"] = "Rediger kildekoden for filen: %1\$s";

} // end findstring


// -------------------------------------------------------------------------
// Help module
// -------------------------------------------------------------------------
// No messages yet


// -------------------------------------------------------------------------
// Install size module
if ($net2ftp_globals["state"] == "install") {
// -------------------------------------------------------------------------

// /modules/install/install.inc.php
$net2ftp_messages["Install software packages"] = "Install software packages";
$net2ftp_messages["Unable to open the template file"] = "Unable to open the template file";
$net2ftp_messages["Unable to read the template file"] = "Unable to read the template file";
$net2ftp_messages["Unable to get the list of packages"] = "Unable to get the list of packages";

// /skins/blue/install1.template.php
$net2ftp_messages["The net2ftp installer script has been copied to the FTP server."] = "The net2ftp installer script has been copied to the FTP server.";
$net2ftp_messages["This script runs on your web server and requires PHP to be installed."] = "This script runs on your web server and requires PHP to be installed.";
$net2ftp_messages["In order to run it, click on the link below."] = "In order to run it, click on the link below.";
$net2ftp_messages["net2ftp has tried to determine the directory mapping between the FTP server and the web server."] = "net2ftp has tried to determine the directory mapping between the FTP server and the web server.";
$net2ftp_messages["Should this link not be correct, enter the URL manually in your web browser."] = "Should this link not be correct, enter the URL manually in your web browser.";

} // end install


// -------------------------------------------------------------------------
// Java upload module
if ($net2ftp_globals["state"] == "jupload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Upload directories and files using a Java applet"] = "Upload mapper og filer via et Java applet";
$net2ftp_messages["Number of files:"] = "Number of files:";
$net2ftp_messages["Size of files:"] = "Size of files:";
$net2ftp_messages["Add"] = "Add";
$net2ftp_messages["Remove"] = "Remove";
$net2ftp_messages["Upload"] = "Upload";
$net2ftp_messages["Add files to the upload queue"] = "Add files to the upload queue";
$net2ftp_messages["Remove files from the upload queue"] = "Remove files from the upload queue";
$net2ftp_messages["Upload the files which are in the upload queue"] = "Upload the files which are in the upload queue";
$net2ftp_messages["Maximum server space exceeded. Please select less/smaller files."] = "Maximum server space exceeded. Please select less/smaller files.";
$net2ftp_messages["Total size of the files is too big. Please select less/smaller files."] = "Total size of the files is too big. Please select less/smaller files.";
$net2ftp_messages["Total number of files is too high. Please select fewer files."] = "Total number of files is too high. Please select fewer files.";
$net2ftp_messages["Note: to use this applet, Sun's Java plugin must be installed (version 1.4 or newer)."] = "Note: to use this applet, Sun's Java plugin must be installed (version 1.4 or newer).";

} // end jupload



// -------------------------------------------------------------------------
// Login module
if ($net2ftp_globals["state"] == "login") {
// -------------------------------------------------------------------------
$net2ftp_messages["Login!"] = "Log ind!";
$net2ftp_messages["Once you are logged in, you will be able to:"] = "Når du er logget på kan du:";
$net2ftp_messages["Navigate the FTP server"] = "Nagivere i din FTP server";
$net2ftp_messages["Once you have logged in, you can browse from directory to directory and see all the subdirectories and files."] = "Når du er logget på kan du navigere igennem dine mapper og se alle dine filer.";
$net2ftp_messages["Upload files"] = "Upload filer";
$net2ftp_messages["There are 3 different ways to upload files: the standard upload form, the upload-and-unzip functionality, and the Java Applet."] = "Der er tre måder at uploade filer på: den normale upload form, upload en komprimeret fil og udpak filer og mapper, og via et  Java Applet.";
$net2ftp_messages["Download files"] = "Downloade filer";
$net2ftp_messages["Click on a filename to quickly download one file.<br />Select multiple files and click on Download; the selected files will be downloaded in a zip archive."] = "Klik på et filnavn for at downloade den fil.<br />Vælg flere filer og klik på Download; de valge filer bliver downloadet i et komprimeret format.";
$net2ftp_messages["Zip files"] = "Komprimér filer";
$net2ftp_messages["... and save the zip archive on the FTP server, or email it to someone."] = "... og gem den komprimerede fil på FTP serveren, eller mail den til en eller anden.";
$net2ftp_messages["Unzip files"] = "Udpak arkiver";
$net2ftp_messages["Different formats are supported: .zip, .tar, .tgz and .gz."] = "Flere formater understøttes: .zip, .tar, .tgz og .gz.";
$net2ftp_messages["Install software"] = "Installér software";
$net2ftp_messages["Choose from a list of popular applications (PHP required)."] = "Vælg fra en liste over populære produkter (PHP påkræves).";
$net2ftp_messages["Copy, move and delete"] = "Kopiér, flyt og slet";
$net2ftp_messages["Directories are handled recursively, meaning that their content (subdirectories and files) will also be copied, moved or deleted."] = "Mappers indhold (undermapper og filer) inkluderes også når du kopierer, flytter eller sletter mapper.";
$net2ftp_messages["Copy or move to a 2nd FTP server"] = "Kopiér eller flyt til en anden FTP server";
$net2ftp_messages["Handy to import files to your FTP server, or to export files from your FTP server to another FTP server."] = "Brugbart for at importere filer til din FTP server, eller for at eksportere filer fra din server til en anden FTP server.";
$net2ftp_messages["Rename and chmod"] = "Omdøb og rediger rettigheder (chmod)";
$net2ftp_messages["Chmod handles directories recursively."] = "Chmod af mapper påvirker også mappers indhold.";
$net2ftp_messages["View code with syntax highlighting"] = "Se kildekode med farvefremhævet syntax";
$net2ftp_messages["PHP functions are linked to the documentation on php.net."] = "PHP funktioner linkes til php.net for hurigt at finde en beskrivelse.";
$net2ftp_messages["Plain text editor"] = "Normal tekstredigering";
$net2ftp_messages["Edit text right from your browser; every time you save the changes the new file is transferred to the FTP server."] = "Ret tekst direkte i din browser, hver gang du gemmer dine ændringer bliver filen opdateret på din FTP server.";
$net2ftp_messages["HTML editors"] = "HTML editorer";
$net2ftp_messages["Edit HTML a What-You-See-Is-What-You-Get (WYSIWYG) form; there are 2 different editors to choose from."] = "Ret HTML i en What-You-See-Is-What-You-Get (WYSIWYG) editor; Der er to forskellige editorer at vælge imellem.";
$net2ftp_messages["Code editor"] = "Kode editor";
$net2ftp_messages["Edit HTML and PHP in an editor with syntax highlighting."] = "Ret HTML og PHP i en editor med farvefremhævning af syntax.";
$net2ftp_messages["Search for words or phrases"] = "Søg efter ord eller sætninger";
$net2ftp_messages["Filter out files based on the filename, last modification time and filesize."] = "Filtrér filer via filnavn, filstørrelse og hvornår de sidst er ændret.";
$net2ftp_messages["Calculate size"] = "Udregn størrelse";
$net2ftp_messages["Calculate the size of directories and files."] = "Udregn samlet størrelse på flere filer og mapper.";

$net2ftp_messages["FTP server"] = "FTP server";
$net2ftp_messages["Example"] = "Eksempel";
$net2ftp_messages["Port"] = "Port";
$net2ftp_messages["Username"] = "Username";
$net2ftp_messages["Password"] = "Password";
$net2ftp_messages["Anonymous"] = "Anonym";
$net2ftp_messages["Passive mode"] = "Passive mode";
$net2ftp_messages["Initial directory"] = "Mappe";
$net2ftp_messages["Language"] = "Sprog";
$net2ftp_messages["Skin"] = "Tema";
$net2ftp_messages["FTP mode"] = "FTP modus";
$net2ftp_messages["Automatic"] = "Automatisk";
$net2ftp_messages["Login"] = "Log ind";
$net2ftp_messages["Clear cookies"] = "Ryd cookies";
$net2ftp_messages["Admin"] = "Administrator";
$net2ftp_messages["Please enter an FTP server."] = "Indtast en FTP server.";
$net2ftp_messages["Please enter a username."] = "Indtast et brugernavn.";
$net2ftp_messages["Please enter a password."] = "Indtast en adganskode.";

} // end login


// -------------------------------------------------------------------------
// Login module
if ($net2ftp_globals["state"] == "login_small") {
// -------------------------------------------------------------------------

$net2ftp_messages["Please enter your Administrator username and password."] = "Indtast enten dit brugernavn eller din adgangskode.";
$net2ftp_messages["Please enter your username and password for FTP server <b>%1\$s</b>."] = "Indtast dit brugernavn og adgangskode for FTP serveren: <b>%1\$s</b>.";
$net2ftp_messages["Username"] = "Username";
$net2ftp_messages["Your session has expired; please enter your password for FTP server <b>%1\$s</b> to continue."] = "Dit login er udløbet. Log ind igen for at fortsætte dit arbejde på FTP serveren: <b>%1\$s</b>.";
$net2ftp_messages["Your IP address has changed; please enter your password for FTP server <b>%1\$s</b> to continue."] = "Din IP adresse er ændret; log ind igen for at fortsætte dit arbejde på FTP serveren: <b>%1\$s</b>.";
$net2ftp_messages["Password"] = "Password";
$net2ftp_messages["Login"] = "Log ind";
$net2ftp_messages["Continue"] = "Continue";

} // end login_small


// -------------------------------------------------------------------------
// Logout module
if ($net2ftp_globals["state"] == "logout") {
// -------------------------------------------------------------------------

// logout.inc.php
$net2ftp_messages["Login page"] = "Login side";

// logout.template.php
$net2ftp_messages["You have logged out from the FTP server. To log back in, <a href=\"%1\$s\" title=\"Login page (accesskey l)\" accesskey=\"l\">follow this link</a>."] = "Du er logget ud af din FTP server. <a href=\"%1\$s\" title=\"Login side (ALT + l)\" accesskey=\"l\">Log på igen</a>.";
$net2ftp_messages["Note: other users of this computer could click on the browser's Back button and access the FTP server."] = "Bemærk: andre brugere af denne computer kan klikke på tilbageknappen i browseren og få adgang til FTP serveren.";
$net2ftp_messages["To prevent this, you must close all browser windows."] = "For at undgå dette, så luk alle browservinduer.";
$net2ftp_messages["Close"] = "Luk";
$net2ftp_messages["Click here to close this window"] = "Luk dette vindue";

} // end logout


// -------------------------------------------------------------------------
// New directory module
if ($net2ftp_globals["state"] == "newdir") {
// -------------------------------------------------------------------------
$net2ftp_messages["Create new directories"] = "Opret en ny mappe";
$net2ftp_messages["The new directories will be created in <b>%1\$s</b>."] = "Den nye mappe bliver oprettet i: <b>%1\$s</b>.";
$net2ftp_messages["New directory name:"] = "Mappenavn:";
$net2ftp_messages["Directory <b>%1\$s</b> was successfully created."] = "Mappen: <b>%1\$s</b> er oprettet.";
$net2ftp_messages["Directory <b>%1\$s</b> could not be created."] = "Mappen: <b>%1\$s</b> kunne ikke oprettes.";

} // end newdir


// -------------------------------------------------------------------------
// Raw module
if ($net2ftp_globals["state"] == "raw") {
// -------------------------------------------------------------------------

// /modules/raw/raw.inc.php
$net2ftp_messages["Send arbitrary FTP commands"] = "Send arbitrære FTP kommandoer";


// /skins/[skin]/raw1.template.php
$net2ftp_messages["List of commands:"] = "liste over kommandoer:";
$net2ftp_messages["FTP server response:"] = "FTP server svar:";

} // end raw


// -------------------------------------------------------------------------
// Rename module
if ($net2ftp_globals["state"] == "rename") {
// -------------------------------------------------------------------------
$net2ftp_messages["Rename directories and files"] = "Omdøb mapper og filer";
$net2ftp_messages["Old name: "] = "Gammelt navn: ";
$net2ftp_messages["New name: "] = "Nyt navn: ";
$net2ftp_messages["The new name may not contain any dots. This entry was not renamed to <b>%1\$s</b>"] = "Det nye navn må ikke indeholde punktummer. Denne mappe eller fil kunne ikke omdøbes til <b>%1\$s</b>";
$net2ftp_messages["The new name may not contain any banned keywords. This entry was not renamed to <b>%1\$s</b>"] = "Det nye navn må ikke indeholde blokerede nøgleord. Denne mappe eller fil kunne ikke omdøbes til <b>%1\$s</b>";
$net2ftp_messages["<b>%1\$s</b> was successfully renamed to <b>%2\$s</b>"] = "<b>%1\$s</b> blev omdøbt til <b>%2\$s</b>";
$net2ftp_messages["<b>%1\$s</b> could not be renamed to <b>%2\$s</b>"] = "<b>%1\$s</b> kunne ikke omdøbes til <b>%2\$s</b>";

} // end rename


// -------------------------------------------------------------------------
// Unzip module
if ($net2ftp_globals["state"] == "unzip") {
// -------------------------------------------------------------------------

// /modules/unzip/unzip.inc.php
$net2ftp_messages["Unzip archives"] = "Udpak arkiver";
$net2ftp_messages["Getting archive %1\$s of %2\$s from the FTP server"] = "Henter %1\$s ud af %2\$s arkiver fra FTP serveren";
$net2ftp_messages["Unable to get the archive <b>%1\$s</b> from the FTP server"] = "Kunne ikke hente arkivet: <b>%1\$s</b> fra FTP serveren";

// /skins/[skin]/unzip1.template.php
$net2ftp_messages["Set all targetdirectories"] = "Ret alles nye placering";
$net2ftp_messages["To set a common target directory, enter that target directory in the textbox above and click on the button \"Set all targetdirectories\"."] = "For at rette alles nye placering så indtast placeringen i feltet herover og klik på \"Ret alles nye placering\".";
$net2ftp_messages["Note: the target directory must already exist before anything can be copied into it."] = "Bemærk: placeringen skal være oprettet i forvejen før du kan kopiere noget dertil.";
$net2ftp_messages["Unzip archive <b>%1\$s</b> to:"] = "Udpakker arkiv: <b>%1\$s</b> til:";
$net2ftp_messages["Target directory:"] = "Placering:";
$net2ftp_messages["Use folder names (creates subdirectories automatically)"] = "Brug undermapper (opretter undermapper automatisk)";

} // end unzip


// -------------------------------------------------------------------------
// Update file module
if ($net2ftp_globals["state"] == "updatefile") {
// -------------------------------------------------------------------------
$net2ftp_messages["Update file"] = "Opdater fil";
$net2ftp_messages["<b>WARNING: THIS FUNCTION IS STILL IN EARLY DEVELOPMENT. USE IT ONLY ON TEST FILES! YOU HAVE BEEN WARNED!"] = "<b>ADVARSEL: DENNE FUNKTION ER STADIG PÅ TESTSTADIET. BRUG DET KUN TIL TESTFORMÅL!";
$net2ftp_messages["Known bugs: - erases tab characters - doesn't work well with big files (> 50kB) - was not tested yet on files containing non-standard characters</b>"] = "Kendte fejl: - Fjerner tabulatortegn - Virker ikke på store filer (> 50kB) - er ikke testet på filer der indeholder nationale tegn</b>";
$net2ftp_messages["This function allows you to upload a new version of the selected file, to view what are the changes and to accept or reject each change. Before anything is saved, you can edit the merged files."] = "Denne funktion lader dig uploade en nyere version af den valgte fil så du kan godkende eller afvise hver ændring du har foretaget før du gemmer den.";
$net2ftp_messages["Old file:"] = "Gammel fil:";
$net2ftp_messages["New file:"] = "Ny fil:";
$net2ftp_messages["Restrictions:"] = "Begrænsninger:";
$net2ftp_messages["The maximum size of one file is restricted by net2ftp to <b>%1\$s kB</b> and by PHP to <b>%2\$s</b>"] = "Den maksimale filstørrelse er sat af net2ftp til at være <b>%1\$s kB</b> og af PHP til at være <b>%2\$s</b>";
$net2ftp_messages["The maximum execution time is <b>%1\$s seconds</b>"] = "Upload af filer må højst vare <b>%1\$s sekunder</b>";
$net2ftp_messages["The FTP transfer mode (ASCII or BINARY) will be automatically determined, based on the filename extension"] = "FTP overførselsmodus (ASCII eller BINARY) vil automatisk blive besluttet ud fra filernes endelser";
$net2ftp_messages["If the destination file already exists, it will be overwritten"] = "Hvis mappeplaceringen findes i forvejen bliver indholdet erstattet";
$net2ftp_messages["You did not provide any files or archives to upload."] = "Du har ikke valgt nogen filer eller arkiver til at uploade.";
$net2ftp_messages["Unable to delete the new file"] = "Kunne ikke slette den nye fil";

// printComparisonSelect()
$net2ftp_messages["Please wait..."] = "Vent venligst...";
$net2ftp_messages["Select lines below, accept or reject changes and submit the form."] = "Godkend eller afvis ændringerne herunder og klik på udfør.";

} // end updatefile


// -------------------------------------------------------------------------
// Upload module
if ($net2ftp_globals["state"] == "upload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Upload to directory:"] = "Upload til mappe:";
$net2ftp_messages["Files"] = "Filer";
$net2ftp_messages["Archives"] = "Arkiver";
$net2ftp_messages["Files entered here will be transferred to the FTP server."] = "Valgte filer bliver overført til FTP serveren.";
$net2ftp_messages["Archives entered here will be decompressed, and the files inside will be transferred to the FTP server."] = "Valgte arkiver bliver automatisk udpakket og filerne overføres til FTP serveren.";
$net2ftp_messages["Add another"] = "Tilføj flere";
$net2ftp_messages["Use folder names (creates subdirectories automatically)"] = "Brug undermapper (opretter undermapper automatisk)";

$net2ftp_messages["Choose a directory"] = "Vælg en mappe";
$net2ftp_messages["Please wait..."] = "Vent venligst...";
$net2ftp_messages["Uploading... please wait..."] = "Uploader... vent venligst...";
$net2ftp_messages["If the upload takes more than the allowed <b>%1\$s seconds<\/b>, you will have to try again with less/smaller files."] = "Hvis det tager mere end <b>%1\$s sekunder<\/b> for at uploade filen må du prøve igen med færre eller mindre filer.";
$net2ftp_messages["This window will close automatically in a few seconds."] = "Dette vindue lukker automatisk om få sekunder.";
$net2ftp_messages["Close window now"] = "Luk vindue";

$net2ftp_messages["Upload files and archives"] = "Upload filer og mapper";
$net2ftp_messages["Upload results"] = "Upload resultater";
$net2ftp_messages["Checking files:"] = "Kontrollerer filer:";
$net2ftp_messages["Transferring files to the FTP server:"] = "Overfører filer til FTP serveren:";
$net2ftp_messages["Decompressing archives and transferring files to the FTP server:"] = "Dekomprimerer arkiver og overfører filer til FTP serveren:";
$net2ftp_messages["Upload more files and archives"] = "Upload flere filer og mapper";

} // end upload


// -------------------------------------------------------------------------
// Messages which are shared by upload and jupload
if ($net2ftp_globals["state"] == "upload" || $net2ftp_globals["state"] == "jupload") {
// -------------------------------------------------------------------------
$net2ftp_messages["Restrictions:"] = "Begrænsninger:";
$net2ftp_messages["The maximum size of one file is restricted by net2ftp to <b>%1\$s kB</b> and by PHP to <b>%2\$s</b>"] = "Den maksimale filstørrelse er sat af net2ftp til at være <b>%1\$s kB</b> og af PHP til at være <b>%2\$s</b>";
$net2ftp_messages["The maximum execution time is <b>%1\$s seconds</b>"] = "Upload af filer må højst vare <b>%1\$s sekunder</b>";
$net2ftp_messages["The FTP transfer mode (ASCII or BINARY) will be automatically determined, based on the filename extension"] = "FTP overførselsmodus (ASCII eller BINARY) vil automatisk blive besluttet ud fra filernes endelser";
$net2ftp_messages["If the destination file already exists, it will be overwritten"] = "Hvis mappeplaceringen findes i forvejen bliver indholdet erstattet";

} // end upload or jupload


// -------------------------------------------------------------------------
// View module
if ($net2ftp_globals["state"] == "view") {
// -------------------------------------------------------------------------

// /modules/view/view.inc.php
$net2ftp_messages["View file %1\$s"] = "Se fil %1\$s";
$net2ftp_messages["View image %1\$s"] = "Se billedet: %1\$s";
$net2ftp_messages["View Macromedia ShockWave Flash movie %1\$s"] = "Se Macromedia ShockWave Flash film %1\$s";
$net2ftp_messages["Image"] = "Billede";

// /skins/[skin]/view1.template.php
$net2ftp_messages["Syntax highlighting powered by <a href=\"http://geshi.org\">GeSHi</a>"] = "Syntax fremhævning styres via <a href=\"http://geshi.org\">GeSHi</a>";
$net2ftp_messages["To save the image, right-click on it and choose 'Save picture as...'"] = "For at gemme billedet, højreklik og vælg 'Gem billede som...'";

} // end view


// -------------------------------------------------------------------------
// Zip module
if ($net2ftp_globals["state"] == "zip") {
// -------------------------------------------------------------------------

// /modules/zip/zip.inc.php
$net2ftp_messages["Zip entries"] = "Komprimerede filer";

// /skins/[skin]/zip1.template.php
$net2ftp_messages["Save the zip file on the FTP server as:"] = "Gem den komprimerede fil på FTP serveren som:";
$net2ftp_messages["Email the zip file in attachment to:"] = "Mail den komprimerede fil som en vedhæftning til:";
$net2ftp_messages["Note that sending files is not anonymous: your IP address as well as the time of the sending will be added to the email."] = "Bemærk det ikke er anonymt at sende filer: din IP adresse og afsendelsestidspunktet bliver noteret i mailen.";
$net2ftp_messages["Some additional comments to add in the email:"] = "Tilføj yderligere kommentarer til mailen:";

$net2ftp_messages["You did not enter a filename for the zipfile. Go back and enter a filename."] = "Du angav ikke et filnavn for den komprimerede fil. Gå tilbage og angiv et filnavn.";
$net2ftp_messages["The email address you have entered (%1\$s) does not seem to be valid.<br />Please enter an address in the format <b>username@domain.com</b>"] = "Den valgte mailadresse (%1\$s) bestod ikke valideringen.<br />Indtast en mail i formatet <b>eksempel@domæne.dk</b>";

} // end zip

?>