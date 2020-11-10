var FormDropzone = function () {

    return {
        //main function to initiate the dropzone for first item.  Repeated comment entries are handled in form-repeater.js
        init: function () {  

            Dropzone.options.myDropzone = {
                url: "/ajax/imageUpload.php",
                maxFilesize: 4, // MB
                acceptedFiles: "image/jpeg",                 
                dictDefaultMessage: "Drop .JPG photo here or click to upload <br>(4MB max)",
                maxFiles: 1,                
                success: function(file, response){                    
                    var result = jQuery.parseJSON( response );
                    if(result.success){                        
                        //update list of images (first child only)       
                        //var $imagesInput = $('.mt-repeater-row input.images').first();
                        //var images = $imagesInput.val();                        
                        $('#image').val(result.file);
						//file.newName = result.file; //for later use for deleting
                    } else {
                        alert('There was a problem uploading the photo.');
                    }
                },
                init: function() {    
                    
                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");
                        //console.log(this.options.inputName);
                        // Capture the Dropzone instance as closure.
                        var _this = this;

                   

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
						  
						  
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });
					
					this.on("removedfile", function(file) {
					
//						alert(file.toSource());
//						alert(file.name);
//						alert(file.newName);
						
                       // var $imagesInput = $('.mt-repeater-row input.images').first();
                     //   var images = $imagesInput.val();  
						
						//rebuild and leave out removed file
					//	var imageArr = images.split(",");
						// var newImageString = '';
						// for(var i=0;i<imageArr.length;i++){
						// 	if(imageArr[i]!=file.newName){
						// 		newImageString += imageArr[i] + ',';
						// 	}
						// }
						
						$('#image').val('');
						
					});
					
                }            
            }
        }
    };
}();

jQuery(document).ready(function() {    
   FormDropzone.init();
});