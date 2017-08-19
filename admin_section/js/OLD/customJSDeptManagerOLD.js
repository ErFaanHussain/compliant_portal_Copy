$(document).ready(function(){
    $("#deptManager").addClass("active");

  $("#depttName").focusout(function(){
    val("#depttName","#depttNameCont");
  });
  $("#shortCode").focusout(function(){
    val("#shortCode","#shortCodeCont");
  });
  $("#uid").focusout(function(){
      val("#uid","#uidCont");
  });
  $("#pwd").focusout(function(){
    val("#pwd","#pwdCont");
  });
  $("#adminName").focusout(function(){
    val("#adminName","#adminNameCont");
  });
  $("#email").focusout(function(){
    val("#email","#emailCont");
  });
  $("#depttSelect").change(function(){
    val("#depttSelect","#depttSelectCont");
  });
  function val(id,cont){
    if($(id).val() == ""){
      $(cont).removeClass("has-success");
      $(id).removeClass("form-control-success");
      $(cont).addClass("has-danger");
      $(id).addClass("form-control-danger");
    }else{
      $(cont).removeClass("has-danger");
      $(id).removeClass("form-control-danger");
      $(cont).addClass("has-success");
      $(id).addClass("form-control-success");
    }
  }
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
  });
  // js for department creation
  var successCCreate = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-check-circle" aria-hidden="true"></i> Success! </strong>Department Created Successfully';
  var fAlCCreate = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><strong><i class="fa fa-times" aria-hidden="true"></i> Error! </strong>Department already exists';

  $("#createBtn").click(function(){
      var deptName = $("#depttName").val();
      var shortCode = $("#shortCode").val();
      if(!deptName == "" && !shortCode == ""){
        jQuery.post("ajax/createDept.php", { depttName : deptName , dShortCode : shortCode },function(data, status)
        {
              if(status == 'success')
              {
                if(data == 'success')
                {
                      $("#resultAlert").removeClass("alert-warning alert-danger").addClass("alert alert-success alert-dismissible fade show").html(successCCreate);
                      setTimeout(resetLoginVal('create'),3000);
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
    });
});
