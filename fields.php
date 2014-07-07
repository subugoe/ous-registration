<?php

//
// Deklaration der Arrays die in edit.php verwendet werden 
//

// This file is part of the web-based "Application Form for New Users" 
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \file 
///
/// \brief Access an applicant's record in the database

require_once('util.php');
require_once('text.php');


/// \brief describes how to access record fields in the database
///
/// The $fields[] array contains information about how to 
/// query and change the value of record fields in the database. 
///
/// Each element is an array representing a field in a database record.
/// The sub-array consists of the following fields:
///
/// <dl>
/// <dt>label</dt> 
///	<dd> a human-readable description of the field's meaning </dd>
/// <dt>type</dt>
///	<dd> 'text', 'choice', or 'date' </dd>
/// <dt>size</dt> 
///	<dd> maximum length of input field (for "text" only) </dd>
/// <dt>choices</dt>
///	<dd> an array that contains the valid choices for the select list </dd>
/// <dt>valid</dt>      
///	<dd> user's input is considered valid if it matches this regexp </dd>
/// <dt>query</dt>      
///	<dd> sql query for retrieving the value of the field </dd>
/// <dt>update</dt>
///     <dd> sql query for modifying the value of the field </dd>
/// <dt>pica_query</dt>
///	<dd> sql query for retrieving the value of the field
///	         in the context of creating a PICA export record </dd>
/// <dt>view_query</dt>
/// 	<dd> sql query for displaying the value of the field </dd>
/// <dt>pica_field</dt>
///	<dd> corresponding field number in the PICA export record </dd>
/// </dl>





