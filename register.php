<?php

require_once('text.php');
require_once('config.php');
require_once('util.php');
require_once('fields.php');

session_start();

// select language

$lang = (isset($_GET['lang'])) ? $_GET['lang'] : $lang_default;

if (!isset($text_multi[$lang]))
    $lang = $lang_default;

$text = $text_multi[$lang];
$buttons = $buttons_multi[$lang];
$months = $months_multi[$lang];

// store result in data base

if (isset($_SESSION['edit_finished'])) {


    // init db

    ($link = mysql_pconnect($dbhost, $dbuser, $dbpass)) or db_error_mysql();
    mysql_select_db($dbname, $link) or db_error_mysql();

    // prepare substitution table

    $kw = array();

    foreach ($fields as $k => $v) {
        if (isset($_SESSION[$k]))
            $kw['@' . $k . '@'] = $_SESSION[$k];
    }

    // last page of form, end of session
    session_destroy();

    // try to store into data base

    if ($_SESSION["email"] != "") {
        // ***** ERHOEHE USERTYPE_ID UM 20 *****
        $kw['@' . usertype . '@'] = $_SESSION['usertype'] + 20;


        $q = "INSERT INTO persons VALUES (NULL, " .
            "'@last_name@', '@first_name@', '@title@', '@sex@', " .
            "'@birthday@', '@usertype@','@email_checkbox@', '@email@'," .
            "'@email_confirm@', '@student_id@', 'new', " .
            "NULL, NULL, NOW() )";
    } else {
        $kw['@' . email_checkbox . '@'] = 'f';
        $q = "INSERT INTO persons VALUES (NULL, " .
            "'@last_name@', '@first_name@', '@title@', '@sex@', " .
            "'@birthday@', '@usertype@', '@email_checkbox@', NULL,NULL,  '@student_id@', 'new', " .
            "NULL, NULL, NOW() )";
    }


    db_query_mysql($link, $q, $kw);

    $kw['@person_id@'] = mysql_insert_id($link);

    $q = "INSERT INTO addresses VALUES (NULL, @person_id@, " .
        "'@carry_over_1@', '@street_1@', '@house_1@', '@room_1@', " .
        "'@zip_1@', '@town_1@', '@phone_1@', '@mobile_1@', 'true' );";

    db_query_mysql($link, $q, $kw);

    $q = "INSERT INTO addresses VALUES (NULL, @person_id@, " .
        "'@carry_over_2@', '@street_2@', '@house_2@', '@room_2@', '@zip_2@', " .
        "'@town_2@', '@phone_2@', '@mobile_2@', 'false' );";

    db_query_mysql($link, $q, $kw);

    unset($_SESSION['edit_finished']);
}

// print user notice

$kw = array('@notabene@' => '', '@bodyattr@' => '',
    '@url-de@' => 'register.php?lang=de',
    '@url-en@' => 'register.php?lang=en');

print_header($kw);
print $text['info_2'];
print_footer($kw);
