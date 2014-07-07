<?php

//
// Texte deutsch / englisch
//

// This file is part of the web-based "Application Form for New Users" 
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \file 
///
/// \brief assorted text fragments
/// 
/// This file contains a library of text fragments to be printed
/// in the various web forms presented to the user. They are 
/// site specific and should be modified as necessary.

/// \brief HTML text fragments
/// 
/// This array contains various HTML text fragments, e.g. the header 
/// and footer of the web pages.  These texts can (and should) be 
/// modified according to your own needs.

$text_multi = array();

$text_multi['de'] = array(

	'html_header' => '
		<html><head>
		<link type="text/css" rel="stylesheet" href="style/anmeldung.css">
		<!-- ***** FAQ POP-UP ***** -->	
		<script LANGUAGE="JavaScript">
function help() {
fenster = window.open("http://www.biblio.tu-bs.de/anmeldung2/help.php","PopUp","width=640,height=320,menubar=no,toolbar=no,scrollbars=yes,status=no,resizable=yes,location=no,hotkeys=no")
}
</script>
<!-- ********************** -->
		<title>Anmeldung zur Benutzung der Universit�tsbibliothek</title>
		</head>
		<body @bodyattr@ >

		<div style="background-color:#DBDBDB;"><a href="http://www.biblio.tu-bs.de"><img src="http://www.biblio.tu-bs.de/anmeldung2/img/logo.gif" alt="[Ansicht UB Braunschweig]" border="0"></img></a></div>
		<div><img src="http://www.biblio.tu-bs.de/anmeldung2/img/schmucklinie.gif" width="100%" height="10px" border="0"></img></div>

		<!-- ***** weitere Sprachen *****
		<img src="lang-de-sel.png" alt="deutsch" border=0>&nbsp;<a href="@url-en@"><img src="lang-en.png" alt="english" border=0></a>
		********************************* -->

<div style="background-color:#999999; height:22px; padding: 2px 0 0 0; color:#FFFFFF; font-weight:bold; font-size:14px; text-align:center;">Anmeldung zur Benutzung der Universit&auml;tsbibliothek</div>

<table width="100%"  border="0" cellpadding="0" cellspacing="0">		
 		
<tr>
<!-- *********** FAQ *********** -->		
<td style="align: left; vertical-align: bottom; width:35px; height:35px;"><a href="JavaScript:help()"><img src="http://www.biblio.tu-bs.de/anmeldung2/img/help.gif" alt="Hilfe" title="Online-Anmeldung FAQ" border=0 height=30px width=30px></a></td>
<!-- *************************** -->

<td style="align: left; vertical-align: top;">
<b><font color="#336699"> <p> Geb�hr f�r Benutzerausweis: 5 EUR</font></b>
</td>
	        <td align="right"> <h2>@notabene@</h2> </td>
		</tr>
		</table>
		<hr>
		',
// NEU Okt.2008
//	'user_info' => ' <strong> <p> Geb�hr f�r Benutzerausweis: 5 EUR</strong>   <br></p>',
		
	'step1' => 'Schritt ',
	'step2' => ' von 4',	
	
	
	
	'html_footer' => '<hr> 
			 <p align="right">
			 <a href="doc/">&Uuml;ber diese Software...</a>
			 </body></html>',
			 
// +++++++++++++++++++++++++++++++++++++++++++++++++++EMAIL BENACHRICHTIGUNG+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

// ************************************************ V2.0 Formulartext mit Checkbox ***********************************************************

//Checkboxtext

 'disclaimer' => 
 ' <p><b>*</b>
Ich bitte um elektronische Benachrichtigung durch die Universit&auml;tsbibliothek an meine oben aufgef&uuml;hrte E-Mail-Adresse und erkl&auml;re mein Einverst&auml;ndnis mit der unverschl&uuml;sselten &Uuml;bertragung der Daten. Ich erkl&auml;re mich ausdr&uuml;cklich damit einverstanden, dass elektronische Benachrichtigungen (einschlie&szlig;lich Mahnungen) an die letzte der Universit&auml;tsbibliothek gemeldete Adresse dem Inhalt nach als bekannt gelten und ich selbst f&uuml;r den Abruf dieser Benachrichtigungen und f&uuml;r die unverz&uuml;gliche Meldung von Adress-&Auml;nderungen an die Unversit&auml;tsbibliothek verantwortlich bin.</p>',

// Zusammenfassungstext
'disclaimer_info' =>
	'<p><h2>Benachrichtigung per E-Mail</h2>
	Ich bitte um elektronische Benachrichtigung durch die Universit&auml;tsbibliothek an meine oben aufgef&uuml;hrte E-Mail-Adresse und erkl&auml;re mein Einverst&auml;ndnis mit der unverschl&uuml;sselten &Uuml;bertragung der Daten. Ich erkl&auml;re mich ausdr&uuml;cklich damit einverstanden, dass elektronische Benachrichtigungen (einschlie&szlig;lich Mahnungen) an die letzte der Universit&auml;tsbibliothek gemeldete Adresse dem Inhalt nach als bekannt gelten und ich selbst f&uuml;r den Abruf dieser Benachrichtigungen und f&uuml;r die unverz&uuml;gliche Meldung von Adress-&Auml;nderungen an die Unversit&auml;tsbibliothek verantwortlich bin.</p>',

// ********************************************************************************************************************************************

	'info_1' => '
		<p><h2>Wichtiger Hinweis</h2>
		Die Angabe Ihrer Daten ist freiwillig. Ohne Ihre Daten ist eine
		Ausleihe jedoch nicht m&ouml;glich. Die Erhebung der
		Daten erfolgt lediglich zum Zweck der automatisierten 
		Ausleihverbuchung, der Online-Fernleihe bzw. der 
		Internet-Nutzung in den R�umen der Universit&auml;tsbibliothek sowie,
		falls beantragt, zum Zwecke der Benachrichtigung und Mahnung per E-Mail. 
		Die Daten werden nicht an Dritte weitergegeben.<p>
		Grundlagen f&uuml;r diese Datenerhebung sind:
		<ul>
	        <li> Nieders. Datenschutzgesetz (NDSG) vom 17. 6. 1993 (Nieders.
		     GVBl. Nr 19/1993),</li>
	        <li> Runderlass des Nieders. Ministeriums f&uuml;r 
		     Wissenschaft und Kultur vom 25. 8. 1992 
		     (Nieders. Ministerialblatt Nr. 36/1992).</li>
		</ul>
		<h2>Erkl&auml;rung</h2>
		    Die <a target="_ordn" 
		    href="/benutzung/benutzord.html">Benutzungsordnung f&uuml;r 
		    die Universit&auml;tsbibliothek Braunschweig</a> 
		    erkenne ich als f&uuml;r mich verbindlich an. 
		    Im &uuml;brigen gilt die 
		    <a target="_ordn" 
		    href="/benutzung/gebuehren.html">Geb&uuml;hrenordnung</a>.<p>
		Mit der Speicherung meiner personenbezogenen Daten
		  <ol>
		    <li> in der Universit&auml;tsbibliothek im Rahmen 
			 der Benutzung</li>
		    <li> in der Verbundzentrale des Gemeinsamen 
			 Bibliotheksverbundes (GBV) in G&ouml;ttingen 
			 im Rahmen der Online-Fernleihe </li>
		  </ol>
		bin ich einverstanden.  Der Benutzungsausweis bleibt 
		Eigentum der Bibliothek und wird bei Abmeldung 
		zur&uuml;ckgegeben.<p>',

	'info_2' => '
		<h2>Ihre Anmeldung wurde registriert</h2>
		Der Bibliotheksausweis kann von Ihnen 
		<strong>pers&ouml;nlich</strong>
		in der Leihstelle der UB abgeholt werden. 
		Legen Sie dabei bitte vor:
		<p>
		<ul>
		<li> einen g&uuml;ltigen Personalausweis <strong>oder</strong>
		<li> einen g&uuml;ltigen 
		Reisepass</strong> und eine amtliche Meldebescheinigung 
		<li> Studierende: zus&auml;tzlich den 
		     g&uuml;ltigen Studierendenausweis
		<li> Mitarbeiterinnen und Mitarbeiter der TU:
		     zus&auml;tzlich eine Dienstbescheinigung
		<li> Ab dem 1. Januar 2005 wird f�r die Ausstellung
		des Benutzerausweises eine einmalige Geb�hr
		in H�he von 5 EUR berechnet.
		</ul> <p> 

		<p>

		Der Benutzungsausweis ist in der Regel ein Jahr g&uuml;ltig
		und kann unter Vorlage der oben genannten Unterlagen
		in der Leihstelle <strong>pers&ouml;nlich</strong> verl&auml;ngert
		werden.
		<p>
		<a href="http://sunny.biblio.etc.tu-bs.de:8080/DB=1/LNG=DU/">
		Zum Online-Katalog der UB</a> 
		',

	"sign_here" => '<br><br><table border="0" width="100%" >
			<tr>
			    <td><strong>Braunschweig, den @today@</strong></td>
		     	    <td> &nbsp; </td>
			</tr> 
			<tr> 
			    <td> &nbsp; </td> 
			    <td> <hr>   </td> 
			</tr>
			<tr>
			    <td> &nbsp; </td>
			    <td width="50%" align="center"> (Unterschrift) 
			    </td>
			</tr>
			</table>',

	"confirm_submit" => 
	'<br><strong>Benutzer trotzdem in PICA &uuml;bernehmen?&nbsp;</strong>',

	"confirm_delete" => 
	    '<br><strong>Diesen Datensatz wirklich l&ouml;schen?&nbsp;</strong>',

	"confirm_delete_all" => 
	    '<br><strong>Tats&auml;chlich <em>alle</em> bearbeiteten Datens&auml;tze l&ouml;schen?&nbsp;</strong>',

	// error messages

	"user_account_conflict" =>' 
		<h1>Benutzer ist m&ouml;glicherweise bereits angemeldet!</h1>
	 	Dieser Benutzer ist  m&ouml;glicherweise bereits angemeldet.
		Es wurde eine &Auml;hnlichkeit mit folgenden 
		PICA-Datens&auml;tzen festgestellt:',
	
	"generic_error" => '
		<h1> Es ist ein Fehler aufgetreten! </h1>
		Die Anmeldung ist fehlgeschlagen. 
		Bitte versuchen Sie es noch einmal. Falls der Fehler 
		erneut auftritt, wenden Sie sich bitte an die Leihstelle.
		<br><br>
		Die Fehlermeldung lautet: <p>
		<pre>@msg@</pre> <p>
		<a href="index.php?lang=de">Weiter ...</a> ',

	"error" => "<img src=\"err.png\" alt=\"[X]\"> &nbsp;", 

	"error_msg" => ' <strong>Fehlende oder ung&uuml;ltige Eingabe!</strong>
		Bitte die markierten Felder korrigieren!<br><br>',

	"db_empty" => "<strong>Keine Eintr&auml;ge in der Datenbank!</strong>",

	"conflict_regno" => 
    	'<h1>Fehler!</h1>
	Die &Uuml;berpr&uuml;fung der Registriernummer "@regno@" ist gescheitert! <p>
	Entweder ist die Registriernummer bereits in der PICA-Datenbank 
	vorhanden, oder es ist ein Fehler beim Datenbankzugriff aufgetreten.<p> 
    	M&ouml;gliche Ursachen:
    	<ul>
    	<li> Falsche Matrikelnummer in der Online-Anmeldung
    	<li> Falsche Registriernummer im PICA-Datensatz
    	<li> Fehler im Programm
    	<li> Probleme mit der PICA-Datenbank
    	</ul>
    	Der Vorgang wurde abgebrochen. Bitte beseitigen Sie
    	die Fehlerursache, und versuchen Sie es danach erneut.
	Falls der Fehler sich nicht beseitigen l&auml;&szlig;t, 
	verst&auml;ndigen Sie bitte die EDV-Abteilung.<p>
	<a href="index.php?lang=de">Weiter ...</a>
	',

	"redirect" => '
	<h1>Sie werden umgeleitet!</h1>

	Sie werden automatisch auf eine neue Webseite umgeleitet.
	Sollte die Umleitung nicht funktionieren, klicken Sie bitte
	<a href="@url@">hier</a>.',

	'sex_m'         => "m�nnlich",
	'sex_w'         => "weiblich",

	'status'	=> "Status",
	'status_new'	=> "neu",
	'status_old'	=> "bearbeitet",
	
	'order'		=> "Sortierung",
	'order_asc'	=> "aufsteigend",
	'order_desc'	=> "absteigend",

	'details'	=> "Details ...",
	'mahnaddr'	=> "Mahnaddresse" ,
	'i_am'		=> "Ich bin..." ,
	'barcode'	=> "Barcode",
	'institute'	=> "Institut",
//	'email' => "E-Mailadresse*",
);

