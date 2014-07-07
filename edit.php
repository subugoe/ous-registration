<?php

// Eingabeformulare der Seiten 1 bis ...
// Deklaration der Arrays für die Datenbank
// --> fields.php



// This file is part of the web-based "Application Form for New Users" 
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \file 
///
/// \brief The web form for applicants 
/// 
/// This script displays and processes the web form 
/// for new users of the library.
///
/// The form consists of several pages. When the last page is
/// reached, the content of the form is stored into the MySQL database.
///
/// \param finishURL The user will be redirected to this URL when he has completed the form.
/// \param cancelURL The user will be redirected to this URL if he has pressed the 'cancel' button
/// \param button the value of the "submit" button that was pressed by the user
/// \param various the data entered by the user into the html form
///
/// \see $pageinfo[...]["valid"] for a full list of permissible parameters.

require_once('text.php');
require_once ('config.php');
require_once('util.php');
require_once('fields.php');

session_start();

// select language

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : $lang_default;

if (!isset($text_multi[$lang]))
	$lang = $lang_default;

$text    = $text_multi[$lang];
$buttons = $buttons_multi[$lang];
$months =  $months_multi[$lang];

// init db

($link = mysql_pconnect($dbhost, $dbuser, $dbpass)) or db_error_mysql();
mysql_select_db($dbname,$link) or db_error_mysql();

// init $fields[]

fields_init($link, $lang);


// print "<body>button: " . $buttons['ok'];


/// \brief info on how to render and parse the application form
///
/// The $pageinfo[] array describes the multi-page HTML form 
/// that the applicant is required to fill in.
///
/// $pageinfo[N] describes page N and contains an associative array 
/// with the following (required) elements:
///
/// - $pageinfo[N]["valid"] is an array suitable as first parameter to the 
///   param_ok() function. It is used for checking the validity of 
///   the submitted form data.
/// - $pageinfo[N]["edit"] is an array containing data from which the 
///   HTML form is rendered. The form contains a big HTML table, 
///   and each entry in this array describes a row in that table.
///   See the source code for details on how the data is processed.

