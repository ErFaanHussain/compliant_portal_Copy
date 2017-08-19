$(document).ready(function(){
    $("#deptManager").addClass("active");
    // validation START
  $.validator.addMethod("pwcheck", function(value) {
       return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // only these
       // && /[a-z]/.test(value) // has a lowercase letter
       // && /\d/.test(value) // has a digit
  });
       $.validator.addMethod("nameCheck",function(value){
        return /^[a-zA-Z\s.]*$/.test(value) 
       });

    var validator2 = $( "#cLoginForm" ).validate( {
        rules: {
          dAdminName: {
            required: true,
            minlength: 5,
            nameCheck: true,
            maxlength: 30
          },
          dEmail: {
            required: true,
            email: true,
            maxlength: 50
          },
          depttID: {
            required: true
          },
          username: {
            required: true,
            minlength: 5,
            nowhitespace: true,
            maxlength: 20
          },
          password: {
            required: true,
            minlength: 5,
            nowhitespace: true,
            pwcheck: true,
            maxlength: 40
          }
        },
        messages: {
          dAdminName: {
              required: "Please enter your name",
              minlength: "Minumum length must be 5",
              nameCheck: "Only Characters and White spaces are allowed",
              maxlength: "Admin Name must be less than 30 characters"
          },
          dEmail: {
            required: "Please enter your Email address",
            email: "Please enter a valid email address",
            maxlength: "Email must be less than 50 characters"
          },
          depttID: {
            required: "Please select your department"
          },
          username: {
            required: "Please enter your username",
            minlength: "Username must consist of at least 5 characters",
            nowhitespace: "No white spaces allowed",
            maxlength: "Username must be less than 20 characters"
          },
          password: {
            required: "Please provide your password",
            minlength: "Your password must be at least 5 characters long",
            nowhitespace: "No white spaces allowed",
            pwcheck: "Password must contain only A-Z, a-z, 0-9 and =!-@._*",
            maxlength: "Password must be less than 40 characters long"
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
    var validator1 = $( "#createDeptForm" ).validate( {
        rules: {
          depttName: {
            required: true,
            minlength: 5,
            nameCheck: true,
            maxlength: 100
          },
          dShortCode: {
            required: true,
            nowhitespace: true,
            maxlength: 10
          }
        },
        messages: {
          depttName: {
              required: "Please enter the Department Name",
              minlength: "Minumum length must be 5",
              nameCheck: "Only Characters and White spaces are allowed",
              maxlength: "Department Name should be less than 100 characters"
          },
          dShortCode: {
            required: "Please enter the Department ShortCode",
            nowhitespace: "No white spaces allowed",
            maxlength: "Short Code should be less than 10 characters"
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

var successCLogin = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success! </strong>Login Created Successfully';
var fAlCLogin = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Error! </strong>Username already exists';
var fSysCLogin = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-times" aria-hidden="true"></i> Error! </strong>System Error, Contact Administrator';
var fFECLogin = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-times" aria-hidden="true"></i> Error! </strong>Request Failed, Contact Administrator';
var detMissing = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-times" aria-hidden="true"></i> Error! </strong>Some details missing, Please enter all the details';
function resetLoginVal(context){
  if(context == 'create'){
      $("#depttNameCont").removeClass("has-danger").removeClass("has-success");
      $("#depttName").val("").removeClass("form-control-danger").removeClass("form-control-success");
      $("#shortCodeCont").removeClass("has-danger").removeClass("has-success");
      $("#shortCode").val("").removeClass("form-control-danger").removeClass("form-control-success");
  }else{
      $("#depttSelectCont").removeClass("has-danger").removeClass("has-success");
      $("#depttSelect").val("").removeClass("form-control-danger").removeClass("form-control-success");
      $("#adminNameCont").removeClass("has-danger").removeClass("has-success");
      $("#adminName").val("").removeClass("form-control-danger").removeClass("form-control-success");
      $("#pwdCont").removeClass("has-danger").removeClass("has-success");
      $("#pwd").val("").removeClass("form-control-danger").removeClass("form-control-success");
      $("#emailCont").removeClass("has-danger").removeClass("has-success");
      $("#email").val("").removeClass("form-control-danger").removeClass("form-control-success");
      $("#uidCont").removeClass("has-danger").removeClass("has-success");
      $("#uid").val("").removeClass("form-control-danger").removeClass("form-control-success");
  }
}
function resetAlert(){
    $("#resultAlert").remove();
}
$("#cLoginBtn").click(function(){
  var form = $('#cLoginForm');
   if(!form.valid()){
      console.log('form not valid');
       $("#resultAlert").removeClass("alert-success alert-warning").addClass("alert alert-danger alert-dismissible fade show").html(detMissing);
    }else{
      console.log('form valid');
    var depttId = $("#depttSelect").val();
    var name = $("#adminName").val();
    var username = $("#uid").val();
    var password = $("#pwd").val();
    var email = $("#email").val();
    if(!username == "" && !name == "" && !depttId == "" && !password == "" && !email == ""){
      jQuery.post("ajax/createLogin.php", { uname : username, dAdminName : name, depttID : depttId, pwd : password, dEmail : email },function(data, status)
      {
            if(status == 'success')
            {
              if(data == 'success')
              {
                    $("#resultAlert").removeClass("alert-warning alert-danger").addClass("alert alert-success alert-dismissible fade show").html(successCLogin);
                    setTimeout(resetLoginVal('login'),3000);
              }
              else if(data == 'uid exists')
              {
                  $("#resultAlert").removeClass("alert-success alert-danger").addClass("alert alert-warning alert-dismissible fade show").html(fAlCLogin);
              }
              else if(data == 'system error')
              {
                  $("#resultAlert").removeClass("alert-success alert-warning").addClass("alert alert-danger alert-dismissible fade show").html(fSysCLogin);
              }
              }
              else
              {
                  $("#resultAlert").removeClass("alert-success alert-warning").addClass("alert alert-danger alert-dismissible fade show").html(fFECLogin);
              }
        });
    }
    else{
      $("#resultAlert").removeClass("alert-success alert-warning").addClass("alert alert-danger alert-dismissible fade show").html(detMissing);
    }
  }
  });
  // js for department creation
  var successCCreate = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success! </strong>Department Created Successfully';
  var fAlCCreate = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-times" aria-hidden="true"></i> Error! </strong>Department already exists';

  $("#createBtn").click(function(){
      var form = $( "#createDeptForm" );
      if(!form.valid()){
      console.log('form not valid');
       $("#resultAlert").removeClass("alert-success alert-warning").addClass("alert alert-danger alert-dismissible fade show").html(detMissing);
    }else{
      console.log('form valid');
      var deptName = $("#depttName").val();
      var shortCode = $("#shortCode").val();
      if(!deptName == "" && !shortCode == ""){
        jQuery.post("ajax/createDept.php", { depttName : deptName , dShortCode : shortCode },function(data, status)
        {
              if(status == 'success')
              {
                console.log(data);
                var st = data["status"];
                var insertId = data["insertId"];
                if(st == 'success')
                {
                      $("#resultAlert").removeClass("alert-warning alert-danger").addClass("alert alert-success alert-dismissible fade show").html(successCCreate);
                      setTimeout(resetLoginVal('create'),3000);
                      $('#depttSelect').append('<option value="' + insertId + '">' + deptName + '</option>');
                }
                else if(data == 'already exists')
                {
                    $("#resultAlert").removeClass("alert-success alert-danger").addClass("alert alert-warning alert-dismissible fade show").html(fAlCCreate);
                }
                else if(data == 'system error')
                {
                    $("#resultAlert").removeClass("alert-success alert-warning").addClass("alert alert-danger alert-dismissible fade show").html(fSysCLogin);
                }
                }
                else
                {
                    $("#resultAlert").removeClass("alert-success alert-warning").addClass("alert alert-danger alert-dismissible fade show").html(fFECLogin);
                }
          });
      }
      else{
        $("#resultAlert").removeClass("alert-success alert-warning").addClass("alert alert-danger alert-dismissible fade show").html(detMissing);
      }
    }
    });
  $('#resetForm').on('click', function(){
    validator1.resetForm();
    resetLoginVal('create');
  });
  $('#resetForm2').on('click', function(){
    validator2.resetForm();
    resetLoginVal('login');
  });
});