//***************************REMOVE ENGLISH**********************************
/*
$text_multi['en'] = array(
	'html_header' => '
		<html><head>
		<link type="text/css" rel="stylesheet" href="anmeldung.css">
		<title>Braunschweig University Library - Reader Registration</title>
		</head>
		<body @bodyattr@ >

		<table border="0" width="100%">
		<tr valign="bottom" >
		<td align="left">	
		<img src="http://www.biblio.tu-bs.de/images/ubdraw2.gif">
		</td><td align="right">	
		<a href="@url-de@"><img border=0 src="lang-de.png" alt="deutsch"></a>&nbsp;<img src="lang-en-sel.png" border=0 alt="english">
		</td>
 		</tr>
		<tr valign="bottom" >
		<td> <h2>Braunschweig University Library - Reader Registration</h2> </td>
	        <td align="right"> <h2>@notabene@</h2> </td>
		</tr>
		</table>
		<hr>
		',

	'user_info' => ' <strong> <p> Library Card Fee: EUR 5</strong> </p> <br>',
	'html_footer' => '<hr> 
			 <p align="right">
			 <a href="doc/">About this software ...</a>
			 </body></html>',

	'info_1' => '
		<p><h2>Important notice</h2>
		You are not required to provide your personal data.
		Without your data, however, use of the library cannot be 
		permitted. Your data are needed for book loan, 
		online interlibrary loan, and for internet access at 
		the terminals in the library. Your data will not be 
		shared or given away to a third party.<p>

		Data processing is on the basis of:
		<ul>
	        <li> "Nieders&auml;chsisches Datenschutzgesetz" 
		     (Data Protection Law of the State of Lower Saxony), 
		     17/06/93 (Nieders. GVBl. Nr 19/1993),</li>
	        <li> Order of the Department of Science and 
		     Cultural Affairs of the State of 
		     Lower Saxony, 25/08/92 
		     (Nieders. Ministerialblatt Nr. 36/1992).</li> </li>
		</ul>
		<h2>Statement of Acceptance</h2>
		    I accept the Conditions of Use 
		    (<a target="_ordn" href="/benutzord.html">Benutzungsordnung</a>) 
		    of Braunschweig University Library.
		    Use of the library is based on the 
		    official list of fees 
		    (<a target="_ordn" href="/gebuehren.htm">Geb&uuml;hrenordnung</a>). <p>
 
		    I agree to the processing and storage of my personal data
		  <ol>
		    <li> at the University Library for reader
			 service purposes </li>
		    <li> at the library consortium centre 
			 of Northern Germany (GBV), G&ouml;ttingen, 
			for interlibrary loan services. </li>
		  </ol>

		  Your reader identification card remains property of 
		  the library; you must return it when you resign 
 		  from your registration. <p>

		',

	'info_2' => '
		<h2>Your registration has been successful</h2>

		You can collect your reader identification card at 
		the library in person at the library loan desk. 
		Please bring with you:
		<p>
		<ul>
		<li> a valid passport, and an official certificate
		     of residence ("Meldebescheinigung")
		<li> students: additionally a valid student ID
		<li> TU staff members: additionally a valid
		     staff member certificate ("Dienstbescheinigung") 
		<li>  Starting from January 1st, 2005, 
		  a <b>one-time fee (EUR 5)</b> must be 
		  paid when you collect your library card.
		</ul> <p> 

		Your reader identification card is valid for one
		year. To renew it, please apply at the loan desk 
		<strong>in person</strong> and bring with you 
		the relevant pieces of identification as mentioned above.
		<p>
		<a href="http://sunny.biblio.etc.tu-bs.de:8080/DB=1/LNG=EN/">
		Catalogue of Braunschweig University Library</a> 
		',

	"sign_here" => '<br><br><table border="0" width="100%" >
			<tr>
			    <td><strong>Braunschweig, @today@</strong></td>
		     	    <td> &nbsp; </td>
			</tr> 
			<tr> 
			    <td> &nbsp; </td> 
			    <td> <hr>   </td> 
			</tr>
			<tr>
			    <td> &nbsp; </td>
			    <td width="50%" align="center"> (Signature) 
			    </td>
			</tr>
			</table>',

	"confirm_submit" => 
	'<br><strong>Submit to PICA anyway?&nbsp;</strong>',

	"confirm_delete" => 
	    '<br><strong>Delete this record?&nbsp;</strong>',

	"confirm_delete_all" => 
	    '<br><strong>Delete <em>all</em> old records?&nbsp;</strong>',

	// error messages

	"user_account_conflict" =>' 
		<h1>Possible user account conflict!</h1>
	 	There are similar users in the PICA database! ',
	
	"generic_error" => '
		<h1>An error has occurred!</h1>
		Your registration was unsuccessful. Please try again.
		If the error occurs again, please contact the loan desk.
		<br><br>
		Error message: <p>
		<pre>@msg@</pre> <p>
		<a href="index.php?lang=en">Continue ...</a>
		',

	"error" => "<img src=\"err.png\" alt=\"[X]\"> &nbsp;", 

	"error_msg" => ' <strong>Invalid entry!</strong>
		Please correct the fields marked with a cross!<br><br>',

	"db_empty" => "<strong>No records in database!</strong>",

	"conflict_regno" => '<h1>A registration number conflict has occurred!</h1>

	The registration number "@regno@" is invalid! Possible causes include:
    	<ul>
    	<li> A wrong Student ID in the application 
    	<li> A wrong registration number in a PICA record 
    	<li> A programming error
    	<li> Problems contacting the PICA database
    	</ul>
	The registration has been cancelled. Please remove the
	cause of the error and try again. Contact the IT 
	department if the error persists.<p>
	<a href="index.php?lang=en">Continue ...</a>
	',

	"redirect" => '
	<h1>You are being redirected!</h1>

	You are being redirected to another web address.
	If the automatic redirection does not work, please 
	click <a href="@url@">here</a> instead.',

	'sex_m'         => "male",
	'sex_w'         => "female",

	'status'	=> "Status",
	'status_new'	=> "new",
	'status_old'	=> "old",
	
	'order'		=> "Order",
	'order_asc'	=> "ascending",
	'order_desc'	=> "descending",
	
	'details'	=> "Details ...",

	'mahnaddr'	=> "&nbsp;", 
	'i_am'		=> "I am ..." ,
	'barcode'	=> "Barcode",
	'institute'	=> "Institute"
);

/// \brief Button labels
/// 
/// This array contains the text labels for buttons in HTML forms.
/// They can be modified according to your own needs.

$buttons_multi = array();
*/
//***************************REMOVE ENGLISH**********************************
$buttons_multi['de'] = array(
	"ok"          => "OK",
	"cancel"      => "Abbrechen",
	"next"	      => "Weiter",
	"prev"	      => "Zur�ck",
	"finish"      => "Anmeldung absenden",
	"print"       => "Ausdrucken",
	"delete"      => "L�schen",
	"delete_all"  => "Alle Datens�tze l�schen",
	"goto_index"  => "Zur�ck zur �bersicht",
	"submit"      => "Nach PICA �bernehmen",
	"edit"        => "Korrigieren"
);
//***************************REMOVE ENGLISH**********************************
/*
$buttons_multi['en'] = array(
	"ok"          => "OK",
	"cancel"      => "Cancel",
	"next"	      => "Continue",
	"prev"	      => "Back",
	"finish"      => "I agree",
	"print"       => "Print",
	"delete"      => "Delete",
	"delete_all"  => "Delete All Records",
	"goto_index"  => "Go To Index",
	"submit"      => "Send to PICA",
	"edit"        => "Edit"
);
*/
//***************************REMOVE ENGLISH**********************************
/// \brief Month names
/// 
/// This array contains month names.

