<?php 

require "Facebook/autoload.php";
require "functions.php";

if(!session_id()) {
    session_start();
}

define("SITE_URL" , "http://footy.dk/fbupload/");
define("APP_ID" , "553340168368648");
define("APP_SECRET" , "0aab9cda8defbc2e00737b6c2b66519d");



define("DATABASE_HOST" , "localhost");
define("DATABASE_NAME" , "footy_fbupload_db");
define("DATABASE_USER" , "footyfbuploadusr");
define("DATABASE_PASS" , "rzeqLZY@J8");



$fb = new \Facebook\Facebook([
  'app_id' => APP_ID,
  'app_secret' => APP_SECRET,
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);


$con = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

if($con->connect_errno) {
    echo "Sorry, this website is experiencing problems.";
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    exit;
}



