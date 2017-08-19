// Javascript for Super Admin Dashboard
$(document).ready(function(){
  $("#dashboardLink").addClass("active");
  // JS for -- stats by department -- START //
  $("#depttSelectStats").change(function(){
    var dId = $("#depttSelectStats").val();
    console.log(dId);
    if(dId == ""){
      $("#depttSelectStatsCont").addClass("has-danger");
      $("#depttSelectStats").addClass("form-control-danger");
      $("#res").addClass("text-danger").text('Please Select a Department');
      $("#totalCont").html("");
      $("#repliedCont").html("");
      $("#pendingCont").html("");
      $("#resolvedCont").html("");
      $("#notResolvedCont").html("");
    }
    else
    {
      $("#depttSelectStatsCont").removeClass("has-danger").addClass("has-success");
      $("#depttSelectStats").removeClass("form-control-danger").addClass("form-control-success");
      $("#res").text('');
      jQuery.post("ajax/getStats.php",
      {
        depttID: dId
      },
      function(data, status)
      {
        console.log(data);
        console.log(status);
        if(status == 'success')
        {
          console.log(data);
          console.log('XHR status:success');
          var stat2 = data["status"];
          var total = data["totalComp"];
          var replied = data["repliedComp"];
          var pending = data["pendingComp"];
          var resolved = data["resolvedComp"];
          var notResolved = data["notResolvedComp"];
              if(stat2 == 'success')
              {
                  console.log('data retrieved successfully');
                  console.log(stat2+'\n'+total+'\n'+replied+'\n'+pending);
                  $("#totalCont").html('<i class="fa fa-list-alt" aria-hidden="true"></i> Complaints Registered: '+total);
                  $("#repliedCont").html('<i class="fa fa-check-square-o" aria-hidden="true"></i> Replied: '+replied);
                  $("#pendingCont").html('<i class="fa fa-pause-circle-o" aria-hidden="true"></i> Pending: '+pending);
                  $("#resolvedCont").html('<i class="fa fa-check" aria-hidden="true"></i> Resolved: '+resolved);
                  $("#notResolvedCont").html('<i class="fa fa-remove" aria-hidden="true"></i> Not Resolved: '+notResolved);
                  setTimeout((function(){
                      jQuery("#depttSelectStatsCont").removeClass("has-success");
                      jQuery("#depttSelectStats").removeClass("form-control-success");
                    }),2000);
                }
                else
                {
                  console.log('nothing received');
                }
        }
        else
        {
          console.log('XHR Returned Null');
        }
      });
    }
  });
  // JS for -- stats by department -- END //
});
function postReply(Id,sId){
     jQuery(document).ready(function(){
        var com = jQuery("#replyText"+Id).val();
        if(!com == ""){
          jQuery("#replyBtn"+Id).prop('disabled',true);
          jQuery("#replyText"+Id).prop('disabled',true);
          jQuery("#status"+Id).remove();
          jQuery.post("ajax/sAdpostReply.php",{ comptID: Id , reply: com , sid: sId },
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
function publishC(Id){
  jQuery(document).ready(function(){
  jQuery.post("ajax/publish.php",{ ComptID: Id },
  function(data, status){
    console.log(Id);
    if(status == 'success'){
      console.log(status);
      console.log('\n'+data);
      if(data == 'success'){
        jQuery("#publishBtn"+Id).prop('disabled',true);
        jQuery("#statusP"+Id).removeClass("text-danger").addClass("text-success").text('| Published');
        jQuery("#publishResult"+Id).html('<h6 class="text-primary ml-4">Successfully Published</h6>');
      }else{
        jQuery("#publishResult"+Id).html('<h6 class="text-danger ml-4">Failed to Publish</h6>');
        jQuery("publishBtn"+Id).prop('disabled',false);
      }
    }else{
      jQuery("#publishResult"+Id).html('<h6 class="text-danger ml-4">Failed to Publish</h6>');
      jQuery("publishBtn"+Id).prop('disabled',false);
    }
});
setTimeout((function(){
    jQuery("#publishResult"+Id).remove();
  }),3000);
});
}
function deleteC(Id){
    jQuery(document).ready(function(){
      jQuery.post("ajax/deleteAJAX.php",{ ComptID: Id },
      function(data, status){
        console.log(Id);
        if(status == 'success'){
          console.log(status);
          console.log('\n'+data);
          if(data == 'success'){
            jQuery("#deleteBtn"+Id).prop('disabled',true);
            jQuery("#statusP"+Id).removeClass("text-danger").addClass("text-danger").text('| Deleted');
            jQuery("#publishResult"+Id).html('<h6 class="text-primary ml-4">Successfully Deleted</h6>');
            jQuery("#card"+Id).addClass("card-outline-danger");
            setTimeout((function(){
              jQuery("#card"+Id).remove();
            }),3000);
          }else{
            jQuery("#publishResult"+Id).html('<h6 class="text-danger ml-4">Failed to Delete</h6>');
            jQuery("deleteBtn"+Id).prop('disabled',false);
          }
        }else{
          jQuery("#publishResult"+Id).html('<h6 class="text-danger ml-4">Failed to Delete : XHR</h6>');
          jQuery("deleteBtn"+Id).prop('disabled',false);
        }
        setTimeout((function(){
          jQuery("#publishResult"+Id).remove();
        }),3000);
      });
    });
}
function forward(cId, dOrigin){
  var modal = $("#forwardModal");
  modal.find('.modal-title').text('Forward Complaint');
  // $$ START $$
  $("#saveForward").click(function(){
    var dId = $("#depttSelectForward").val();
    console.log('\nForwarding: '+cId+'\nFrom: '+dOrigin+'\nTo: '+dId);
    if(dId == ""){
      $("#mesForward").text('');
      $("#depttSelectForwardCont").addClass("has-danger");
      $("#depttSelectForward").addClass("form-control-danger");
      $("#resForward").addClass("text-danger").text('Please Select a Department');
    }
    else
    {
      if(dOrigin == dId){
        jQuery("#depttSelectForwardCont").removeClass("has-success").addClass("has-danger");
        jQuery("#depttSelectForward").removeClass("form-control-success").addClass("form-control-danger");
        $("#mesForward").removeClass("text-success").addClass("text-danger").text('Complaint is already adressed to the Selected Department');
        setTimeout((function(){
            jQuery("#depttSelectForwardCont").removeClass("has-danger");
            jQuery("#depttSelectForward").removeClass("form-control-danger");
            $("#mesForward").removeClass("text-success text-danger").text('');
          }),2000);
      }
      else{

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
                  dOrigin = dId;
                  setTimeout((function(){
                      jQuery("#depttSelectForwardCont").removeClass("has-success");
                      jQuery("#depttSelectForward").removeClass("form-control-success");
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
      jQuery.post("ajax/postFollowUpSadmin.php",
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
