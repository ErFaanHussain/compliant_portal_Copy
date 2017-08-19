$(document).ready(function(){
  			$("#postLink").addClass("active");
  			setTimeout((function(){
                      $("#InfoFooter").slideToggle("slow");
                    }),3000);
  			
  			$("#closeFooter").on('click',function(){
  				$("#InfoFooter").hide('slow');
  			});
  			// Validation STARTS
  	$( "#postComplaintForm" ).validate({
				rules: {
					subject: {
						required: true,
						rangelength: [10,100]
					},
					depttID: {
						required: true
					},
					complaint: {
						required: true,
						rangelength: [30,500]
					}
				},
				messages: {
					subject: {
						required: "Please provide a subject",
						rangelength: "Subject must be 10-100 characters long"						
					},
					depttID: {
						required: "Please select a department"					
					},
					complaint: {
						required: "Please enter complaint description",
						rangelength: "Complaint description must be 30-500 characters long"
					}
				},
				errorElement: "small",
				errorPlacement: function ( error, element ) {
					error.addClass( "form-control-feedback" );
					error.insertAfter( element );
				},
				success: function ( label, element ) {
					$( element ).addClass("form-control-success");
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).parents(".form-group").addClass("has-danger").removeClass("has-success");
					$( element ).addClass( "form-control-danger" ).removeClass( "form-control-success" );
				},
				unhighlight: function ( element, errorClass, validClass ) {
					$( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-danger" );
					$( element ).next( "span" ).addClass( "form-control-success" ).removeClass( "form-control-danger" );
				}
			});
  // validation END
  		});