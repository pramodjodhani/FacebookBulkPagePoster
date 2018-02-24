<?php 

require "Facebook/autoload.php";
require "functions.php";

if(!session_id()) {
    session_start();
}

define("SITE_URL" , "http://localhost/fbbulk/");
define("APP_ID" , "757198031024035");
define("APP_SECRET" , "84e464e054a7d07fdec4987d0b1a371f");


define("ADMIN_USERNAME" , "admin");
define("ADMIN_PASS" , "123@Admin");


define("DATABASE_HOST" , "localhost");
define("DATABASE_NAME" , "fbbulk");
define("DATABASE_USER" , "root");
define("DATABASE_PASS" , "");



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



