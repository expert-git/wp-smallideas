


$(document).ready(function(){
    

	$('#btn-redeem').click(function(){
		
        var voucherid = $(this).data('vid');
        
		$.ajax('/ajax/redeemVoucher.php', {
			method: "POST",
			data: "voucherid=" + voucherid,
			success: function(data) {                    

				var result = jQuery.parseJSON( data );
				if(result.success){        
                    $.featherlight($('#success'));
					
				} else {
					//error						
					$.featherlight($('#fail'));						
				}
				//stop spinner button
				l.stop();
			},
			error: function() {
				//error
				$.featherlight($('#fail'));
			}
		});


	});





	$('.sendpasswordlink').click(function(e){

		e.preventDefault();

		//start spinner button
		var l = Ladda.create(this);
		l.start();

		if($('input[name=resetemail]').val()==''){
			alert('Please enter your email.');
			l.stop();
			return;			
		}	

		$.ajax('/ajax/login.php?mode=reset', {
			method: "POST",
			data: "email=" + $('input[name=resetemail]').val(),
			success: function(data) {                    
				var result = jQuery.parseJSON( data );
				if(result.success){                   					
					$('.modal').modal('hide');
					alert("Password reset instructions have now been sent to " + $('input[name=resetemail]').val() + '. Please check your SPAM/Junk folder.');
					l.stop();
				} else {
					//error						
					alert("There was a problem resetting your password.");
					l.stop();
				}				
			},
			error: function() {
				//error
				alert("There was a problem resetting your password.");
				l.stop();
			}
		});


	});

	
	
	/* reset pw */
		$('.resetpw').submit(function(e){

			e.preventDefault();

			if($('input[name=newpassword]').val()==''){
				alert('Please enter a new password.');
				return;			
			}	

			$.ajax('/ajax/login.php?mode=setpassword', {
				method: "POST",
				data: "password=" + $('input[name=newpassword]').val() + '&url=' + $('input[name=url]').val(),
				success: function(data) {                    
					var result = jQuery.parseJSON( data );
					if(result.success){
						alert("Your password has been set!");
						location.href = "/";
					} else {
						//error						
						alert("There was a problem resetting your password.");
					}				
				},
				error: function() {
					//error
					alert("There was a problem resetting your password.");
				}
			});


		});

		
});



// Mobile Safari in standalone mode - used by apple-mobile-web-app-capable to stop links opening in external window
if(("standalone" in window.navigator) && window.navigator.standalone){

	// If you want to prevent remote links in standalone web apps opening Mobile Safari, change 'remotes' to true
	var noddy, remotes = false;
	
	document.addEventListener('click', function(event) {
		
		noddy = event.target;
		
		// Bubble up until we hit link or top HTML element. Warning: BODY element is not compulsory so better to stop on HTML
		while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
	        noddy = noddy.parentNode;
	    }
		
		if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes))
		{
			event.preventDefault();
			document.location.href = noddy.href;
		}
	
	},false);
}

/* resumes standalone app to last page */
if (window.navigator.standalone) {
	var setLastUrl = function() {
		localStorage['lastUrl'] = window.location;
	}
	if (sessionStorage['init']) {
		setLastUrl();
	} else {
		sessionStorage['init'] = true;
		if (localStorage['lastUrl']) {
			if (localStorage['lastUrl'] != window.location) {
				document.location.href = localStorage['lastUrl'];
			} else {
				setLastUrl();
			}
		} else {
			setLastUrl();
		}
	}
}


