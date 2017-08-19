$(document).ready(function(){
			  	$("#homeLink").addClass("active");
	// validation START
	$.validator.addMethod("pwcheck", function(value) {
  	   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // only these
       // && /[a-z]/.test(value) // has a lowercase letter
       // && /\d/.test(value) // has a digit
	});
  	var validator1 = $( "#loginForm" ).validate( {
				rules: {
					username: {
						required: true,
						rangelength: [5,25],
						nowhitespace: true
					},
					password: {
						required: true,
						rangelength: [5,30],
						nowhitespace: true,
						pwcheck: true
					}
				},
				messages: {
					username: {
						required: "Please enter your username",
						rangelength: "Username must be 5-25 characters long",
						nowhitespace: "No white spaces allowed"
					},
					password: {
						required: "Please provide your password",
						rangelength: "Password must be 5-30 characters long",
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
  	   $.validator.addMethod("nameCheck",function(value){
  	   	return /^[a-zA-Z\s]*$/.test(value) 
  	   });
  	   $.validator.addMethod("regNumberCheck",function(value){
  	   	return /^[A-Za-z0-9\-\/]*$/.test(value) 
  	   });
  	   $.validator.addMethod("rollNoCheck",function(value){
  	   	// return /^[A-Za-z0-9\-]*$/.test(value) 
  	   	return /^[A-Za-z]+\-\d{2}\-\d{2}$/.test(value) 
  	   });

  	var validator2 = $( "#signUpForm" ).validate( {
				rules: {
					name: {
						required: true,
						nameCheck: true,
						rangelength: [5,50]
					},
					regNumber: {
						required: true,
						nowhitespace: true,
						regNumberCheck: true,
						rangelength: [14,15]
					},
					rollNo: {
						required: true,
						nowhitespace: true,
						rollNoCheck: true,
						rangelength: [8,11]
					},
					mobile: {
						required: true,
						nowhitespace: true,
						digits: true,
						rangelength: [10,10]
					},
					email: {
						required: true,
						email: true,
						maxlength: 60
					},
					depttID: {
						required: true
					},
					courseID: {
						required: true
					},
					username: {
						required: true,
						rangelength: [5,25],
						nowhitespace: true,
					},
					password: {
						required: true,
						rangelength: [5,30],
						nowhitespace: true,
						pwcheck: true,
					}
				},
				messages: {
					name: {
						required: "Please enter your name",
						nameCheck: "Only Characters and White spaces are allowed",
						rangelength: "Name must be 5-50 characters long"
					},
					regNumber: {
						required: "Please enter your Registration Number",
						nowhitespace: "No white spaces allowed",
						regNumberCheck: "Alphanumeric characters and [- or /] are allowed",
						rangelength: "Registration Number must be 14 or 15 characters long"
					},
					rollNo: {
						required: "Please enter your Roll Number",
						nowhitespace: "No white spaces allowed",
						rollNoCheck: "Alphanumeric characters and [-] are allowed in pattern 'MCA-14-48'",
						rangelength: "Roll No. must be 8-10 characters long"
					},
					mobile: {
						required: "Please enter your mobile number",
						nowhitespace: "No white spaces allowed",
						digits: "Mobile numbers are usually numeric",
						rangelength: "Accepted length is 10 digits"
					},
					email: {
						required: "Please enter your Email address",
						email: "Please enter a valid email address",
						maxlength: "Email must be less than 60 characters"
					},
					depttID: {
						required: "Please select your department"
					},
					courseID: {
						required: "Please select your course"
					},
					username: {
						required: "Please enter your username",
						rangelength: "Username must be 5-25 characters long",
						nowhitespace: "No white spaces allowed"
					},
					password: {
						required: "Please provide your password",
						rangelength: "Password must be 5-30 characters long",
						nowhitespace: "No white spaces allowed",
						pwcheck: "Password must contain only A-Z, a-z, 0-9 and =!-@._*"
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
  $( '#resetFormLogin').on('click', function(){
  	validator1.resetForm();
  	resetValidation('login');
  });
   $( '#resetFormSignUp').on('click', function(){
  	validator2.resetForm();
  	resetValidation('signup');
  });
  function resetValidation(context){
  	if(context === 'login'){
  		$( '#uid' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#pwd' ).parents('.form-group').removeClass("has-success has-danger");
  	}else{
  		$( '#name' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#regNo' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#rollNo' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#mobile' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#email' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#depttSelect' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#courseSelect' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#uid1' ).parents('.form-group').removeClass("has-success has-danger");
  		$( '#pwd1' ).parents('.form-group').removeClass("has-success has-danger");
  	}
  }			
});
function fillCourse(){
  var deptId = $('#depttSelect').val();
  console.log(deptId);
  jQuery.post("courseAdd.php",{ DeptID : deptId },
        function(data,status){
          if(status == 'success'){
            console.log(data);
            if(data[0] === 'success'){
              var select = $('#courseSelect');
              select.html('<option selected value="">--Select Program--</option>').removeClass("form-control-danger").parent().removeClass("has-danger");
              $('#courseStatus').text('');
                for (var i=1; i<data.length; i++) {
                   select.append('<option value="' + data[i].courseID + '">' + data[i].courseName + '</option>');
                } 
                select.focus();
            }
            else if(data[0] === 'no course'){
              $('#courseSelect').html('<option selected value="">--Select Program--</option>').addClass("form-control-danger").parent().addClass("has-danger");
              $('#courseStatus').addClass('text-danger').text('No Program added for the selected department');
            }
            
          }
          else{
            console.log('XHR failed');
          }
        
    }, "json");
}