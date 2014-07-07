<?php

// This file is part of the web-based "Application Form for New Users" 
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \file 
///
/// \brief The Library staff's web frontend (entry page)
///
/// Library staff has access to a web frontend that allows you to:
/// 
/// - list all applicants
/// - modify or delete applications
/// - submit the application to PICA, thereby creating a user account 
/// - print a paper form that can be signed by the applicant
///
/// This is the entry page (index page) for this web frontend. 
/// It extracts  all applicants' records from the database and 
/// displays them in a list. 
///
/// \param sort   primary key by which the list is sorted
/// \param order  'ascending' or 'descending' 
/// \param status 'new' if we should display those records that have
///		  not yet been submitted to PICA, 'old' otherwise.
/// \param button whether the user has pressed a submit button (and which one)
///
/// Users may follow a hyperlink that points to action.php and produces 
/// a detailed view for that record. 

require_once('config.php');
require_once('../util.php');
require_once('../text.php');
require_once('../fields.php');

session_start();

// select language

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : $lang_default;

if (!isset($text_multi[$lang]))
	$l = $lang_default;

$text    = $text_multi[$lang];
$buttons = $buttons_multi[$lang];
$months =  $months_multi[$lang];


/// \brief valid choices for parameters
///
/// This associative array is used as first parameter for the param_ok()
/// function, and is used for validating user input that is delivered to 
/// the script via GET or POST request. 

$valid_params = array(
	"sort" => "/^(last_name|first_name|birthday|sex|entry_date)$/",
	"order"=> "/^(up|down)$/",
	"status" => "/^(new|old)$/",
	"button" => "/^(" . $buttons['delete_all'] . "|" .  $buttons['ok'] . "|" .
			    $buttons['cancel'] . "|)$/",
	"action"=> "/^(delete_all|)$/",
	"lang" => "/^(de|en)$/",
	"key" => "/^[A-Z]?$/"
);

/// \brief initialization values for parameters

$default_params = array (
	'sort' => "last_name",
	'order' => "up",
	'status' => "new",
	'lang' => $lang_default
);

foreach ($default_params as  $k => $v) {
	if (!isset($_SESSION[$k]))
		$_SESSION[$k] = $v;
}

foreach ($_GET as  $k => $v) {
	if (param_ok($valid_params, $k, $v)) 
		$_SESSION[$k] = $v;
}


// \brief default sort order

$default_sortkeys = array( 'last_name', 'first_name', 'birthday');

// \brief which columns are to appear in the index

$sort = $_SESSION['sort'];

print_header( array("@notabene@" => "", "@bodyattr@" => "",
	      "@url-de@" => "?lang=de", "@url-en@" => "?lang=en" ));

print 	'<table border=0>
	 <tr> 
	 <td><strong>' . $text['status'] . ': </strong></td>
	 <td>';

  $url = "?lang=$lang&sort=$sort&order=" . $_SESSION['order'];
  $url .= "&key=". $_SESSION['key'];

  link_maybe($text['status_new'], $url . "&status=new",
	     $_SESSION["status"] != "new") ;
  print " / ";
  link_maybe($text['status_old'], $url . "&status=old",
	     $_SESSION["status"] != "old");

print   '</td></tr> 
	 <tr> 
		<td> <strong>' . $text['order'] . ': </strong> </td>
	 <td>';

  $url = "?lang=$lang&sort=$sort&status=" . $_SESSION['status'];
  $url .= "&key=". $_SESSION['key'];


link_maybe($text['order_asc'], $url . "&order=up",
	   $_SESSION["order"] != "up");
print " / ";
link_maybe($text['order_desc'],$url . "&order=down", 
	   $_SESSION["order"] != "down");

print 	' </td> </tr> </table> <br>';

$url= "?lang=$lang&order=" . $_SESSION["order"] . 
      "&sort=$sort&status=" . $_SESSION["status"];

print 	'<h2><p align="center" > <table border=0 ><tr>&nbsp;[&nbsp;';
for ($ch = 'A' ; ($ch < 'Z') ; $ch++ ) {
	print '&nbsp;';
	link_maybe($ch, $url . "&key=$ch", $_SESSION['key'] != $ch); 
	print '&nbsp;|';
}

print '&nbsp;';
link_maybe('Z', $url . "&key=Z", $_SESSION['key'] != 'Z'); 
print '&nbsp;|';

print '&nbsp;';
link_maybe('*', $url . "&key=", $_SESSION['key'] != ""); 

print 	'&nbsp;]&nbsp;</tr></td></table><p></h2>';

($link = mysql_pconnect($dbhost, $dbuser, $dbpass)) or db_error_mysql();
mysql_select_db($dbname,$link) or db_error_mysql();

fields_init($link, $lang);