$pageinfo = array(


	1 => array (	// page 1

	   "edit" => array (
		array( label => $fields["last_name"]["label"], 
		       fields => array("last_name")),
		array( label => $fields["first_name"]["label"], 
		       fields => array("first_name")),
		array( label => $fields["title"]["label"], 
		       fields => array("title")),
		array( label => $fields["sex"]["label"], 
		       fields => array("sex")),
		array( label => $fields["birthday"]["label"], 
		       fields => array("birthday")),
		array( label => $text["i_am"],
		       fields => array("usertype")),
		array( label => $fields["student_id"]["label"], 
		       fields => array("student_id")),
//*************************** V2.0 Eingabefelder E-Mail und E-Mail-Bestaetigung **********************************		
		array( label => $fields["email_checkbox"]["label"], 
		       fields => array("email_checkbox")),
		array( label => $fields["email"]["label"], 
		       fields => array("email")),
		array( label => $fields["email_confirm"]["label"], 
		       fields => array("email_confirm")),
		       
 //***************************************************************************************************************
		),
	
	
	   "valid_params" => array (
		"button" => "/^(" . $buttons['next'] . "|" .
				    $buttons['cancel'] . "|" . 
			    ")$/",
		"last_name" => $fields["last_name"]["valid"],
		"first_name" => $fields["first_name"]["valid"],
		"title" => $fields["title"]["valid"],
		"sex" => $fields["sex"]["valid"],
		"birthday_day" => "/^[0-9][0-9]$/",
		"birthday_month" => "/^[0-9][0-9]$/",
		"birthday_year" => "/^[0-9][0-9][0-9][0-9]$/",
		"usertype" => $fields["usertype"]["valid"],
		"student_id" => $fields["student_id"]["valid"],
		"lang" => "/^(de|en)$/",
		"email_checkbox" => $fields["email_checkbox"]["valid"],
		"email" => $fields["email"]["valid"],
		"email_confirm" => $fields["email_confirm"]["valid"],

		"finishURL" => "/^.*$/",
		"cancelURL" => "/^.*$/"
	   ) 
	),

	2 => array (	// page 2

	    "edit" => array(
		array( label => $fields["carry_over_1"]["label"], 
		       fields => array("carry_over_1")),
		array( 	"label" => 
			$fields['street_1']['label'] . " / " .
			$fields['house_1']['label'] . " / " .
			$fields['room_1']['label'],
			"fields" => array("street_1","house_1","room_1") ),
		array(  "label" => 
			$fields['zip_1']['label'] . " / " .
			$fields['town_1']['label'],
			"fields" => array("zip_1", "town_1") ),
		array( 	"label" => $fields["phone_1"]["label"], 
			"fields" => array("phone_1")),
		array(  "label" => $fields["mobile_1"]["label"], 
			"fields" => array("mobile_1"))
	    ),

	    "valid_params" => array (
		"button" => "/^(" . $buttons['next'] . "|" .
				    $buttons['prev'] . "|" . 
				    $buttons['cancel'] . "|" . 
			    ")$/",
		"carry_over_1" => $fields["carry_over_1"]["valid"],
		"street_1" => $fields["street_1"]["valid"],
		"house_1" => $fields["house_1"]["valid"],
		"room_1" => $fields["room_1"]["valid"],
		"zip_1" => $fields["zip_1"]["valid"],
		"town_1" => $fields["town_1"]["valid"],
		"phone_1" => $fields["phone_1"]["valid"],
		"mobile_1" => $fields["mobile_1"]["valid"],
		"lang" => "/^(de|en)$/",
		"finishURL" => "/^.*$/",
		"cancelURL" => "/^.*$/"
	      )	
	),
	3 => array (	// page 3

	    "edit" => array(
		array( label => $fields["carry_over_2"]["label"], 
		       fields => array("carry_over_2")),
		array( 	"label" => 
			$fields['street_2']['label'] . " / " .
			$fields['house_2']['label'] . " / " .
			$fields['room_2']['label'],
			"fields" => array("street_2","house_2","room_2") ),
		array(  "label" => 
			$fields['zip_2']['label'] . " / " .
			$fields['town_2']['label'],
			"fields" => array("zip_2", "town_2") ),
		array( 	"label" => $fields["phone_2"]["label"], 
			"fields" => array("phone_2")),
		array(  "label" => $fields["mobile_2"]["label"], 
			"fields" => array("mobile_2"))
	    ),

	    "valid_params" => array (
		"button" => "/^(" . $buttons['next'] . "|" .
				    $buttons['prev'] . "|" . 
				    $buttons['cancel'] . "|" . 
			    ")$/",
		"carry_over_2" => $fields["carry_over_2"]["valid"],
		"street_2" => $fields["street_2"]["valid"],
		"house_2" => $fields["house_2"]["valid"],
		"room_2" => $fields["room_2"]["valid"],
		"zip_2" => $fields["zip_2"]["valid"],
		"town_2" => $fields["town_2"]["valid"],
		"phone_2" => $fields["phone_2"]["valid"],
		"mobile_2" => $fields["mobile_2"]["valid"],
		"lang" => "/^(de|en)$/",
		"finishURL" => "/^.*$/",
		"cancelURL" => "/^.*$/"
	      )	
	),

	4 => array (	// page 4
	    "edit" => array(),
	    "valid_params" => array(
		"button" => "/^(" . $buttons['next'] . "|" .
				    $buttons['finish'] . "|" . 
				    $buttons['cancel'] . "|" . 
			    ")$/",
		"lang" => "/^(de|en)$/",
		"finishURL" => "/^.*$/",
		"cancelURL" => "/^.*$/"
	    )
	)

);


// parameters

// a parameter is considered valid if the corresponding 
// regular expression matches


// default values for the parameters

$default_params = array(
	"button" => "",
	"page" => "1",
	"lang" => $lang_default
);

// initialize parameters

foreach ($default_params as  $k => $v) {
	if (!isset($_SESSION[$k]))
		$_SESSION[$k] = $v;
}


// check user input

$_SESSION["error"] = array();



foreach ( array_merge($_POST, $_GET) as $k => $v)  {

	$v = normalize_input($v); 	// strip blanks, accents, etc.

	// match against regexp for valid input (see $pageinfo[]) 

	if (!param_ok($pageinfo[$_SESSION['page']]["valid_params"], $k, $v )) { 
		$_SESSION["error"][$k] = TRUE; 
	}

	$_SESSION[$k] = $v;

	// print "$k ->  $v <br>\n"; 
}

