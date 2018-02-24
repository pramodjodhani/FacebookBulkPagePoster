<?php 


error_reporting(E_ALL); 
ini_set('display_errors', 1);

function query($sql) {

	global $con;
	if ($result = $con->query($sql)) {
	
		//$user = $result->fetch_assoc();
		return $result;

	}
	else {
		echo "query failed: ".$sql;
		return false;
	}

}

function post_to_page() {
	?>
	<form action="post.php" method="post">
  		
  		<div class="form-group">
  			<label>Caption:</label>
  			<textarea name="text" placeholder="Caption"  class="form-control"></textarea>
  		</div>
  		<div class="form-group">
  			<label>Image:</label>
  			<input type="file" name="file" class="form-control">
  		</div>
  		<div class="form-group pages_group">
  			<label>Pages:</label><br>
  			<?php 
  				$pages = get_list_of_pages();
  				foreach($pages as $page) {
  					//print_r($page);exit;
  					echo "<label><input type='checkbox' value='{$page->id}' name='pages[]' />{$page->name}</label><br>";
  				}
  			?>
  		</div>
  		
  		<input type="submit" class="btn btn-primary" >

  	</form>
      <?php 
}

function authenticate_btn() {
	
	global $fb;

	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email', 'manage_pages' , 'publish_pages']; // Optional permissions

	$loginUrl = $helper->getLoginUrl(SITE_URL."fb-callback.php", $permissions);

	echo "<a href='$loginUrl' class='btn btn-primary btn-lg '>Click here to Authenticate</a>";

}


function authentication_done() {


	if(get_access_token()) {
		return true; 
	}		
	else {

	}


}

function get_access_token() {

	$user_id = $_SESSION["user_id"];

	$res = query("select * from user where ID = $user_id");

	$user = $res->fetch_object();

	return $user->accesstoken;

}

function fb_logout_btn() {
	global $fb;

	try {
	  // Returns a `Facebook\FacebookResponse` object
	  $response = $fb->get('/me?fields=id,name', get_access_token() );
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	$user = $response->getGraphUser();
	$url = SITE_URL."fblogout.php";
	echo  "<div class='logout_div'> Logged in as <b>".$user['name']."</b>. <a href='$url'>Logout?</a> </div>";
	//print_r($user);

}

function fetch_page_tokens() {
	
	global $fb;
	
	$accounts = $fb->get("/me/accounts" , get_access_token());

	$pages = array();

	$i = 0;

	$data = $accounts->getBody();

		
	$user_id = $_SESSION["user_id"];
	
	$sql = "update user set pages = '$data' where ID = $user_id";

	query($sql);

}

function get_list_of_pages() {
	$user_id = $_SESSION["user_id"];
	$res = query("select * from user where ID = $user_id");
	
	$val = $res->fetch_object()->pages; 
	return json_decode($val)->data; 
}

function get_page_token($page_id) {
	$pages = get_list_of_pages();
	foreach ($pages as $page) {
		if($page->id == $page_id) {
			return $page->access_token;
		}
	}
	return -1;
} 


function post_to_page_call($page_id , $text, $img=-1) {

	global $fb;

	$token = get_page_token($page_id);

	try {
	  // Returns a `Facebook\FacebookResponse` object
		$endpoint = "/$page_id/feed";
		$data = array (
	      'message' => $text,
	    );

		if($img != -1) {
			$data["url"] = $img; 
			$endpoint = "/$page_id/photos";
		}

	  	$response = $fb->post( $endpoint , $data ,$token);
	} 
	catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} 
	catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
	$graphNode = $response->getGraphNode();
	return $graphNode;
}