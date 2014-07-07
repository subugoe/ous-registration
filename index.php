<?php

// This file is part of the web-based "Application Form for New Users"
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \mainpage
///
/// This is the web-based "Application Form for New Users"
/// currently in use at University Library Braunschweig, Germany.
///
/// These scripts need MySQL and the PICA[tm] library software by OCLC.
/// The purpose of this software is as follows:
///
/// - New users of the library are expected to fill in a web form.
/// - The content is stored in a MySQL database, and can be
///   reviewed and (if necessary) corrected by library staff
///   using a web frontend.
/// - Library staff can then do one of the following:
///   - create a user account in the PICA system by means of a
///     simple mouse click
///   - print an application form on paper, with all fields filled in,
///     ready to be signed by the applicant
///   - delete the record
///
/// The initial contents of the MySQL database is defined in
/// the file dbinit.sql. The following tables exist:
///
/// <dl>
/// <dt>serial_number</dt>
///     <dd> a serial number that is assigned
///          to an applications when submitted to PICA </dd>
/// <dt>persons</dt>
///     <dd> unique information about an applicant, e.g. name, sex, etc.</dd>
///
/// <dt>addresses</dt>
///     <dd>postal address(es) of a person</dd>
///
/// <dt>usertypes</dt>
///     <dd>list of possible user types</dd>
///
/// <dt>usertype_names</dt>
///     <dd>human-readable names for a given user type</dd>
///
/// <dt>address_types</dt>
///     <dd>address types for a given user type</dd>
/// </dl>
///
/// The relations (1:N) between the tables are shown in the
/// following graph:
/// \dot
/// digraph "g" {
///     "n0" [
///             label = "persons"
///     ]
///     "n1" [
///             label = "usertypes"
///     ]
///     "n2" [
///             label = "usertype_names"
///     ]
///     "n3" [
///             label = "address_types"
///     ]
///     "n6" [
///             label = "addresses"
///     ]
///     "n7" [
///             label = "serial_number"
///     ]
///     "n0" -> "n1" [
///             label = "usertype_id"
///     ]
///     "n2" -> "n1" [
///             label = "usertype_id"
///     ]
///     "n1" -> "n3" [
///             label = "primary_address_type,\nsecondary_address_type"
///     ]
///     "n6" -> "n0" [
///             label = "person_id"
///     ]
/// }
/// \enddot

/// \file
///
/// \brief The entry page for applicants
///
/// This is the entry page for library users. They are redirected to 
/// the script edit.php, which will display the application form, 
/// and which will redirect them to register.php for the actual registration
/// process.


require_once('text.php');
require_once ('config.php');
require_once('util.php');
require_once('fields.php');

session_start();

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : $lang_default;

if (!isset($text_multi[$lang]))
	$lang = $lang_default;

$text    = $text_multi[$lang];
$buttons = $buttons_multi[$lang];
$months =  $months_multi[$lang];

$cancel=htmlentities("index.php?lang=@lang@");
$finish=htmlentities("register.php?lang=@lang@");

session_destroy();	// start with a fresh session 
redirect("edit.php?lang=$lang&finishURL=$finish&cancelURL=$cancel");

?>