// special case: TU BS staff members need to provide name of institute
// XXX there should be a generic mechanism for this kind of stuff

if ( ($_SESSION['usertype'] == 4)  AND 
     ($_SESSION['page'] == 2) AND
     trim($_SESSION['carry_over_1']) == '' ) {

	     $_SESSION["error"]["carry_over_1"] = TRUE;

}

// special case: check date of birth

if (isset($_SESSION["birthday_month"]))  {

	$year = (isset($_SESSION["birthday_year"])) ? 
			$_SESSION["birthday_year"] : "0000";
	$month = (isset($_SESSION["birthday_month"])) ? 
			$_SESSION["birthday_month"] : "00";
	$day = (isset($_SESSION["birthday_day"])) ? 
			$_SESSION["birthday_day"] : "00";


	if (!checkdate($month, $day, $year) ) {
		 $_SESSION["error"]["birthday"] = TRUE;	// invalid date
	} else {

		if (strlen($day) == 1)
			$day = "0$day";

		if (strlen($year) == 1)
			$year = "000$year";
		else if (strlen($year) == 2)
			$year = "00$year";
		else if (strlen($year) == 3)
			$year = "0$year";

		$thisyear = strftime('%Y');

		if ($year < 1900 or (($thisyear - $year) < 16) )
		 	$_SESSION["error"]["birthday"] = TRUE;	
	}

	$_SESSION["birthday"] = "$year-$month-$day";

	unset($_SESSION["error"]["birthday_day"]);
	unset($_SESSION["error"]["birthday_month"]);
	unset($_SESSION["error"]["birthday_year"]);
}

// special case: check student id

if (isset($_SESSION["student_id"]))  {

 $user_type = $_SESSION["usertype"];

 // only students can specify a student id

 // a student //CE ERG
 if ( (($user_type <= 3)||($user_type >= 21 && $user_type <= 23))  and empty($_SESSION["student_id"]))    
  $_SESSION["error"]["student_id"] = TRUE;

 // no student 
 //if ( $user_type > 3  and !empty($_SESSION["student_id"]))  { 
    if ( (($user_type > 3)&&($user_type < 21 && $user_type > 23)) and !empty($_SESSION["student_id"]))  { 
  $_SESSION["student_id"] = "";
  unset($_SESSION["error"]["student_id"]);
 }
}


// ********************************************************* V2.0 Ueberpruefung der Gleichheit der angegebenen E-Mail-Adressen **************************
if (isset($_SESSION["email_checkbox"]))  {

$mail1=$_SESSION["email"];
$mail2=$_SESSION["email_confirm"];
$composition_email = strcmp($mail1,$mail2);
if($composition_email!=0){
     $_SESSION["error"]["email"] = TRUE;
     $_SESSION["error"]["email_confirm"] = TRUE;
}
}

/*
if (isset($_SESSION["email_checkbox"]))  {
// print $_SESSION["email"];
$mail1=$_SESSION["email"];
$mail2=$_SESSION["email_confirm"];
$composition_email = strcmp($mail1,$mail2);
if($composition_email==0){

}
else
{
     $_SESSION["error"]["email"] = TRUE;
     $_SESSION["error"]["email_confirm"] = TRUE;
}
}
*/
// ******************************************************************************************************************************************************

// evaluate button that the user pressed ("next", "previous", "cancel", etc.)

if (!empty($_SESSION["button"])) {
	$b = $_SESSION["button"];

	// print "b=$b<br>";


	if ($b == $buttons['prev']) 
		$_SESSION['page']--;
	else if (($b == $buttons['next']) or ($b == $buttons['finish'])) {
		if (empty($_SESSION['error']))
			$_SESSION['page']++;
	}
	else if ($b == $buttons['cancel'])  {
		$url = strtr($_SESSION['cancelURL'], 
			     array('@lang@' => $lang));
		session_destroy();
		redirect($url);
	}

	unset($_SESSION["button"]);
}


// finished

if ($_SESSION['page'] > 4) {
	$_SESSION['edit_finished'] = true;
	$url = strtr($_SESSION['finishURL'], array('@lang@' => $lang));
	redirect($url);
}

// display web page header 

print strtr($text['html_header'], array( "@notabene@" => "", "@bodyattr@" => "",
	"@url-de@" => "edit.php?lang=de", "@url-en@" => "edit.php?lang=en" ));

print $text['user_info'];
// Seite x von y

