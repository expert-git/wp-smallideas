<?php

/**
 * Template Name: Trial form 
 * The template for displaying the 14 day trial form
 */

get_header(); ?>

<style>
	.trial-container {max-width:350px;}
	input {margin-bottom:10px;}
	.btn {background-color:#a5cd4e;padding:6px 11px;color:#fff;-webkit-border-radius: 3px;-moz-border-radius: 3px;border-radius: 3px;font-size:14px;margin-top:0px;clear:both;text-decoration:none;display:inline-block;}
	.btn:hover,	.btn:active {background-color:#80a531;color:#fff;}
</style>

<script>
	jQuery('document').ready(function(){
		
		var $loading = jQuery('#loading').hide();
		jQuery(document)
		  .ajaxStart(function () {
		    $loading.show();
		  })
		  .ajaxStop(function () {
		    $loading.hide();
		  });		  
		
		jQuery('.trialbut').click(function(e){
//			alert(jQuery('form').serialize()); return;
				//update existing
				jQuery.ajax('https://app.smallideas.com.au/ajax/createTrial.php', {
					method: "POST",
					data: jQuery('form.trialform').serialize(),
					success: function(data) {                    

						var result = jQuery.parseJSON( data );
						if(result.success){                        
							//saved			
							alert("Done! Please check your email for your login details. Please check your junk/spam folder if you don't see it within 10 min.");
							jQuery('input').each(function(){
								jQuery(this).val('');
							})

						} else {
							if(result.reason == 'email'){
								alert("Please ensure your email address is correct, and that you don't already have an account");
							} else if(result.reason == 'name'){
								alert("Please ensure you enter your name & phone.");
							} else {
								//alert error
								alert("We couldnt create your account sorry.  Please refresh and try again.");
							}
										
						}
					},
					error: function(xhr, status, error) {
					 // var err = eval("(" + xhr.responseText + ")");					 
					  //console.log(err.Message);
					// alerterror
					alert("We couldnt create your account sorry.  Please refresh and try again.");
					  
					}
				});		
		
			});
		
	});
</script>

<div id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			
			<h2 style="font-size:28px;margin:20px 0;">Free 5 day trial</h2>
			<p>Enter your details below to get a free 5 day trial of our Small Ideas digital membership. </p>
			
			<div class="trial-container">	
				<form class="trialform" role="search">				
					<input type="text" name="firstname" placeholder="First name"> 
					<input type="text" name="lastname" placeholder="Phone"> 
					<input type="text" name="email" placeholder="Email" />
					<a class="btn trialbut" href="javascript:;">Get Now</a> &nbsp;&nbsp;<span id="loading"><img src="<?php echo get_stylesheet_directory_uri(); ?>/ajax-loader.gif" width="16" alt="Loading..."></span>
				</form>
			</div>

			<br><br>

		<?php endwhile; // end of the loop. ?>

	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>


<?php

// send ... email verification
// then send logins....
// msg if account already exists

?>