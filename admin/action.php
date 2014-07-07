<?php

// This file is part of the web-based "Application Form for New Users" 
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \file
/// \brief perform various actions on a database record
/// 
/// This script is part of the library staff's web frontend.
/// It produces a detailed view of an applicant's personal record,
/// and allows the staff to perform various actions, namely to: 
/// 
/// - change the value of any field in the record
/// - print an application form based on the applicant's record
/// - submit the record to the database of library users (PICA database) 
/// - delete the record if it is deemed bogus 
///
/// \param action which action to perform ("show", "delete", ...)
/// \param id number of record on which to perform the action
/// \param field on which to perform the action (only for action="edit")
/// \param button whether the user pressed a submit button, and which one
/// \param value user input from a HTML form (e.g. while editing a record) 
///
/// Examples of usage:
///
/// <dl>
/// <dt>action.php?id=127&action=show</dt>
/// 	<dd>show record #127</dd>
/// <dt>action.php?id=127&action=edit&field=last_name</dt>
/// 	<dd>edit field 'last_name'</dd>
/// <dt>action.php?id=127&action=submit</dt>
///  	<dd>submit record to PICA</dd>
/// <dt>action.php?id=127&action=print</dt>
///  	<dd>print application form</dd>
/// <dt>action.php?id=127&action=delete</dt> 
///  	<dd>delete record</dd>
/// </dl>

require_once('config.php');
require_once('../util.php');
require_once('../fields.php');
require_once('pica.php');
require_once('../text.php');

session_start();

// select language

$lang = (isset($_REQUEST['lang'])) ? $_REQUEST['lang'] : $lang_default;

if (!isset($text_multi[$lang])) {
    $lang = $lang_default;
}

$text = $text_multi[$lang];
$buttons = $buttons_multi[$lang];
$months = $months_multi[$lang];


// parameters

// a parameter is considered valid if the corresponding 
// regular expression matches

$valid_params = array(
    "action" => "/^(show|edit|delete|submit|submit-check|print)$/",
    "button" => "/^(" . $buttons['ok'] . "|" .
        $buttons['cancel'] . "|" .
        $buttons['goto_index'] . "|" .
        $buttons['submit'] . "|" .
        $buttons['print'] . "|" .
        $buttons['edit'] . "|" .
        $buttons['delete'] . "|)$/",
    "id" => "/^[0-9]*$/",
    "lang" => "/^(de|en|)$/",
    "barcode" => "/^[0-9]*[0-9xX]$/"
);

// default values for the parameters

$default_params = array(
    "action" => "show",
    "id" => "",
    "button" => "",
    "lang" => $lang_default,
    "barcode" => ""
);

// initialize parameters

foreach ($default_params as $k => $v) {
    if (!isset($_SESSION[$k])) {
        $_SESSION[$k] = $v;
    }
}

foreach ($_GET as $k => $v) {

    // print "param: $k -> $v<br>";

    if (param_ok($valid_params, $k, $v)) {
        $_SESSION[$k] = $v;
    }
}

// open database connection

($link = mysql_pconnect($dbhost, $dbuser, $dbpass)) or db_error_mysql();
mysql_select_db($dbname, $link) or db_error_mysql();

fields_init($link, $lang);

// try to determine status of user in db 

$q = "select * from persons where id='@id@'";

$r = db_query_mysql($link, $q, array('@id@' => $_SESSION['id']));

if (empty($r)) {
    redirect("index.php?lang=$lang"); // no db record --> back to index
}

$status = $r[1]["status"];


// display the database record of a person
// parameters: id=NNN 


// handle submit buttons 

$f = $_SESSION["field"];