$step = $text['step1'].($_SESSION["page"]).$text['step2'];
echo '<b><font color="#336699">';
echo $step;
echo '</font></b><br /><br />';
// Seite x von y

print '<script type="text/javascript">'.
'function confirmCancel(form){'.
'if (confirm("Sind Sie sicher, dass Sie abbrechen moechten? Die '.
 'Eingaben/Änderungen aller bisher ausgefuellten Formulare werden '.
 'gelöscht/ignoriert."))'.
    ' {'.
    ' return true'.
    ' }'.
   'else'.
     '{'.
    ' return false'.
   '  }'.
  ' }'.
 '</script>';

print '<form method="POST">';

// display content

if ($_SESSION["page"] < 1) $_SESSION["page"] = 1;
if ($_SESSION["page"] > 5) $_SESSION["page"] = 5;
//********************************* V2.0 Disclaimer anzeigen *******************************************
if ($_SESSION["page"]>1) $text['disclaimer']="";
//******************************************************************************************************
$p = $_SESSION["page"];


$pi_entry = $pageinfo[$p]["edit"];

// show incorrect entries by marking them with a big red cross

$errors=FALSE;

if (!empty($_SESSION["error"])) {

	foreach ($pi_entry as $k => $v) {

		$is_err = FALSE;

		foreach ( $v["fields"] as $f) {
			// print "field: $f<br>";

			if (!empty($_SESSION["error"][$f]))
				$is_err = TRUE;
		} 

		// mark with a red cross

		if ($is_err) {
			$pi_entry[$k]["label"] = 
				$text["error"] .  $pi_entry[$k]["label"];
			$errors=TRUE;
		}
	}

}

// print the table that contains the HTML form

// print "page: $p <br>";

if (($p == 2)  or ($p == 3)) {
	
	$x = ($p == 2) ? "primary" : "secondary";

	$q = "select address_types.name  " .
	     "from address_types, usertypes " .
	     "where address_types.id = usertypes.${x}_address_type " .
	     "and usertypes.id='@id@' and lang='@lang@'";


	// foreach ($_SESSION as $k => $v) {
	//	print "$k -> $v <br>";
	//}

	$r = db_query_mysql($link, $q, 
		array('@id@' => $_SESSION['usertype'], '@lang@' => $lang));

	$usertype_name = (empty($r)) ? "" : $r[1][0];
	
	print "<h1>" . htmlentities($usertype_name) . "</h1>";

// xxx
//	if (($user_type == "Institutsanschrift") and ($p == 2 or $p == 3)) 
//		$pi_entry[0]["label"] = "Institut:";


}

