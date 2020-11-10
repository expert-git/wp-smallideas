<?php 



	/*
	 * Smallideas nsw group signup form
	 * Shortcode - [smallideas_member_form group="Playgroup NSW"]
	 * Author: entice.com.au
	 */

	function memberform_shortcode( $atts ) {
		if(!isset($atts['group']))
			return;
		
		$html = '
			<form method="post" class="main">
				<div class="row">
					<div class="col-6">
					
						<div class="form-box">
							<h3 class="box-title">Your Details</h3>
							<div class="row">
								<div class="col-6">
									<label>First Name</label>
									<input name="firstName" class="form-input" type="text">
								</div>
								<div class="col-6">
									<label>Last Name</label>
									<input name="lastName" class="form-input" type="text">
								</div>
							</div>
							<div class="row">
								<label>Phone</label>
								<input name="phone" class="form-input" type="text">
							</div>							
						</div>	
					
					</div>
					<div class="col-6">
					
						<div class="form-box">
							<h3 class="box-title">Login Details</h3>
							<div class="row">
								<label>Email</label>
								<input name="email" class="form-input" type="text">
								<div class="frm_error existing-email hidden">It looks like you\'ve already got an account. You can <a href="https://app.smallideas.com.au/">log in here</a>. If you\'ve forgotten your password, you can reset it at the login screen.</div>
							</div>
							<div class="row">
								<div class="col-6">
									<label>Password</label>
									<input name="password" class="form-input" type="password">
									<div class="frm_error password-complexity hidden">Include letters, numbers and at least 6 chars.</div>
								</div>
								<div class="col-6">
									<label>Re-enter password</label>
									<input name="password-confirm" class="form-input" type="password">
									<div class="frm_error password-match hidden">The passwords do not match.</div>
								</div>
								<div class="clearfix"></div>
							</div>
							
							<input name="joomtst" class="form-input" type="hidden" value="">
							<input name="group" class="form-input" type="hidden" value="'.$atts['group'].'">
						</div>	
						
					
					</div>

				</div>
				<div class="clearfix"></div>
				<div class="row center" style="margin:30px auto;max-width:400px;">
					<div class="frm_error fields hidden" style="margin-bottom:20px;">Ensure all fields are completed correctly.</div>
					<!--<div class="checkbox">
						<label class="checkbox"><input type="checkbox" name="iagree"> I have read in detail, understand completely and fully accept Small Ideas <a href="/terms-conditions/">Terms & Conditions</a></label>
					</div>-->
					<div style="margin-top:20px;">
						<button class="btn btn-red" type="submit">Continue</button>
					</div>
				</div>
			</form>
			<br><br>
			
			<script>
				jQuery(document).ready(function(){
					jQuery("form.main").submit(function(e){
						e.preventDefault();
						
						
						//validate
						jQuery(".frm_error").addClass("hidden");
						jQuery("input,label,.checkbox").removeClass("error");
						var hasNumbers = /\d/.test(jQuery("input[name=password]").val());
						if(jQuery("input[name=password]").val().length < 6 || !hasNumbers){
							jQuery(".frm_error.password-complexity").removeClass("hidden");
							jQuery("input[name=password],input[name=password-confirm]").addClass("error");							
							return;
						}
						if(jQuery("input[name=password]").val() != jQuery("input[name=password-confirm]").val()){
							jQuery(".frm_error.password-match").removeClass("hidden");
							jQuery("input[name=password],input[name=password-confirm]").addClass("error");
							return;
						}
						if(jQuery("input[name=firstName]").val().length < 2 || jQuery("input[name=phone]").val().length < 10 || jQuery("input[name=email]").val().length < 7){
							jQuery(".frm_error.fields").removeClass("hidden");		
							return;
						}
						//if(!jQuery("input[name=iagree]").is(":checked")){
						//	jQuery("div.checkbox").addClass("error");
						//	return;
						//}
								
						//submit
						jQuery.ajax("/ajax/member-create.php", {
			                  method: "POST",
			                  data: jQuery("form.main").serialize(),
			                  success: function(data) {                    
			                    var result = jQuery.parseJSON( data );
			                    if(result.success){                        
			                    	//saved     
			            			window.location.href = "https://smallideas.com.au/thankyou-playgroupnsw/";
									
			                    } else {
									//alert error 
									if(result.reason == "email"){
										jQuery(".frm_error.existing-email").removeClass("hidden");
										
									} else {
										alert("There was a problem creating your account.  Please refresh and try again.");
									}
			                      }                    
			                  },
			                  error: function() {
			                    // alerterror
								alert("There was a problem creating your account.  Please refresh and try again.");        
			                  }
			            });
						
						
						
			
					});
				});
			</script>

	
							
			';
		
		return $html;
		
	}
	
	add_shortcode( 'smallideas_member_form', 'memberform_shortcode' );