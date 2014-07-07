<?php

// This file is part of the web-based "Application Form for New Users" 
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \file 
///
/// \brief Utility functions

require_once('fields.php');
require_once('text.php');

/// \brief perform a database query 
/// 
/// \param $link open handle to the database
/// \param $q the SQL query
/// \param $kw text substitutions to be performed on $q
///
/// Before the query is performed, the associative array $kw[] is
/// consulted, and each occurence of $key in the query is substituted 
/// by $kw[$key]. Proper quotation is applied to the substitution text
/// so that it is safe to have special characters (e.g. hyphens) in it.
///
/// \returns an array where each element is a sub-array representing
/// a row of the query result. Each sub-array has the format 
/// delivered by mysql_fetch_array().
///
/// \note All queries to the MySQL database are done through this function.

function db_query_mysql($link, $q, $kw) {

	foreach ($kw as $k => $v) {
		$kw[$k] = mysql_escape_string($v);
	}

	$q = strtr($q, $kw);

	// print "query: " . $q . "<br>";

	($r = @ mysql_query($q, $link)) or db_error_mysql();
	
	$result = array(); $i = 1;
		
	if (@ mysql_num_rows($r) > 0)  {
		while ($row = @ mysql_fetch_array($r))  {
			$result[$i++] = $row;		
		}
	}

	return $result;
}
/// \brief conditionally print text as a HTML hyperlink 
///
/// \param $text, $url, $condition see below
///
/// This function prints a given $text. If $condition is true, 
/// $text is made into a hyperlink pointing to $url.
/// \returns nothing


function link_maybe($text, $url, $condition) {
	if ($condition) 
		print "<a href=\"$url\">$text</a>";
	else
		print "<strong>$text</strong>";
}

/// \brief redirect the user to a different URL
///
/// \param $url target url
///
/// This function redirects the browser to a different URL.
/// \returns nothing

function redirect($url) {
	global $text;

	$kw = array ('@bodyattr@' => "",
		     '@notabene@' => "", 
		     '@url@' => "$url",
		     '@url-de@' => "$url",
		     '@url-en@' => "$url");

	header("Location: " . $url);
	
	// for older browsers that don't support redirect

	print_header($kw);
	print strtr($text['redirect'], $kw);
	print_footer($kw);
	exit(0);
}


/// \brief check a parameter
///
/// This function is used to determine whether input to a script
/// (received via GET or POST request) should be accepted by the 
/// script. 
///
/// For example, to check whether $_GET['foo'] contains valid data
/// you would test if param_ok($allowed, 'foo', $_GET['foo']) yields TRUE.
///
/// \param $allowed is an associative array containing 
///	   regular expressions against which the input is matched 
/// \param $k is a key into the $allowed[] array
/// \param $v is the input value to be checked
///
/// \returns TRUE if the value should be accepted, FALSE otherwise.

function param_ok($allowed, $k, $v) {

	$ok = TRUE;

	if (!isset($allowed[$k]))
		$ok = FALSE;
	else if (!preg_match($allowed[$k], $v))
		$ok = FALSE;

	return $ok;

}

/// \brief print a HTML table from a template
///
/// This function prints a HTML table from a template.
/// See $table1 ... $table4 in action.php for examples of 
/// such templates. 
///
/// \param $table the template
/// \param $dblink an open handle to the MySQL database
/// \param $cols the desired number of columns in the table
/// \param $attr the attributes of the HTML table (e.g. 'border="0"')
/// \param $subst a substitution table for db_query_mysql()
/// \returns nothing

function print_table($table, $cols, $attr, $dblink, $subst) {
	
	print "<table width=\"100%\" " . $attr . " >\n<tr>\n";

	$c = 1;

	// $col_width1 = (35 / $cols);
	// $col_width2 = (65 / $cols);

	if (empty($table))
		return(TRUE);

	foreach ($table as $row ) {

		// do SQL query


		if (isset ($row["value"])) {

			print "<td width=\"30%\"><strong>" . $row["label"] ;
			print "</strong></td>\n" ;	
			print "<td>" . htmlentities(strtr($row["value"], $subst)) . "</td>";

		} else if (isset ($row["query"])) {
		
			$r = db_query_mysql($dblink, $row["query"] , $subst);

			if (empty($r))  {
				print "<td>&nbsp;</td>\n"; 
				print "<td>&nbsp;</td>\n"; 
			} else {

				print "<td width=\"30%\"><strong>";
				print 	$row["label"] . "</strong></td>\n";

				print "<td>";

				foreach ($r[1] as $k => $v)  {
					if (is_numeric($k)) 
						print htmlentities($v) . "&nbsp;";
				}		
			
				print "&nbsp;</td>\n";
			}
		} else if (isset($row["fields"])) {
			global $fields;

			// print label

			print "<td><strong>" . $row["label"] ;
			print "</strong></td>\n" ;	

			// print html form for user input

			print "<td>";

			foreach ($row["fields"] as $f) {	

				// field key, field value
				$fk = $f;
				$fv = (isset($_SESSION[$fk])) ? 
					$_SESSION[$fk] : "";

				print input_control($f, $fk, $fv ); 
				print "&nbsp;&nbsp;";
			}
			print "</td>\n"; 
	
		} else {
			print "<td>&nbsp;</td>\n"; 
			print "<td>&nbsp;</td>\n"; 
		}

		if ($c < $cols){
			$c++;
		} else {
			print "</tr>\n<tr>\n";
			$c = 1;
		}		
	}

	print "</tr></table>";

}

/// \brief normalize user input
///
/// This function tries to deal with funny characters in user input
/// by replacing them with harmless ones. It also strips blanks that
/// are deemed unnecessary.
///
/// \param $v user input
/// \returns normalized user input

function normalize_input($v) {
	$v = preg_replace("/\\s+/", " ", $v);
	$v = preg_replace("/^ /", "", $v);
	$v = preg_replace("/ $/", "", $v);

	$v = strtr($v, 'ÀÁÂÃÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕØÙÚÛÝàáâãåæçèéêëìíîïñòóôõøùúûýÿ',
		       'AAAAAACEEEEIIIIDNOOOOOUUUYaaaaaaceeeeiiiinooooouuuyy');

	return $v;	
}

function print_header($kw) {
	global $text;

	header("Content-Type: text/html; charset=ISO-8859-1");

	if (!isset ($_SESSION['in_body']))
		print strtr($text['html_header'], $kw);

	$_SESSION['in_body'] = TRUE;
}

function print_footer($kw) {

	global $text;

	if (isset ($_SESSION['in_body']))
		print strtr($text['html_footer'], $kw);

	unset ($_SESSION['in_body']);
}


/// \brief handle MySQL database errors
///
/// determine the cause of error, print an appropriate error message, 
/// and exit

function db_error_mysql() {
	error_msg( "MYSQL: " . mysql_error() . " [" . mysql_errno() . "]" ); 
	exit(0);
}

function error_msg($msg) {
	global $text;

	$kw =  array ( '@bodyattr@' => "",
		 '@notabene@' => "", 
		 '@url-de@' => "index.php?lang=de",
		 '@url-en@' => "index.php?lang=en",
		 '@msg@' => $msg );

	print_header($kw);
	print strtr($text['generic_error'],$kw);
	print_footer($kw);

	exit(0);
}


?>
