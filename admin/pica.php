<?php

// This file is part of the web-based "Application Form for New Users" 
// of University Library Braunschweig, Germany
//
// Copyright (C) 2004 University Library Braunschweig, Germany

/// \file 
///
/// \brief Submit an applicant's record to PICA
///
/// These functions perform the transfer of an applicant's record in 
/// the MySQL database into the PICA system, using the PICA tool 
/// 'ousp_upd_borrower'. They also provide some safety catches 
/// (e.g. checking for conflicts with existing PICA records).
/// 
/// \sa PICA documentation (OUS_F docu, chap. 6.3) 

require_once('../text.php');
require_once('../util.php');

/// \brief perform the transfer of a record to the PICA database
/// 
/// \param $dblink open handle to MySQL database
/// \param $id record number to be transferred
/// \returns TRUE if the transfer was successful, FALSE otherwise
///
/// \warning This function does not check whether the new user
/// is actually an old user who already has a PICA account. 
/// If you want to check this, call check_for_doubles() before 
/// calling this function.

function export_to_pica($dblink, $id, $barcode) {
    global $text;
    global $fields;
    global $iln;
    global $pica_export_command;

// default values 

    $pica = array(
        "a000" => $iln, // ILN
        "a100" => "U", // Update
        "a104" => "0", // user status (loan allowed)
        "a111" => "1", // Nummer der Mahnadresse
        "a200" => "U", // Update
        "a201" => "001", // Abteilungsgruppen-Nummer
        "a300" => "U", // Update
        "a301" => "1", // 1: extern, 0: intern
        "b400" => "U" // Update
    );

// query database, assign results to $pica[] array

    foreach ($fields as $f) {

        $q = (isset($f["pica_query"])) ? $f["pica_query"] : $f["query"];
        $r = db_query_mysql($dblink, $q, array("@id@" => $id));

        $k = (isset($f["pica_field"])) ? $f["pica_field"] : "";

        if ((!empty($k)) and (!empty($r))) {
            $pica[$k] .= $r[1][0] . " ";
        }
    }

// strip trailing blanks

    foreach ($fields as $f) {
        $k = (isset($f["pica_field"])) ? $f["pica_field"] : "";
        if (!empty($k)) {
            $pica[$k] = preg_replace("/ $/", "", $pica[$k]);
        }
    }

// do postprocessing

// date of creation
    $pica["a001"] = strftime('%d-%m-%Y');

// barcode

    if (!empty($barcode)) {
        $pica["a102"] = $barcode;
    }

// create serial number

    if (!isset($pica["a114"]) or ($pica["a114"] == "")) {
        $qs = array(
            "lock tables serial_number write ",
            "update serial_number set number=0, " .
            " time=CURDATE() where YEAR(time) != YEAR(CURDATE()) ",
            " update serial_number set number=number+1 ",
            " select DATE_FORMAT(time,'%y'), number " .
            " from serial_number "
        );

        foreach ($qs as $q)
            $r = db_query_mysql($dblink, $q, array());

        if (!empty($r)) {
            $pica["a114"] = $r[1][0] . '/' . $r[1][1];
        }

        db_query_mysql($dblink, "unlock tables", array());

    }


// fix registration number (student id, or Nota Bene ID) 

    $q = $fields["usertype"]["query"];
    $r = db_query_mysql($dblink, $q, array('@id@' => $id));

    if (!empty($r)) {
        $usertype = $r[1][0];
// ***** ERWEITERTE NUTZERTYPEN *****
        if ($usertype == 1 || $usertype == 21) {
            $pica["a101"] = "" . $pica["a101"];
        } else {
            if ($usertype == 2 || $usertype == 22) {
                $pica["a101"] = "FH" . $pica["a101"];
            } else {
                if ($usertype == 3 || $usertype == 23) {
                    $pica["a101"] = "HBK" . $pica["a101"];
                } else {
                    if (($usertype >= 4) && ($usertype != 21 || $usertype != 22 || $usertype != 23)) {
                        $pica["a101"] = "NB" .
                            strtr($pica["a114"], array("/" => ""));
                    }
                }
            }
        }
    }

// check reg no

    if (!check_registration_number($pica["a101"])) {
        $kw = array(
            '@notabene@' => "",
            '@bodyattr@' => "",
            '@url-de@' => "index.php?lang=de",
            '@url-en@' => "index.php?lang=en",
            '@regno@' => $pica['a101']);

        print_header($kw);
        print strtr($text['conflict_regno'], $kw);
        print_footer($kw);
        exit(0);
    }

// write serial number into database

    $q = $fields["notabene"]["update"];
    $kw = array('@id@' => $id, '@val@' => $pica["a114"]);

    db_query_mysql($dblink, $q, $kw);


// determine whether we've got a second address
// create header if necessary

    $second_address = FALSE;

    foreach ($pica as $k => $v) {
        if (strpos($k, "b3") === 0 and ($v != "")) {
            $second_address = TRUE;
        }
    }

    if ($second_address) {
        $pica["b300"] = "U";
        $pica["b301"] = "2";
    }

// create export file

    ksort($pica); // sort by key
    reset($pica);

    $export = "";

    foreach ($pica as $k => $v) {
        $k = preg_replace("/^[a-zA-Z]/", "", $k);
        if ($v != "") {
            $export .= "$k $v\n";
        }
    }


// do character translation for german umlauts

    $export = strtr($export, "�������", "\301\302\303\321\322\323\276");

// run export command

// print "<pre>$export</pre>";
    ($handle = popen($pica_export_command, "w")) or
    error_msg("could not run command: $pica_export_command");
    fwrite($handle, $export) or error_msg("pipe broken");
    return pclose($handle);
}