$months_multi = array();

$months_multi['de'] = array ( "01" => "Jan", "02" => "Feb", "03" => "M�r",
				 "04" => "Apr", "05" => "Mai", "06" => "Jun",
				 "07" => "Jul", "08" => "Aug", "09" => "Sep", 
				 "10" => "Okt", "11" => "Nov", "12" => "Dez" ); 
//***************************REMOVE ENGLISH**********************************
/*
$months_multi['en'] = array ( "01" => "Jan", "02" => "Feb", "03" => "Mar",
				 "04" => "Apr", "05" => "May", "06" => "Jun",
				 "07" => "Jul", "08" => "Aug", "09" => "Sep", 
				 "10" => "Oct", "11" => "Nov", "12" => "Dec" ); 
*/
//***************************REMOVE ENGLISH**********************************
/// \brief Form labels
/// 
/// This array contains the text labels for input forms. 
/// They can be modified according to your own needs.


// FELDBEZEICHNER
$field_labels = array();

$field_labels['de'] = array(
	'last_name'     =>  "Nachname",
	'first_name'    => "Vorname",
	'title'         => "Akad. Titel",
	'sex'           => "Geschlecht",
	'birthday'      => "Geburtsdatum",
	'usertype'      => "Nutzertyp",
	'student_id'    => "Matrikelnummer",
	'email_checkbox' => "Benachrichtigung per E-Mail<br />Falls gew&uuml;nscht, nebenstehend Haken setzen. N�heres siehe unten!*",
	'email'	=> "E-Mail-Adresse",
	'email_confirm' => "E-Mail-Adresse (Wdh.)",
	'carry_over_1'  => "c/o",
	'street_1'      => "Str.",
//  TESTANZEIGE PICA USER GROUP --- NICHT F�R PRODUKTIVBETRIEB !!!!!!!!!!!!!!	
//	'pica_user_group' => "TEST: Pica User Group",
//  TESTANZEIGE PICA USER GROUP --- NICHT F�R PRODUKTIVBETRIEB !!!!!!!!!!!!!!
	"house_1"       => "Nr.",
	"room_1"        => "Zimmer",
	"zip_1"  	=> "PLZ",
	"town_1"  	=> "Ort",
	"phone_1"  	=> "Telefon",
	"mobile_1"  	=> "Mobil",
	'carry_over_2'  => "c/o",
	'street_2'      => "Str.",
	"house_2"       => "Nr.",
	"room_2"        => "Zimmer",
	"zip_2"  	=> "PLZ",
	"town_2"  	=> "Ort",
	"phone_2"  	=> "Telefon",
	"mobile_2"  	=> "Mobil",
	"nametag"  	=> "Namensk&uuml;rzel",
	"notabene"  	=> "Seriennummer",
	"expiry_date"  	=> "Ablaufdatum",
	"entry_date"  	=> "Eingabedatum",
	"password"	=> "Passwort"
);