$fields = array ( 
	"last_name" => array (
		"type"   => "text",
		"size"   => 40,
		"query"  => "select last_name from persons " .
			     "where id = '@id@'",
		"update" => "update persons " . 
			     "set last_name='@val@' where id='@id@'",
		"valid"  => "/^[ -~äöüÄÖÜß]+$/",
		"pica_field" => "a105"
	),

	"first_name" => array (
		"type"   => "text",
		"size"   => 15,
		"query"  => "select first_name from persons " .
			     "where id = '@id@'",
		"update" => "update persons " . 
			     "set first_name='@val@' where id='@id@'",
		"valid"  => "/^[ -~äöüÄÖÜß]+$/",
		"pica_field" => "a107"
	),
	"title" => array (
		"type"   => "choice",
		"choices"  => array( "" => "", "Prof. Dr." => "Prof. Dr.", "Prof." => "Prof.", "Dr." => "Dr." ),
		"query"  => "select title from persons " .
			     "where id = '@id@'",
		"update" => "update persons " . 
			     "set title='@val@' where id='@id@'",
		"valid"  => "/^[ -~äöüÄÖÜß]*$/",
		"pica_field" => "a108"
	),
	"sex" => array (
		"type"   => "choice",
		"query"  => "select sex from persons " .
			     "where id = '@id@'",
		"update" => "update persons " . 
			     "set sex='@val@' where id='@id@'",
		"valid"  => "/^[mw]$/",
		"pica_field" => "a110"
	),	
	"birthday" => array (
		"type"   => "date",
		"query"  => "select birthday " .
			    "from persons where id='@id@'",
		"update" => "update persons " . 
			     "set birthday='@val@' where id='@id@'",
		"valid"  => "/^[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]$/",
		"pica_field" => "a109",
		"pica_query"  => "select DATE_FORMAT(birthday,'%d-%m-%Y') " .
			    "from persons where id='@id@'",
		"view_query" => "select DATE_FORMAT(birthday,'%d-%m-%Y') " .
			    "from persons where id='@id@'"
	),	
	"usertype" => array (
		"type"   => "choice",
		"query"  => "select usertype_id from persons " .
			     "where id = '@id@'",
		"update" => "update persons " . 
			     "set usertype_id='@val@' where id='@id@'",
		"choice"  => array(),
		"valid"  => "/^[0-9]*$/",
		"pica_field" => "a103",
		"pica_query"  => "select usertypes.pica_user_group " .
				 "from usertypes, persons " .
			         "where persons.usertype_id = usertypes.id " .
				 "and persons.id = '@id@'"
	),	
	"student_id" => array (
		"type"   => "text",
		"size"   => 12,
		"query"  => "select TRIM( LEADING '0' FROM student_id )  from persons " . 
			    "where id = '@id@'",
		"update" => "update persons set student_id='@val@' " .
			    "where id='@id@'",
		"valid"  => "/^(|[0-9]*)$/",
		"pica_field" => "a101"
	),


 // ***** E-MAIL CHECKBOX  *****
  "email_checkbox" => array (
      "type"   => "checkbox",
      "size"   => 15,
      "javascript" => "style=\"margin-left:0px;\" onClick=\"if (this.checked)
 {this.form.email.disabled=false; this.form.email_checkbox.value='t'; this.form.email_confirm.disabled=false; this.form.email.className='enab'; this.form.email_confirm.className='enab';} else {this.form.email.disabled=true;this.form.email_checkbox.value='f';this.form.email_confirm.disabled=true; this.form.email.className='dis';this.form.email_confirm.className='dis'}\">",
      "query"  => "select email_checkbox from persons " . 
       "where id = '@id@'",
  "update" => "update persons set email_checkbox='@val@' " .
       "where id='@id@'",
  "valid"  => "/^[ft]$/"
	), 
 
// ***** E-MAIL *****
  "email" => array (
  "type"   => "text",
  "size"   => 40,
  "javascript" => "class=dis disabled=true",
  "query"  => "select email from persons " . 
       "where id = '@id@'",
  "update" => "update persons set email='@val@' " .
       "where id='@id@'",
        "valid"  => '/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Za-z]{2}|cat|com|pro|org|net|gov|int|edu|mil|biz|info|mobi|name|aero|asia|coop|jobs|museum)$/i',
  "pica_field" => "a112"
	),

// ***** E-MAIL WIEDERHOLUNG *****
  "email_confirm" => array (
  "type"   => "text",
  "size"   => 40,
  "javascript" => 'class=dis  disabled=true name="TEST"', 
  "query"  => "select email_confirm from persons " . 
  "where id = '@id@'",
  "update" => "update persons set email_confirm='@val@' " .
       "where id='@id@'", 
        "valid"  => "/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Za-z]{2}|cat|com|pro|org|net|gov|int|edu|mil|biz|info|mobi|name|aero|asia|coop|jobs|museum)$/i"
	), 

 

		"carry_over_1" => array (
		"type"   => "text",
		"size"   => 64,
		"query"  => "select carry_over  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'true'",
		"update" => "update addresses set carry_over='@val@' " . 
			    "where person_id='@id@' and is_primary = 'true'; ",
		"valid"  => "/^[ -~äöüÄÖÜß]*$/",
		"pica_field" => "a310"
	),
	"street_1" => array (
		"type"   => "text",
		"size"   => 45,
		"query"  => "select street  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'true'",
		"update" => "update addresses set street='@val@' " . 
			    "where person_id='@id@' and is_primary = 'true';",
		"valid"  => "/^[ -~äöüÄÖÜß]+$/",
		"pica_field" => "a303"

	),
	"house_1" => array (
		"type"   => "text",
		"size"   => 6,
		"query"  => "select house  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'true'",
		"update" => "update addresses set house='@val@' " . 
			    "where person_id='@id@' and is_primary = 'true'; ",
		"valid"  => "/^[a-zA-Z0-9 -]+$/",
		"pica_field" => "a303"
	),
	"zip_1" => array (
		"type"   => "text",
		"size"   => 5,
		"query"  => "select zip  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'true'",
		"update" => "update addresses set zip='@val@' " . 
			    "where person_id='@id@' and is_primary = 'true'; ",
		"valid"  => "/^[0-9][0-9][0-9][0-9][0-9]$/",
		"pica_field" => "a304"
	),
	"town_1" => array (
		"type"   => "text",
		"size"   => 64,
		"query"  => "select town  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'true'",
		"update" => "update addresses set town='@val@' " . 
			    "where person_id='@id@' and is_primary = 'true'; ",
		"valid"  => "/^[ -~äöüÄÖÜß]+$/",
		"pica_field" => "a305"
	),
	"phone_1" => array (
		"label"  => "Telefon:",
		"type"   => "text",
		"size"   => 20,
		"query"  => "select phone  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'true'",
		"update" => "update addresses set phone='@val@' " . 
			    "where person_id='@id@' and is_primary = 'true'; ",
		"valid"  => "/^[-0-9 \/]*$/",
		"pica_field" => "a308"
	),

	"mobile_1" => array (
		"label"  => "Mobil:",
		"type"   => "text",
		"size"   => 20,
		"query"  => "select mobile_phone  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'true'",
		"update" => "update addresses set mobile_phone='@val@' " . 
			    "where person_id='@id@' and is_primary = 'true'; ",
		"valid"  => "/^[-0-9 \/]*$/",
		"pica_field" => "a311"
	),
	

	"carry_over_2" => array (
		"label"  => "c/o:",
		"type"   => "text",
		"size"   => 64,
		"query"  => "select carry_over  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'false'",
		"update" => "update addresses set carry_over='@val@' " . 
			    "where person_id='@id@' and is_primary = 'false'; ",
		"valid"  => "/^[ -~äöüÄÖÜß]*$/",
		"pica_field" => "b310"
	),
	"street_2" => array (
		"label"  => "Straße:",
		"type"   => "text",
		"size"   => 45,
		"query"  => "select street  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'false'",
		"update" => "update addresses set street='@val@' " . 
			    "where person_id='@id@' and is_primary = 'false';",
		"valid"  => "/^[ -~äöüÄÖÜß]*$/",
		"pica_field" => "b303"
	),
	"house_2" => array (
		"label"  => "Hausnummer:",
		"type"   => "text",
		"size"   => 6,
		"query"  => "select house  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'false'",
		"update" => "update addresses set house='@val@' " . 
			    "where person_id='@id@' and is_primary = 'false'; ",
		"valid"  => "/^[a-zA-Z0-9 -]*$/",
		"pica_field" => "b303"
	),
	"zip_2" => array (
		"label"  => "PLZ:",
		"type"   => "text",
		"size"   => 5,
		"query"  => "select zip  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'false'",
		"update" => "update addresses set zip='@val@' " . 
			    "where person_id='@id@' and is_primary = 'false'; ",
		"valid"  => "/^(|[0-9][0-9][0-9][0-9][0-9])$/",
		"pica_field" => "b304"
	),
	"town_2" => array (
		"label"  => "Ort:",
		"type"   => "text",
		"size"   => 64,
		"query"  => "select town  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'false'",
		"update" => "update addresses set town='@val@' " . 
			    "where person_id='@id@' and is_primary = 'false'; ",
		"valid"  => "/^[ -~äöüÄÖÜß]*$/",
		"pica_field" => "b305"
	),
	"phone_2" => array (
		"label"  => "Telefon:",
		"type"   => "text",
		"size"   => 20,
		"query"  => "select phone  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'false'",
		"update" => "update addresses set phone='@val@' " . 
			    "where person_id='@id@' and is_primary = 'false'; ",
		"valid"  => "/^[-0-9 \/]*$/",
		"pica_field" => "b308"
	),

	"mobile_2" => array (
		"label"  => "Mobil:",
		"type"   => "text",
		"size"   => 20,
		"query"  => "select mobile_phone  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'false'",
		"update" => "update addresses set mobile_phone='@val@' " . 
			    "where person_id='@id@' and is_primary = 'false'; ",
		"valid"  => "/^[-0-9 \/]*$/",
		"pica_field" => "b311"
	),

	"nametag" => array (	
		"type"   => "text",
		"size"   => 6,
		"query"  => "select usertype_names.name "
			  . "from usertype_names, usertypes, "
	   		  . " persons where usertypes.id=persons.usertype_id"
			  . " and usertype_names.usertype_id = usertypes.id"
			  . " and usertype_names.type = 'short' "
			  . " and persons.id='@id@'",
		"update" => "",				// read-only field
		"valid"  => "/^[a-zA-Z0-9]*$/",
		"pica_field" => "a106"
	),
	"notabene" => array (	
		"type"   => "text",
		"size"   => 6,
		"query"  => "select pica_id from persons where id='@id@'",
		"update" => "update persons set pica_id='@val@' " .
			    " where id='@id@'",
		"valid"  => "/^[0-9][0-9]\/[0-9]*$/",
		"pica_field" => "a114"
	),
	"room_1" => array (
		"type"   => "text",
		"size"   => 10,
		"query"  => "select room  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'true'",
		"update" => "update addresses set room='@val@' " . 
			    "where person_id='@id@' and is_primary = 'true'",
		"valid"  => "/^[ -~äöüÄÖÜß]*$/",
		"pica_field" => "a303",
		"pica_query" => "select IF(length(room) = 0, '', " 
			      . "CONCAT('/ ', room)) from addresses "
			      . "where person_id='@id@' and is_primary='true'"
	),
	"room_2" => array (
		"type"   => "text",
		"size"   => 10,
		"query"  => "select room  " .
			    "from addresses where person_id = '@id@' " . 
			    "and is_primary = 'false'",
		"update" => "update addresses set room='@val@' " . 
			    "where person_id='@id@' and is_primary = 'false'",
		"valid"  => "/^[ -~äöüÄÖÜß]*$/",
		"pica_field" => "b303",
		"pica_query" => "select IF(length(room) = 0, '', " 
			      . "CONCAT('/ ', room)) from addresses "
			      . "where person_id='@id@' and is_primary='false'"
	),
	"expiry_date" => array (
		"type"   => "text",
		"size"   => 10,
		"query"  => "select DATE_ADD(NOW(), INTERVAL expire_after DAY) from usertypes, persons where persons.id=@id@ and persons.usertype_id = usertypes.id" ,
		"update" => "",
		"valid"  => "/^[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]$/",
		"pica_field" => "a202",
		"pica_query"  => "select DATE_FORMAT(DATE_ADD(NOW(), INTERVAL expire_after DAY),\"%d-%m-%Y\") from usertypes, persons where persons.id=@id@ and persons.usertype_id = usertypes.id" ,
		"view_query"  => "select DATE_FORMAT(DATE_ADD(NOW(), INTERVAL expire_after DAY),\"%d-%m-%Y\") from usertypes, persons where persons.id=@id@ and persons.usertype_id = usertypes.id" 
	),
	"entry_date" => array (
		"type"   => "date",
		"query"  => "select entry_date " .
			    "from persons where id='@id@'",
		"update" => "update persons " . 
			     "set entry_date='@val@' where id='@id@'",
		"valid"  => "/^[0-9][0-9][0-9][0-9]-[0-9][0-9]-[0-9][0-9]$/",
		"view_query" => "select DATE_FORMAT(entry_date,'%d-%m-%Y') " .
			    "from persons where id='@id@'"
	),	
	"password" => array (
		"label"  => "Passwort:",
		"type"   => "text",
		"size"   => 10,
		"query"  => "select DATE_FORMAT(birthday, '%d%m%y') from " .
			    "persons where id='@id@'",
		"update" => "",
		"valid"  => "/^[0-9][0-9][0-9][0-9][0-9][0-9]$/",
		"pica_field" => "b401"
	),
	"barcode" => array (
		"label"  => "Barcode:",
		"type"   => "text",
		"size"   => 12,
		"query"  => "select pica_barcode  " .
			    "from persons where id = '@id@' " ,
		"update" => "update persons set pica_barcode='@val@' " . 
			    "where id='@id@'",
		"valid"  => "/^[0-9\/]*[0-9xX]$/",
		"pica_field" => "a102"
	)
);

