<?php include "header.php"; ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h1 class="mt-5">Post to pages</h1>
      
      <div class="post_to_page">
      	
      	<?php 

      		if(authentication_done()) {

      			//fetch_page_tokens();
            //echo get_page_token("2084987358438056");
            fb_logout_btn();
      			post_to_page();


      		}
      		else {
      			authenticate_btn();
      		}

      	?>


      </div>
      
    </div>
  </div>
<?php include "footer.php"; ?>