//***************************REMOVE ENGLISH**********************************
/*
$field_labels['en'] = array (
	'last_name'     => "Last Name",
	'first_name'    => "First Name",
	'title'         => "Academic Title",
	'sex'           => "Sex",
	'birthday'      => "Date of Birth",
	'usertype'      => "User Type",
	'student_id'    => "Student ID ('Matrikelnummer')",
	'email'	=> "E-Mail Address",
	'carry_over_1'  => "c/o",
	'street_1'      => "Str.",
	"house_1"       => "No.",
	"room_1"        => "Room",
	"zip_1"  	=> "ZIP",
	"town_1"  	=> "City",
	"phone_1"  	=> "Phone",
	"mobile_1"  	=> "Mobile",
	'carry_over_2'  => "c/o",
	'street_2'      => "Str.",
	"house_2"       => "No.",
	"room_2"        => "Room",
	"zip_2"  	=> "ZIP",
	"town_2"  	=> "City",
	"phone_2"  	=> "Phone",
	"mobile_2"  	=> "Mobile",
	"nametag"  	=> "Name Tag",
	"notabene"  	=> "Serial No.",
	"expiry_date"  	=> "Expires",
	"entry_date"  	=> "Date of Entry",
	"password"	=> "Password"
);
*/
//***************************REMOVE ENGLISH**********************************
?>
