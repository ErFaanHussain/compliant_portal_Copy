$(document).ready(function(){
  $("#dashboardLink").addClass("active");
});
function postReply(Id,sId){
     jQuery(document).ready(function(){
        var com = jQuery("#replyText"+Id).val();
        console.log(com+Id+sId);
        if(!com == ""){
          jQuery("#replyBtn"+Id).prop('disabled',true);
          jQuery("#replyText"+Id).prop('disabled',true);
          jQuery("#status"+Id).remove();
          jQuery.post("ajax/postReply.php",{ comptID: Id , reply: com , sid: sId },
          function(data, status){
            if(status == 'success'){
              jQuery("#replyText"+Id).val("");
              jQuery("#replyCont"+Id).removeClass("has-danger");
              jQuery("#replyText"+Id).removeClass("form-control-danger");
            }
            jQuery("#replyCont"+Id).addClass("has-success");
            jQuery("#replyText"+Id).addClass("form-control-success");
            jQuery("#replyText"+Id).val('Reply: '+com);
              var stat = data["status"];
              var ti = data["timeStamp"];
              console.log(stat+ti);
              if(stat == 'success'){
                jQuery("#result"+Id).html('<h6 class="text-success">Replied Successfully, On: '+ti+'</h6>');
                jQuery("#statusM"+Id).removeClass("text-danger").addClass("text-success").text('Replied');
                jQuery("#followUp"+Id).prop('disabled',false);
              }else{
                jQuery("#result"+Id).html('<h6 class="text-danger">Failed to post Reply</h6>');
                jQuery("#replyCont"+Id).addClass("has-danger");
                jQuery("#replyText"+Id).addClass("form-control-danger");
                jQuery("#replyBtn"+Id).prop('disabled',false);
                jQuery("#replyText"+Id).prop('disabled',false);
              }
            setTimeout((function(){
                jQuery("#replyCont"+Id).removeClass("has-success");
                jQuery("#replyText"+Id).removeClass("form-control-success");
              }),3000);
        });
      }else{
        jQuery("#replyCont"+Id).addClass("has-danger");
        jQuery("#replyText"+Id).addClass("form-control-danger");
      }
     });
}
function forward(cId){
  var modal = $("#forwardModal");
  modal.find('.modal-title').html('<i class="fa fa-share" aria-hidden="true"></i> Forward Complaint');
  // $$ START $$
  $("#saveForward").click(function(){
    var dId = $("#depttSelectForward").val();
    if(dId == ""){
      $("#mesForward").text('');
      $("#depttSelectForwardCont").addClass("has-danger");
      $("#depttSelectForward").addClass("form-control-danger");
      $("#resForward").addClass("text-danger").text('Please Select a Department');
    }
    else
    {
      $("#depttSelectForwardCont").removeClass("has-danger").addClass("has-success");
      $("#depttSelectForward").removeClass("form-control-danger").addClass("form-control-success");
      $("#resForward").text('');
      jQuery.post("ajax/forwardComplaint.php",
      {
        comptID: cId,
        deptID: dId
      },
      function(data, status)
      {
        console.log(data);
        if(status == 'success')
        {
          console.log('XHR status:success');
              if(data == 'success')
              {
                  $("#mesForward").removeClass("text-danger").addClass("text-success").text('Complaint Forwarded Successfully');
                  $("#card"+cId).addClass("card-outline-danger");
                  setTimeout((function(){
                      jQuery("#depttSelectForwardCont").removeClass("has-success");
                      jQuery("#depttSelectForward").removeClass("form-control-success");
                      $("#card"+cId).remove();
                      // $("#cId").remove();
                      $("#mesForward").removeClass("text-success text-danger").text('');
                    }),2000);
                }
                else
                {
                  console.log('failure received: BE');
                  $("#mesForward").removeClass("text-success").addClass("text-danger").text('Failed to Forward Complaint: BE');
                  setTimeout((function(){
                      jQuery("#depttSelectForwardCont").removeClass("has-success has-danger");
                      jQuery("#depttSelectForward").removeClass("form-control-success form-control-danger");
                      $("#mesForward").removeClass("text-success text-danger").text('');
                    }),2000);
                }
        }
        else
        {
          console.log('XHR Returned Null');
          $("#mesForward").removeClass("text-success").addClass("text-danger").text('Failed to Forward Complaint: XHR');
        }
      });
    }
  });
  //  $$ END $$$
}

// XHR - AJAX for follow up START
function followUp(cId){
  var modal = $("#followUpModal");
  modal.find('.modal-title').text('Add Follow-Up');
  // $$ START $$
  $("#saveFollowUp").click(function(){
    var followUp = $("#followUpText").val();
    console.log(followUp);
    if(followUp == ""){
      $("#mesFollowUp").text('');
      $("#followUpCont").addClass("has-danger");
      $("#followUpText").addClass("form-control-danger");
      $("#resFollowUp").addClass("text-danger").text('Follow up can\'t be empty');
    }
    else
    {
      $("#followUpCont").removeClass("has-danger").addClass("has-success");
      $("#followUpText").removeClass("form-control-danger").addClass("form-control-success");
      $("#resFollowUp").text('');
      jQuery.post("ajax/postFollowUpDepttadmin.php",
      {
        comptID: cId,
        followUpCont: followUp
      },
      function(data, status)
      {
        console.log(data);
        var stat = data["status"];
        var timeStamp = data["timeStamp"];;
        if(status == 'success')
        {
              if(stat == 'success')
              {
                  $("#mesFollowUp").removeClass("text-danger").addClass("text-success").text('Follow-Up Posted Successfully on: '+timeStamp);
                   $("#followUpCard"+cId).append('<p class="card-text mb-0">'+followUp+'<small class="float-right">'+timeStamp+'</small><footer class="blockquote-footer"><cite>You</cite></footer></p>');
                  setTimeout((function(){
                      $("#followUpCont").removeClass("has-success");
                      $("#followUpText").removeClass("form-control-success");
                      $("#mesFollowUp").removeClass("text-success text-danger").text('');
                      $("#followUpText").val("");
                    }),3000);
                }
                else
                {
                  console.log('failure received: BE');
                  $("#mesFollowUp").removeClass("text-success").addClass("text-danger").text('Failed to Post Follow-Up: BE');
                  setTimeout((function(){
                      $("#followUpCont").removeClass("has-success has-danger");
                      $("#followUpText").removeClass("form-control-success form-control-danger");
                      $("#mesFollowUp").removeClass("text-success text-danger").text('');
                    }),3000);
                }
        }
        else
        {
          console.log('XHR Returned Null');
          $("#mesFollowUp").removeClass("text-success").addClass("text-danger").text('Failed to Post Follow-Up: XHR');
        }
      });
    }
  });
  //  $$ END $$$
}
// XHR - AJAX for follow up END