/// \brief initialize the $fields[] array 
///
/// This function must be called before $fields[] can be accessed.
///
/// \param $link an open handle to the MySQL database
///
/// \returns nothing

function fields_init($link, $lang) {
	global $field_labels, $fields, $text_multi;

	$q  = "select usertype_names.usertype_id, usertype_names.name " 
	    . "from usertype_names where "
	    . "usertype_names.type = 'u' and usertype_names.lang='@lang@'";

	$result = db_query_mysql($link, $q, array("@lang@" => $lang));

	foreach ($result as $row) 
		$fields["usertype"]["choices"][$row["usertype_id"]] = 
			$row["name"];

	foreach ($fields as $k => $v) {
		if (!isset($v['pica_query']))
			$fields[$k]['pica_query'] = $v['query'];

		if (!isset($v['view_query']))
			$fields[$k]['view_query'] = $v['query'];
	}

	## assign field labels

	foreach ($field_labels[$lang] as $k => $v) {
		$fields[$k]['label'] = $v;
	}

	$fields['sex']['choices'] = array();

	$fields['sex']['choices']['m'] = $text_multi[$lang]['sex_m'];
	$fields['sex']['choices']['w'] = $text_multi[$lang]['sex_w'];
}

/// \brief delivers HTML code of an input control for $field
///
/// This function delivers HTML code suitable for embedding into HTML forms 
/// for editing database records. 
///
/// \param $link  an open handle to the MySQL database
/// \param $field an index into the $fields[] array
/// \param $name  name of the input control 
/// \param $value initial value of the input control 
///
/// \returns HTML code

