<?php
//set the environment to production after installation
if (!defined('ENVIRONMENT'))
    define('ENVIRONMENT', 'development');

$domain = $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
$domain = preg_replace('/index.php.*/', '', $domain); //remove everything after index.php
if (!empty($_SERVER['HTTPS'])) {
    $domain = 'https://' . $domain;
} else {
    $domain = 'http://' . $domain;
}

//database content
$hostname = "localhost";
$username = "root";
$password = "";
$database = "eservice";

//constants content
$admin_email = "shinebayr2000@gmail.com";
$company_email = "eservice@gmail.com";