$table_columns = array(
		  'last_name' =>  $fields['last_name']['label'],
		  'first_name' => $fields['first_name']['label'],
		  'birthday' =>   $fields['birthday']['label'],
		  'entry_date' => $fields['entry_date']['label']
	);

// delete obsolete data sets

if (($_SESSION['action'] == 'delete_all') and $_SESSION['button'] == $buttons['ok']) {

	$q  =   "DELETE addresses FROM persons, addresses ";
	$q  .=  "WHERE persons.status='old' and persons.id = addresses.person_id";
	db_query_mysql($link,$q, array()); 

	$q  =   "DELETE FROM persons WHERE persons.status='old'";
	db_query_mysql($link, $q, array()); 

	$_SESSION["button"] = "";

	unset($_SESSION['action']);
}
// query db


$sortkeys = $_SESSION["sort"];

if ($_SESSION["order"] == "down") 
	$sortkeys .= " DESC";

foreach ($default_sortkeys as $s) {
	if ($s != $_SESSION["sort"])
		$sortkeys .= ", $s" ;
}

$key_query = array(
	"A" => 'last_name like "ä%" or last_name like "a%" ' ,
	"B" => 'last_name like "b%"',
	"C" => 'last_name like "c%"',
	"D" => 'last_name like "d%"',
	"E" => 'last_name like "e%"',
	"F" => 'last_name like "f%"',
	"G" => 'last_name like "g%"',
	"H" => 'last_name like "h%"',
	"I" => 'last_name like "i%"',
	"J" => 'last_name like "j%"',
	"K" => 'last_name like "k%"',
	"L" => 'last_name like "l%"',
	"M" => 'last_name like "m%"',
	"N" => 'last_name like "n%"',
	"O" => 'last_name like "ö%" or last_name like "o%" ' ,
	"P" => 'last_name like "p%"',
	"Q" => 'last_name like "q%"',
	"R" => 'last_name like "r%"',
	"S" => 'last_name like "s%"',
	"T" => 'last_name like "t%"',
	"U" => 'last_name like "ü%" or last_name like "u%" ' ,
	"V" => 'last_name like "v%"',
	"W" => 'last_name like "w%"',
	"X" => 'last_name like "x%"',
	"Y" => 'last_name like "y%"',
	"Z" => 'last_name like "z%"',
	); 

$k = $_SESSION['key'];

$q  =  "SELECT id FROM persons WHERE status = ";
$q .= "'" . $_SESSION["status"] . "' ";

if (!empty($key_query[$k])) { 
	$q = $q . ' AND ( ' . $key_query[$k] . ' ) ';
}

$q .= "ORDER BY $sortkeys";


// print $q;

$res = db_query_mysql($link,$q, array()); 


if (empty($res)) {
	print $text['db_empty']; 
} else {
	print "<table border=0 cellpadding=5 >";

	$url= "?lang=$lang&status=$status&order=$order&key=" . $_SESSION['key'];

	// table header
	print "<tr>\n";
	foreach ($table_columns as $k => $v ) {
		$order=$_SESSION['order'];
		print "<th align=\"left\" >";
		link_maybe(htmlentities($v), $url . "&sort=$k", 
			   $_SESSION["sort"] != $k); 
		print "</th>\n";
	}
	print "<th> &nbsp; </th>";

	print "</tr>\n";

	// table body
	foreach ($res as $row) {
		print "<tr>\n";

		foreach ($table_columns as $f => $dummy ) {

			// query database

			$q = $fields[$f]["view_query"];
			// print $q;

			$r = db_query_mysql($link,$q,
				array('@id@' => $row["id"]));

			$v = (isset($r[1][0])) ? $r[1][0] : "";

			print "<td>" . htmlentities($v) . "&nbsp; </td>\n";

		}

		print "<td>";

		$id = $row["id"];
		print "<a href=\"action.php?&lang=$lang&action=show&id=" . $id . "\">";
	        print $text['details'];
		print "</td>\n";
		print "</tr>\n";
	}
	print "</table>";

if ($_SESSION["status"] == "old")  {
	print '<form method="GET">';


	if ($_SESSION['button'] == $buttons['delete_all']) {
		print '<br><strong>' . $text['confirm_delete_all'] . '</strong>&nbsp;&nbsp;';
		print '<input type="hidden" value="' . $lang . '" name="lang">';
		print '<input type="hidden" value="delete_all" name="action">';
		print '<input type="submit" name="button" value="' . $buttons['ok'] . '">&nbsp;'; 
		print '<input type="submit" name="button" value="' . $buttons['cancel'] . '">'; 
	} else {
		print '<input type="hidden" value="' . $lang . '" name="lang">';
		
		if ($_SESSION['key'] == '') {
		print '<br><br><input type="submit" name="button" value="' . 
		       $buttons['delete_all'] . '">';
		}
	}

	print "</form>";
}

}

mysql_close($link);
print_footer(array());

?>