if ($_SESSION["button"] == $buttons["edit"] and ($status == "new")) {

    $id = $_SESSION['id'];

    // prepare cancelURL and finishURL

    $cancel = "admin/action.php?lang=@lang@&id=$id&action=show";
    $finish = "admin/action.php?lang=@lang@&id=$id&action=edit";

    // clear $_SESSION[]

    foreach ($_SESSION as $k => $v) {
        unset($_SESSION[$k]);
    }

    // re-initialize $_SESSION[]

    $_SESSION['cancelURL'] = $cancel;
    $_SESSION['finishURL'] = $finish;

    foreach ($fields as $k => $v) {

        $q = $v['query'];
        $r = db_query_mysql($link, $q,
            array('@id@' => $id));

        $_SESSION[$k] = (isset($r[1][0])) ? $r[1][0] : "";

// ++++++++++++++++++++++ Datensatzanzeige ++++++++++++++++++++++++++++		
//		 print $k . "->" . $r[1][0] . "<br>";
// ++++++++++++++++++++++ Datensatzanzeige ++++++++++++++++++++++++++++		 
    }

    redirect("../edit.php?lang=$lang");
}

if (($_SESSION["action"] == "edit") and isset($_SESSION['edit_finished'])) {

    // prepare substitution table

    $kw = array();

    foreach ($fields as $k => $v) {
        if (isset($_SESSION[$k])) {
            $kw['@' . $k . '@'] = $_SESSION[$k];
        }
    }

    $kw['@id@'] = $_SESSION['id'];

    // try to store into data base

    // abhaengig von der e-mail-angabe
    if ($_SESSION["email"] != "") {


        // usertype_id um 20 f�r die e-mail-kennzeichnung  erh�hen
        $kw['@' . usertype . '@'] = $_SESSION['usertype'] + 20;


        $q = "UPDATE persons set last_name='@last_name@', " .
            "first_name='@first_name@', title='@title@', sex='@sex@', " .
            "birthday='@birthday@', usertype_id='@usertype@', email_checkbox='@email_checkbox@'," .
            "email='@email@', email_confirm='@email_confirm@'," .
            "student_id='@student_id@' where id=@id@";
        //CE ERG
    } else {
        $kw['@' . email_checkbox . '@'] = 'f';


        $q = "UPDATE persons set last_name='@last_name@', " .
            "first_name='@first_name@', title='@title@', sex='@sex@', " .
            "birthday='@birthday@', usertype_id='@usertype@', email_checkbox='f'," .
            "email=NULL, email_confirm=NULL," .
            "student_id='@student_id@' where id=@id@";
        //CE ERG

    }


    db_query_mysql($link, $q, $kw);

    $q = "UPDATE addresses SET carry_over='@carry_over_1@', " .
        "street='@street_1@', house='@house_1@', room='@room_1@', " .
        "zip='@zip_1@', town='@town_1@', phone='@phone_1@', " .
        "mobile_phone='@mobile_1@' " .
        "WHERE person_id=@id@ AND is_primary='true'";

    db_query_mysql($link, $q, $kw);

    $q = "UPDATE addresses SET carry_over='@carry_over_2@', " .
        "street='@street_2@', house='@house_2@', room='@room_2@', " .
        "zip='@zip_2@', town='@town_2@', phone='@phone_2@', " .
        "mobile_phone='@mobile_2@' WHERE " .
        "person_id=@id@ AND is_primary='false'";

    db_query_mysql($link, $q, $kw);

    $_SESSION["action"] = "show";
    $_SESSION["button"] = "";

    unset($_SESSION["edit_finished"]);

} else {
    if (($_SESSION["action"] == "delete") and
        ($_SESSION["button"] == $buttons['ok'])
    ) {

        // "OK" button was pressed while in "delete" mode
        // -> delete database record

        $q = "delete from persons where id='@id@' ;";
        db_query_mysql($link, $q, array('@id@' => $_SESSION['id']));

        $q = "delete from addresses where person_id='@id@' ; ";
        db_query_mysql($link, $q, array('@id@' => $_SESSION['id']));

        $_SESSION["action"] = "show";
        $_SESSION["button"] = "";
        redirect("index.php?lang=$lang");
    } else {
        if ($_SESSION["button"] == $buttons['goto_index']) {

            // "back to index" button was pressed
            // -> jump back to index

            $_SESSION["action"] = "show";
            $_SESSION["button"] = "";

            redirect("index.php?lang=$lang");
        } else {
            if (($_SESSION["button"] == $buttons['submit']) or
                ($_SESSION['button'] == "" and $_SESSION['barcode'] != "")
            ) {

                $_SESSION["action"] = "submit"; // switch to "submit" mode
            } else {
                if ($_SESSION["button"] == $buttons['delete']) {
                    $_SESSION["action"] = "delete";
                } // switch to "delete" mode

                else {
                    if ($_SESSION["button"] == $buttons['print']) {
                        $_SESSION["action"] = "print";
                    } // switch to "print" mode

                    else {
                        if ($_SESSION["action"] == "submit-check") {


                            if ($_SESSION["button"] == $buttons['ok']) {
                                $_SESSION["force_submit"] = TRUE;
                                $_SESSION["action"] = "submit";
                            } else {
                                $_SESSION["action"] = "show";
                                $_SESSION["force_submit"] = FALSE;
                            }

                        } else {
                            if (isset($_SESSION["button"])) {
                                $_SESSION["action"] = "show";
                            }
                        }
                    }
                }
            }
        }
    }
} // switch to "show" mode

