$(document).ready(function(){
			  $("#superLink").addClass("active");
$.validator.addMethod("pwcheck", function(value) {
  	   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // only these
       // && /[a-z]/.test(value) // has a lowercase letter
       // && /\d/.test(value) // has a digit
	});
  	$( "#loginForm" ).validate( {
				rules: {
					username: {
						required: true,
						rangelength: [5,15],
						nowhitespace: true
					},
					password: {
						required: true,
						rangelength: [5,40],
						nowhitespace: true,
						pwcheck: true
					}
				},
				messages: {
					username: {
						required: "Please enter your username",
						rangelength: "Username must be 5-15 characters long",
						nowhitespace: "No white spaces allowed"
					},
					password: {
						required: "Please provide your password",
						rangelength: "Password must be 5-40 characters long",
						nowhitespace: "No white spaces allowed",
						pwcheck: "Password contains only A-Z, a-z, 0-9 and =!-@._*"
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