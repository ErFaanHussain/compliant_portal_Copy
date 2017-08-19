$.validator.addMethod("pwcheck", function(value) {
  	   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // only these
       // && /[a-z]/.test(value) // has a lowercase letter
       // && /\d/.test(value) // has a digit
	});
  	$( "#loginForm" ).validate( {
				rules: {
					username: {
						required: true,
						minlength: 2,
						nowhitespace: true
					},
					password: {
						required: true,
						minlength: 5,
						nowhitespace: true,
						pwcheck: true
					}
				},
				messages: {
					username: {
						required: "Please enter your username",
						minlength: "Your username must consist of at least 2 characters",
						nowhitespace: "No white spaces allowed"
					},
					password: {
						required: "Please provide your password",
						minlength: "Your password must be at least 5 characters long",
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