// clear the button state 
$_SESSION["button"] = "";

// If we're about to print an application form, force the print dialog 
// to appear when the page is loaded. 

if ($_SESSION["action"] == "submit") {


    $double_accs = check_for_doubles($link, $_SESSION["id"]);


    if ($status == "old")
        $_SESSION["action"] = "show";
    else if ((empty($double_accs) or $_SESSION["force_submit"])) {

        // submit record into PICA database

        if ($_SESSION["barcode"] == "") {
            $barcode_error = TRUE;
            $_SESSION["action"] = "show";
        } else {

            $barcode = $_SESSION['barcode'];
            unset($_SESSION['barcode']);

            (export_to_pica($link, $_SESSION["id"], $barcode) == 0)
            or error_msg("Error: export_to_pica() failed");

            // mark record as "old"

            $q = "UPDATE persons set status='old' where id='@id@'";
            db_query_mysql($link, $q, array('@id@' => $_SESSION['id']));
            $status = "old";

            // save barcode in database

            $q = $fields['barcode']['update'];
            db_query_mysql($link, $q,
                array('@id@' => $_SESSION['id'],
                    '@val@' => $barcode));
        }

        $_SESSION["force_submit"] = FALSE;

    } else {
        $_SESSION["action"] = "submit-check";
    }
}


/// \brief HTML table templates for use with print_table()
///
/// The variables $table1 ... $table4 are templates for use in conjunction
/// with print_table().
/// 
/// The format of the templates is as follows:
/// Each sub-array describes a row in the table. 
/// The meaning of the elements in each sub-array is:
///
/// <dl>
/// <dt>"label"</dt> 
/// 	<dd>is a human-readable string describing the meaning of the field</dd>
/// <dt>"query"</dt>
///     <dd> is a SQL query which yields the value of the field</dd>
/// </dl>

$table1 = array(
    array("label" => $fields['last_name']["label"],
        "query" => $fields['last_name']["view_query"]
    ),
    array("label" => $fields['first_name']["label"],
        "query" => $fields['first_name']["view_query"]
    ),
    array("label" => $fields['title']["label"],
        "query" => $fields['title']["view_query"]
    ),
    array("label" => $fields['sex']["label"],
        "query" => $fields['sex']["view_query"]
    )
);


$table2 = array(
    array("label" => $fields['birthday']["label"],
        "query" => $fields['birthday']["view_query"]
    ),
    array("label" => $fields['usertype']["label"],
        "query" => "select usertype_names.name " .
            "from persons, usertype_names, usertypes " .
            "where persons.usertype_id = usertypes.id " .
            "and usertype_names.usertype_id = usertypes.id " .
            "and usertype_names.type = persons.sex " .
            "and persons.id='@id@' " .
            "and usertype_names.lang='@lang@'"
    ),

    array("label" => $fields['student_id']["label"],
        "query" => $fields['student_id']["view_query"]
    ),
    array("label" => $fields['barcode']['label'],
        "query" => $fields['barcode']["view_query"]
    )
);