if ($p == 4) {
	// table with user data

// 	\brief HTML table templates for use with print_table()

	$table1 = array(
		array(  "label" => $fields['last_name']["label"],
			"value" =>  $_SESSION['last_name'],
		     ),
		array(  "label" => $fields['first_name']["label"],
			"value" =>  $_SESSION['first_name'],
		     ),
		array(  "label" => $fields['title']["label"],
			"value" =>  $_SESSION['title'],
		     ),
		array(  "label" => $fields['sex']["label"],
			"value" =>  ($_SESSION['sex'] == m ) ? $text['sex_m'] : $text['sex_w'],
		     )
	);


	list( $year, $month, $day ) =  split('-',$_SESSION['birthday']);

	$table2 = array(
		array(  "label" => $fields['birthday']["label"],
			"value" =>  $day . "-" . $month . "-" . $year
		     ),

		array(  "label" => $fields['usertype']["label"], 
			"query"  => "select usertype_names.name " . 
				    "from usertype_names " . 
				    "where usertype_id = @usertype@ " . 
				    "and usertype_names.type = '@sex@' " .
				    "and lang='@lang@'"
		     ),
	
		array(  "label" => $fields['student_id']["label"],
			"value" => $_SESSION['student_id']
		     ),

	array(  "label" => $fields['email']["label"],
			"value" => $_SESSION['email']
		     )

/*	
	array(  "label" => "&nbsp;",
			"value" => ""
		     )
*/
	);


	$table3 = array(
		array(  "label" => "&nbsp",
			"query" => "select address_types.name  " .
				   "from address_types, usertypes " .
				   "where address_types.id = usertypes.primary_address_type " .
	     			   "and usertypes.id='@usertype@' and lang='@lang@'"
		     ),
		array(  "label" => $fields['carry_over_1']['label'],
			"value" => $_SESSION['carry_over_1'] 
		     ),
	
		array(  "label" => $fields['street_1']['label'] . " / " . 
				   $fields['house_1']['label'],
			"value" => $_SESSION['street_1'] . " " . $_SESSION['house_1']
		     ),
		array(  "label" => $fields['room_1']['label'],
			"value" => $_SESSION['room_1'] 
		     ),
		array(  "label" => $fields['zip_1']['label'] . " / " .
				   $fields['town_1']['label'],
			"value" => $_SESSION['zip_1'] . " " . $_SESSION['town_1'] 
		     ),
		array(  "label" => $fields['phone_1']["label"],
			"value" => $_SESSION['phone_1']
		     ),
		array(  "label" => $fields['mobile_1']["label"],
			"value" => $_SESSION['mobile_1']
	     )
	);

	$table4 = array(
		array(  "label" => "&nbsp;",
			"query" => "select address_types.name  " .
				   "from address_types, usertypes " .
				   "where address_types.id = usertypes.secondary_address_type " .
	     			   "and usertypes.id='@usertype@' and lang='@lang@'"
		     ),
		array(  "label" => $fields['carry_over_2']['label'],
			"value" => $_SESSION['carry_over_2'] 
		     ),
	
		array(  "label" => $fields['street_2']['label'] . " / " . 
				   $fields['house_2']['label'],
			"value" => $_SESSION['street_2'] . " " . $_SESSION['house_2']
		     ),
		array(  "label" => $fields['room_2']['label'],
			"value" => $_SESSION['room_2'] 
		     ),
		array(  "label" => $fields['zip_2']['label'] . " / " .
				   $fields['town_2']['label'],
			"value" => $_SESSION['zip_2'] . " " . $_SESSION['town_2'] 
		     ),
		array(  "label" => $fields['phone_2']["label"],
			"value" => $_SESSION['phone_2']
		     ),
		array(  "label" => $fields['mobile_2']["label"],
			"value" => $_SESSION['mobile_2']
		     )
	);

	// print table 

	$kw = array('@id@' => $_SESSION['id'], '@lang@' => $lang,
		    '@usertype@' => $_SESSION['usertype'], '@sex@' => $_SESSION['sex'] );

	print '<table width="100%" border="1" ><tr><td width="50%">';
	print_table($table1, 1 , "border=0", $link, $kw);
	print '</td><td>';
	print_table($table2, 1 , "border=0", $link, $kw);
	print '</td></tr><tr><td>';
	print_table($table3, 1 , "border=0", $link, $kw);
	print '</td><td>';
	print_table($table4, 1 , "border=0", $link, $kw);
	print '</td></tr></table>';
	
//********************************* V2.0 Disclaimer-Info anzeigen *******************************************
if ($_SESSION["email"] != "")
{
 print $text['disclaimer_info']; 
}
else
{
}

//***********************************************************************************************************
	
	print $text['info_1']; // info for user

} else {

	$kw = array('@lang@' => $lang);
	print_table($pi_entry, 1, "border=\"0\"", $link, $kw); 

// *********************************** V2.0 TEST ****************************************************
// print $text['disclaimer'];
// **************************************************************************************************

	// explain to the user what the big red cross means
	if ($errors) {
		print $text["error"];
		print $text["error_msg"];
	} else {
		print "<br>";
	} 
}

// *********************************** V2.0 Disclaimer anzeigen *************************************
 print $text['disclaimer'];
// **************************************************************************************************

// display "next", "previous", "cancel" buttons
	

$x = ($p >  1) ? "" : 'disabled="yes"';
$val = ($p ==  4) ? $buttons['finish'] : $buttons['next'];

print "<input type=\"submit\" name=\"button\" " .
      "value=\"" . $buttons['prev'] . "\" $x>"; 

print "<input type=\"submit\" name=\"button\" value=\"$val\" >";

// print '&nbsp; &nbsp; <input name="button" ' .
//      'type="submit" value="' . $buttons['cancel'] . '"> &nbsp;';
      
print '&nbsp; &nbsp; <input name="button" onclick="return confirmCancel(this)"' .
      'type="submit" value="' . $buttons['cancel'] . '"> &nbsp;';


print $text['html_footer'];
mysql_close($link); 

?>
