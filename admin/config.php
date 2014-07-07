<?php

// This file is part of the web-based "Application Form for New Users" 
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \file 
/// \brief configuration file for the web frontend for library staff

$iln = '99'; ///< \brief ILN number of the library

/// \brief command for PICA export
///
/// This shell command is expected to be a wrapper for the 
/// PICA ousp_upd_borrower command. It should read a 
/// borrower record from stdin, and exit with 0 if the
/// transfer was successful. 
///
/// \sa scripts/pica_upload_client and scripts/pica_upload_server
/// \sa PICA documentation, chapter 6.3, for a description of the 
/// input format expected by oups_upd_borrower.


$pica_export_command = "../pica/pica_upload_client > /dev/null";

// Print test File to 
//$pica_export_command="cat > /tmp/pica.out"; 


// PICA database settings

// pica

$LBSServer = "picaserver.my.library.org";
$LBSDB = "lbsdb";
$LBSUser = "picauser";
$LBSPw = "picapassword";


// mysql 

$dbhost = "localhost";
$dbname = "application";

$dbuser = "staff";
$dbpass = "secret2";

// delete users that have not been confirmed for ... days
$too_old = 30;

// $dbuser="root";		
// $dbpass="";

$lang_default = "de";

?>