$table3 = array(
    array("label" => $text['mahnaddr'],
        "query" => "select address_types.name  " .
            "from address_types, persons, usertypes  " .
            "where persons.usertype_id = usertypes.id " .
            "and usertypes.primary_address_type = " .
            "address_types.id and persons.id = '@id@' " .
            "and address_types.lang='@lang@'"
    ),
    array("label" => $fields['carry_over_1']['label'],
        "query" => $fields['carry_over_1']["view_query"]
    ),

    array("label" => $fields['street_1']['label'] . " / " .
        $fields['house_1']['label'],
        "query" => "select street, house " .
            "from addresses where person_id = '@id@' " .
            "and is_primary = 'true'"
    ),
    array("label" => $fields['room_1']['label'],
        "query" => $fields['room_1']["view_query"]
    ),
    array("label" => $fields['zip_1']['label'] . " / " .
        $fields['town_1']['label'],
        "query" => "select zip, town   " .
            "from addresses where person_id = '@id@' " .
            "and is_primary = 'true'"
    ),
    array("label" => $fields['phone_1']["label"],
        "query" => $fields['phone_1']["view_query"]
    ),
    array("label" => $fields['mobile_1']["label"],
        "query" => $fields['mobile_1']["view_query"]
    ),
    array("label" => $fields['email']["label"],
        "query" => $fields['email']["view_query"]
    )
//  TESTANZEIGE PICA USER GROUP --- NICHT F�R PRODUKTIVBETRIEB !!!!!!!!!!!!!!	 		 
    /*
    ,
        array(  "label" => $fields['pica_user_group']['label'] ,
            "query"  => "select usertypes.pica_user_group " .
                     "from usertypes, persons " .
                         "where persons.usertype_id = usertypes.id " .
                     "and persons.id = '@id@'")
    */
//  TESTANZEIGE PICA USER GROUP --- NICHT F�R PRODUKTIVBETRIEB !!!!!!!!!!!!!!

);

$table4 = array(
    array("label" => "",
        "query" => "select address_types.name  " .
            "from address_types, persons, usertypes  " .
            "where persons.usertype_id = usertypes.id " .
            "and usertypes.secondary_address_type = " .
            "address_types.id and persons.id = '@id@' " .
            "and address_types.lang='@lang@'"
    ),
    array("label" => $fields['carry_over_2']["label"],
        "query" => $fields['carry_over_2']["view_query"]
    ),

    array("label" => $fields['street_2']['label'] . " / " .
        $fields['house_2']['label'],
        "query" => "select street, house " .
            "from addresses where person_id = '@id@' " .
            "and is_primary = 'false'"
    ),
    array("label" => $fields['room_2']['label'],
        "query" => $fields['room_2']["view_query"]
    ),
    array("label" => $fields['zip_2']['label'] . " / " .
        $fields['town_2']['label'],
        "query" => "select zip, town   " .
            "from addresses where person_id = '@id@' " .
            "and is_primary = 'false'"
    ),
    array("label" => $fields['phone_2']["label"],
        "query" => $fields['phone_2']["view_query"]
    ),
    array("label" => $fields['mobile_2']["label"],
        "query" => $fields['mobile_2']["view_query"]
    )
);


$f = $_SESSION["field"];

// try to retrieve pica id

$q = $fields["notabene"]["view_query"];
$r = db_query_mysql($link, $q, array('@id@' => $_SESSION['id']));

$pica_id = (isset($r[1][0])) ? "[" . $r[1][0] . "]" : "";

$url = "action.php?id=" . $_SESSION['id'] . "&action=show";

$kw = array('@notabene@' => $pica_id, '@bodyattr@' => "",
    '@url-de@' => $url . "&lang=de", '@url-en@' => $url . "&lang=en");


if (($_SESSION["action"] == "print") or ($_SESSION["action"] == "submit")) {
    $kw['@bodyattr@'] = 'onLoad="javascript:window.print()" ';
}

print_header($kw);


$kw = array('@id@' => $_SESSION['id'], '@lang@' => $lang);

?>



<table width="100%" border="1" cellpadding="0">
    <tr>
        <td valign="top" width="50%">
            <?php print_table($table1, 1, "border=\"0\" height=\"100%\" ", $link, $kw); ?>
        </td>
        <td valign="top">
            <?php print_table($table2, 1, "border=\"0\" height=\"100%\" ", $link, $kw); ?>
        </td>
    </tr>
    <tr>
        <td valign="top" width="50%">
            <?php print_table($table3, 1, "border=\"0\" height=\"100%\" ", $link, $kw); ?>
        </td>
        <td valign="top">
            <?php print_table($table4, 1, "border=\"0\" height=\"100%\" ", $link, $kw); ?>
        </td>
    </tr>
