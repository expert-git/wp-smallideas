
/* additional js functions not specific to theme functions */ 

$('document').ready(function(){


	$('.save-user').click(function(e){

		//update existing
		$.ajax('/ajax/saveUser.php', {
			method: "POST",
			data: $('form.edit-user').serialize(),
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){                        
					//saved			
					toastr["success"]("The user details were saved.", "Saved");
					window.location.href="/manager/";

				} else {
					if(result.reason == 'email'){
						toastr["error"]("That email address is already in use.", "ERROR");
					} else if(result.reason == 'password'){
						toastr["error"]("Ensure your password has letters & numbers", "ERROR");
					} else {
						//alert error
						toastr["error"]("There was a problem saving your changes.", "ERROR");
					}
										
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem saving your changes.", "ERROR");
			}
		});		
		
	});



	$(document).on('click','.clone',function(e){

		var $id = $(this).data('voucherid');

		//update existing
		$.ajax('/ajax/cloneVoucher.php', {
			method: "POST",
			data: "id=" + $id,
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success && result.newid){                        
					//saved			
					window.location.href="/manager/voucher.php?id=" + result.newid;

				} else {
					//alert error
					toastr["error"]("There was a problem cloning the voucher.", "ERROR");		
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem cloning the voucher.", "ERROR");	
			}
		});		
		
	});


	$('select[name=isOnlineCoupon').change(function(){	
		if($(this).val() == '1'){
			//$('.onlineCouponText').css('display','block');
		} else {
			//$('.onlineCouponText').css('display','none');
		}
	});


	$('.save-voucher').click(function(e){

		//update existing
		$.ajax('/ajax/saveVoucher.php', {
			method: "POST",
			data: $('form.edit-voucher').serialize(),
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){                        
					//saved			
					toastr["success"]("The voucher details were saved.", "Saved");
					location.reload();

				} else {

					if(result.reason == 'validation'){
						toastr["error"]("Ensure all required fields have been entered.", "ERROR");
					} else {
						//alert error
						toastr["error"]("There was a problem saving your changes.", "ERROR");
					}
										
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem saving your changes.", "ERROR");
			}
		});
		
	});


	$('#sortable_images .remove').click(function(){
		$div = $(this).closest('.sortable-image').remove();		
		$('#image').val('');
	});



	/* delete activity 
	$('.delete-user').click(function(){
		
		$id = $(this).data('userid');
		
		$.ajax('/ajax/deleteUser.php', {
			method: "POST",
			data: 'id=' + $id,
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){                        
					//reload page
					window.location.href="/manager/";
//				toastr["error"]("There was a problem deleting the user.", "ERROR");
				} else {
					//alert error
					toastr["error"]("There was a problem deleting the user.", "ERROR");										
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem deleting the user.", "ERROR");
			}
		});
	});	*/
	
	
	/* delete activity 
	$('.delete-voucher----old').click(function(){
		
		$id = $(this).data('voucherid');
		
		$.ajax('/ajax/deleteVoucher.php', {
			method: "POST",
			data: 'id=' + $id,
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){                        
					//reload page
					//window.location.href="/manager/vouchers.php";
				} else {
					//alert error
					toastr["error"]("There was a problem deleting the voucher.", "ERROR");										
				}
			},
			error: function() {
				// alerterror
				toastr["error"]("There was a problem deleting the voucher.", "ERROR");
			}
		});
	});	*/

	
});




/* toastr notifications general options */
toastr.options = {
		"closeButton": true,						
		"positionClass": "toast-top-right",
		"onclick": null,
		"showDuration": "1000",
		"hideDuration": "1000",
		"timeOut": "5000",
		"extendedTimeOut": "1000",
		"showEasing": "swing",
		"hideEasing": "linear",
		"showMethod": "fadeIn",
		"hideMethod": "fadeOut"
		}










 