function input_control($field, $name, $value) {
	global $fields;
	
	if (isset($fields[$field])) {
		$f = $fields[$field];

	if ($f["type"] == "text") {

		print '<input type="text" name="' . $name . '" ';
		print 'value="' . htmlentities($value) . '" ';
		print 'size="' . $f["size"] . '" ';
		print 'maxlength="' . $f["size"] . '" ';
		print $f["javascript"]. '>';

	}
	
// ***** E-MAIL CHECKBOX *****
 else if ($f["type"] == "checkbox") {
  if($name == "email_checkbox" && $value == "")
  $value = "f";

  print '<input type="checkbox" name="' . $name . '" ';
  print 'value="' . htmlentities($value) .'"';
  print $f["javascript"];

 }	
	
 else if ($f["type"] == "choice") {
  // ***** USERTYPE MIT E-MAIL
  if($value>19 && $name=="usertype"){
   $value=$value-20;
   
  }
		
		print '<select name="' . $name . '">';
		foreach ($f["choices"] as $k => $v) {
			print '<option value="' . htmlentities($k) . '"';
			if ($k == $value) 
				print ' selected="yes" ';
			print '>';
			print htmlentities($v);
			print '</option>';
		}
		print '</select>';
	} else if ($f["type"] == "date") {
		global $months;

		list($year, $month, $day) = split('-', $value,3); 

		print '<input type="text" name="' . $name . '_day" ';
		print 'size="2" maxlength="2" value="' . $day . '"> &nbsp;';

		print '<select name="' . $name . '_month">';
		foreach ($months as $k => $v) {
			print '<option value="' . htmlentities($k) . '"';
			if ($k == $month) 
				print ' selected="yes" ';
			print '>';
			print htmlentities($v);
			print '</option>';
		}
		print '</select>';

		print '&nbsp; <input type="text" name="' . $name . '_year" ';
		print 'size="4" maxlength="4" value="' . $year . '">';
		
	}
	}
	
}
?>