/// \brief check a registration number for validity
/// 
/// \param $regnum registration number
///
/// The registration number is a field in a PICA user record.
///
/// It is mandatory that the registration number of a new 
/// PICA record be chosen unique, because the PICA tool 
/// 'ousp_upd_borrower' uses this field as a primary key. 
///
/// If a pre-existing PICA record has the same registration 
/// number as the new one, the old record will be overwritten.
/// This must be avoided.
///
/// This function verifies that the chosen registration number 
/// is indeed unique by performing query a on the PICA database.
///
/// \returns TRUE if the registration number is unique (i.e. usable), 
///          and FALSE if it is not unique or the database query 
///	     failed for some reason

function check_registration_number($regnum) {

    global $LBSServer;
    global $LBSDB;
    global $LBSUser;
    global $LBSPw;
    global $iln;

    ($lnk = @ sybase_pconnect($LBSServer, $LBSUser, $LBSPw)) or error_msg("SYBASE: pconnect failed");

    (@ sybase_select_db($LBSDB, $lnk)) or error_msg("SYBASE: database $LBSDB not found");

    $q = "select * from borrower where " . "registration_number = '@regnum@' and iln = $iln";
// . "registration_number = '@regnum@'";


    $regnum = strtr($regnum, array("'" => "''", "%" => ""));
    $q = strtr($q, array("@regnum@" => $regnum));

// print $q;

    ($res = sybase_query($q, $lnk)) or error_msg("SYBASE: database query failed");

    return (($res) and (sybase_num_rows($res) > 0)) ? FALSE : TRUE;
}

/// \brief avoid double membership
///
/// \param $dblink open handle to MySQL database
/// \param $id     record number of user in MySQL database
///
/// This function performs a PICA database query to find pre-existing
/// PICA records similar to the applicants'. Records are considered 
/// similar if the last name and the date of birth match.
///
/// \returns a list of PICA records that are similar to the 
/// applicant's record, or FALSE if a database error occurs.
///
/// We expect the applicant <em>not</em> to be a library user 
/// yet, so this function should return an empty list.

function check_for_doubles($dblink, $id) {
    global $fields;

    global $LBSServer;
    global $LBSDB;
    global $LBSUser;
    global $LBSPw;
    global $iln;


    $birthday = "0000-00-00";

    $q = $fields["last_name"]["query"];
    $r = db_query_mysql($dblink, $q, array('@id@' => $id));

    $name = (isset($r[1][0])) ? $r[1][0] : "";

    $q = $fields["birthday"]["query"];
    $r = db_query_mysql($dblink, $q, array('@id@' => $id));

    $birthday = (isset($r[1][0])) ? $r[1][0] : "";

    if (empty($name) or empty($birthday)) {
        return FALSE;
    }

    list ($year, $month, $day) = split('-', $birthday);


    $months_by_name = array(
        "01" => "Jan", "02" => "Feb", "03" => "Mar", "04" => "Apr",
        "05" => "May", "06" => "Jun", "07" => "Jul", "08" => "Aug",
        "09" => "Sep", "10" => "Oct", "11" => "Nov", "12" => "Dec");

    $users = array();

    ($lnk = @ sybase_pconnect($LBSServer, $LBSUser, $LBSPw)) or error_msg("SYBASE: pconnect failed");

    (@ sybase_select_db($LBSDB, $lnk)) or error_msg("SYBASE: database $LBSDB not found");


// extract last name

    $users = array();

    $q = "select name,first_name_initials_prefix,gender,date_of_birth," .
        "borrower_bar,borrower_status from borrower where " .
        "LOWER(name) LIKE '%@name@%' and " .
        "date_of_birth = '@birth@' and iln = $iln";

    $birth = $months_by_name[$month] . " " . $day . " " . $year;
    $names = explode(" ", $name);
    $name = $names[count($names) - 1];
    $name = strtr($name, array("'" => "''", "%" => ""));

// umlaut translation
    $name = strtolower(strtr($name, "�������", "_______"));

    $q = strtr($q, array("@name@" => $name, "@birth@" => $birth));

    ($erg = sybase_query($q, $lnk)) or error_msg("SYBASE: database query failed");


    if ($erg) {
        $i = 0;

        while ($row = sybase_fetch_array($erg)) {

            // umlaut back-translation

            $row["name"] = strtr($row["name"],
                "\301\302\303\321\322\323\276",
                "�������"
            );
            $row["first_name_initials_prefix"] = strtr(
                $row["first_name_initials_prefix"],
                "\301\302\303\321\322\323\276",
                "�������"
            );

            $users[$i] = $row;
            $i++;
        }
    }


    sybase_close($lnk);

    return $users;
}

?>
