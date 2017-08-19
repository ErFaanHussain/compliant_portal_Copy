$(document).ready(function(){
  $("#updateBtn").click(function(){
    $("#name").prop('disabled',false);
    $("#username").prop('disabled',false);
    $("#saveBtn").prop('disabled',false);
    $("#passCheck").prop('disabled',false);
    $("#email").prop('disabled',false);
    $(this).prop('disabled',true);
  });
    // Validation START
    $.validator.addMethod("pwcheck", function(value) {
       return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // only these
       // && /[a-z]/.test(value) // has a lowercase letter
       // && /\d/.test(value) // has a digit
  });
    $.validator.addMethod("nameCheck",function(value){
        return /^[a-zA-Z\s.]*$/.test(value) 
       });
    $( "#updateForm" ).validate( {
        rules: {
          name1: {
            required: true,
            rangelength: [5,50],
            nameCheck: true
          },
          email1: {
            required: true,
            email: true,
            maxlength: 50
          },
          uname: {
            required: true,
            rangelength: [5,15],
            nowhitespace: true
          },
          pwd1: {
            required: true,
            rangelength: [5,40],
            nowhitespace: true,
            pwcheck: true
          }
        },
        messages: {
          name1: {
            required: "Please enter your name",
            rangelength: "Name must be 5-50 characters long",
            nameCheck: "Only Characters and White spaces are allowed"
          },
          email1: {
            required: "Please enter your Email address",
            email: "Please enter a valid email address",
            maxlength: "Email must be less than 50 characters long"
          },
          uname: {
            required: "Please enter a username",
            rangelength: "Username must be 5-15 characters long",
            nowhitespace: "No white spaces allowed"
          },
          pwd1: {
            required: "Please provide a password",
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
          $( element ).parents(".col-9").addClass("has-danger").removeClass("has-success");
          $( element ).addClass( "form-control-danger" ).removeClass( "form-control-success" );
        },
        unhighlight: function ( element, errorClass, validClass ) {
          $( element ).parents( ".col-9" ).addClass( "has-success" ).removeClass( "has-danger" );
          $( element ).next( "span" ).addClass( "form-control-success" ).removeClass( "form-control-danger" );
        }
      });
  // validation END
  $("#passCheck").change(function(){
    if(this.checked){
      $("#password").prop('disabled',false);
      $("#password").val("");
    }else{
      $("#password").prop('disabled',true);
      $("#password").val("dummypass");
    }
  });
  // $("#name").focusout(function(){
  //   val("#name","#nameCont");
  // });
  // $("#username").focusout(function(){
  //   val("#username","#usernameCont");
  // });

  // $("#password").focusout(function(){
  //   val("#password","#passwordCont");
  // });
  // function val(id,cont){
  //   if($(id).val() == ""){
  //     $(cont).removeClass("has-success");
  //     $(id).removeClass("form-control-success");
  //     $(cont).addClass("has-danger");
  //     $(id).addClass("form-control-danger");
  //   }else{
  //     $(cont).removeClass("has-danger");
  //     $(id).removeClass("form-control-danger");
  //     $(cont).addClass("has-success");
  //     $(id).addClass("form-control-success");
  //   }
  // }
  $("#cnclBtn").click(function(){
    $("#saveBtn").prop('disabled',true);
    $("#updateBtn").prop('disabled',false);
    $("#username").prop('disabled',true);
    $("#passCheck").prop('disabled',true);
    $("#password").prop('disabled',true);
    $("#email").prop('disabled',true);
    $("#name").prop('disabled',true);
    $("#usernameCont").removeClass("has-danger").removeClass("has-success");
    $("#username").removeClass("form-control-danger").removeClass("form-control-success");
    $("#passwordCont").removeClass("has-danger").removeClass("has-success");
    $("#password").removeClass("form-control-danger").removeClass("form-control-success");
    $("#emailCont").removeClass("has-danger").removeClass("has-success");
    $("#email").removeClass("form-control-danger").removeClass("form-control-success");
    $("#nameCont").removeClass("has-danger").removeClass("has-success");
    $("#name").removeClass("form-control-danger").removeClass("form-control-success");
    $("#pChangeResult").addClass("text-success").text('');
  });
  $("#saveBtn").click(function(){
    var form = $("#updateForm");
    if(!form.valid()){
      console.log('form not valid');
      $("#pChangeResult").addClass("text-danger").text('Some Details InValid');
    }else{
      console.log('form valid');
    var id = $("#aId").val();
    var username = $("#username").val();
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var pFlag = 0;
      if ($("#passCheck").is(':checked')){
      var pFlag = 1;
    }

    // console.log(id+'\n'+username+'\n'+name+'\n'+password);
    if(!username == "" && !name == "" && !id == "" && !password == "" && !email == ""){

      jQuery.post("ajax/updateProfile.php",{ uName : username, Name : name, iD : id, Flag : pFlag, Password : password, Email: email},
          function(data, status){
            if(status == 'success'){
              if(data == 'success'){
                  $("#pChangeResult").removeClass("text-danger").addClass("text-success").text('Profile Updated Successfully');
                  $("#saveBtn").prop('disabled',true);
                  $("#updateBtn").prop('disabled',false);
                  $("#name").prop('disabled',true);
                  $("#username").prop('disabled',true);
                  $("#passCheck").prop('disabled',true);
                  $("#password").prop('disabled',true);
                  $("#email").prop('disabled',true);
                  setTimeout((function(){
                    $("#nameCont").removeClass("has-danger").removeClass("has-success");
                    $("#name").removeClass("form-control-danger").removeClass("form-control-success");
                    $("#usernameCont").removeClass("has-danger").removeClass("has-success");
                    $("#username").removeClass("form-control-danger").removeClass("form-control-success");
                    $("#passwordCont").removeClass("has-danger").removeClass("has-success");
                    $("#password").removeClass("form-control-danger").removeClass("form-control-success");
                    $("#emailCont").removeClass("has-danger").removeClass("has-success");
                    $("#email").removeClass("form-control-danger").removeClass("form-control-success");
                    $("#pChangeResult").addClass("text-success").text('');
                  }),3000);
                }else{
                  $("#pChangeResult").addClass("text-danger").text('Profile Updation Failed: BE');
                  console.log(data);
                }
                }else{
                  $("#pChangeResult").addClass("text-danger").text('Profile Updation Failed: XHR');
                  console.log(data);
                }
        });
    }else{
      $("#pChangeResult").addClass("text-danger").text('Some Details Missing');
    }
  }
  });
});
