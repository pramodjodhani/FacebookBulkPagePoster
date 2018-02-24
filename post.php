<?php 

include "config.php";

if(isset($_POST["text"]) && isset($_POST["pages"])) {

	$text = $_POST["text"];

	$pages = $_POST["pages"];

	foreach($pages as $page) {
		//todo upload image and generate the URL of $img
		$img = 	"http://pramodjodhani.com/wp-content/uploads/2016/05/banner3.jpg";
		post_to_page_call($page , $text , $img);
	}
	
	header("location: members.php");
}