</table>

<?php

print "<form>";

print '<input type="hidden" name="lang" value="' . $lang . '">';
print '<input type="hidden" name="id" value="' . $_SESSION["id"] . '">';
print '<input type="hidden" name="action" value="' . $_SESSION["action"] . '">';

if ($_SESSION["action"] == "show") {

    print '<table border="0" width="100%"><tr><td>';

    if ($status != 'old') {
        if ($barcode_error)
            print $text['error'];
        print "<strong>" . $text['barcode'] . ":</strong>&nbsp;&nbsp;";

        unset ($_SESSION['barcode']);
        print '<input type="text" name="barcode" size="12" maxlength="12">';

        print '&nbsp;&nbsp;&nbsp;<input type="submit" name="button" value="' .
            $buttons['submit'] . '">&nbsp;';
    } else
        print '&nbsp;';

    print '</td></tr><tr><td>&nbsp;';
    print '</td><td>&nbsp;</td></tr><tr><td>';

    print '<input type="submit" name="button" value="' . $buttons['goto_index'] .
        '">&nbsp;';

    print '<input type="submit" name="button" value="' . $buttons['edit'] . '" ';
    print ($status == "old") ? "disabled=yes" : "";
    print '>&nbsp;';

    print '<input type="submit" name="button" value="' . $buttons['print'] . '" ';
    print ($status != "old") ? "disabled=yes" : "";
    print '>&nbsp;';

    print '<input type="submit" name="button" value="' . $buttons['delete'] .
        '">';
    print '&nbsp;</td></tr>';

    print '<tr><td><br>';
    print ($barcode_error) ? $text['error'] . "<strong>" . $text['error_msg'] . "</strong>" : "&nbsp;";
    print '</td><td>&nbsp;</td></tr></table>';

    print '</table>';

} else if ($_SESSION["action"] == "delete") {

    print "<br><br>";
    print $text['confirm_delete'];
    print '&nbsp;<input type="submit" name="button" value="' .
        $buttons['ok'] . '"> ';
    print '&nbsp;<input type="submit" name="button" value="' .
        $buttons['cancel'] . '"> <br>';


} // ***** DISCLAIMER_INFO ANZEIGEN WENN CHECKBOX AKTIVIERT IST *****
else if (($_SESSION["action"] == "print") or
    ($_SESSION["action"] == "submit")
) {

    $kw = array("@today@" => strftime('%d. %m. %Y'));
    # print "<br><br>\n";
    $mailtext = "SELECT email FROM persons WHERE id ='@id@'";
    $mailtext2 = db_query_mysql($link, $mailtext, array('@id@' => $_SESSION['id']));
    if ($mailtext2[1]['email'] != "") {
        print $text['disclaimer_info'];
    }
    print $text['info_1'];
    print strtr($text['sign_here'], $kw);

} else if (($_SESSION["action"] == "submit-check")) {
    $fields = array(
        "name" => "Nachname",
        "first_name_initials_prefix" => "Vorname",
        //		"gender" => "m/w",
        "date_of_birth" => "Geburtsdatum",
        "borrower_bar" => "Barcode",
        "borrower_status" => "Status",
    );

    print $text['user_account_conflict'];

    print "<br><br><table border=\"1\" cellpadding=\"5\">";

    print "<tr>";
    foreach ($fields as $f)
        print "<th>$f</th>";
    print "</tr>";

    foreach ($double_accs as $row) {
        print "<tr>";

        foreach ($fields as $k => $dummy)
            print "<td>" . htmlentities($row[$k]) . "</td>";

        print "</tr>";
    }

    print "</table>";

    print $text['confirm_submit'];
    print '&nbsp;<input type="submit" name="button" value="' .
        $buttons['ok'] . '"> ';
    print '&nbsp;<input type="submit" name="button" value="' .
        $buttons['cancel'] . '"> ';

}

print "</form>";

print_footer(array());

mysql_close($link);
?>
