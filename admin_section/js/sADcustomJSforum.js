$(document).ready(function(){
  $("#forumLink").addClass("active");
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
function postComment(Id){
     jQuery(document).ready(function(){
        var com = jQuery("#comment"+Id).val();
        console.log(com);
        if(!com == ""){
          jQuery.post("ajax/sAdpostComment.php",{ topicId: Id , comment: com },
          function(data, status){
            if(status == 'success'){
              jQuery("#comment"+Id).val("");
              jQuery("#commentCont"+Id).removeClass("has-danger");
              jQuery("#comment"+Id).removeClass("form-control-danger");
              jQuery("#commentCard"+Id).append('<p class="card-text mb-0">'+com+'<small class="float-right">'+data+'</small><footer class="blockquote-footer"><cite>You</cite></footer></p>');
              var cCount = jQuery("#commentCount"+Id).text();
              var total = parseInt(cCount.substring(0,cCount.indexOf(" ")))+1;
              jQuery("#commentCount"+Id).text(total.toString()+' Comments');
            }
            jQuery("#commentCont"+Id).addClass("has-success");
            jQuery("#comment"+Id).addClass("form-control-success");
            setTimeout((function(){jQuery("#commentCont"+Id).removeClass("has-danger").removeClass("form-control-danger");
                jQuery("#commentCont"+Id).removeClass("has-success").removeClass("form-control-success");}),3000);
        });
      }else{
        jQuery("#commentCont"+Id).addClass("has-danger");
        jQuery("#comment"+Id).addClass("form-control-danger");

      }
     });
}
function postTopic(){
     jQuery(document).ready(function(){
        var com = jQuery("#postText").val();
        if(!com == ""){
          jQuery.post("ajax/postTopic.php",{ topicContents : com },
          function(data, status){
            if(status == 'success'){
              console.log(data);
              if(data == 'success'){
                    jQuery("#postCont").removeClass("has-danger").addClass("has-success");
                    jQuery("#postText").removeClass("form-control-danger").addClass("form-control-success");
                    jQuery("#result").html('<h6 class="text-success">Topic Posted Successfully</h6>');
                    setTimeout((function(){
                        jQuery("#postText").val("");
                        jQuery("#postCont").removeClass("has-success");
                        jQuery("#postText").removeClass("form-control-success");
                        jQuery("#result").empty();
                      }),3000);
                    }
                    else if(data =='failure DB'){
                      jQuery("#result").html('<h6 class="text-danger"><strong>Failed!</strong>DB Error</h6>');
                    }
            }
            else{
                jQuery("#result").html('<h6 class="text-danger">Failed to post Reply</h6>');
                jQuery("#postCont").addClass("has-danger");
                jQuery("#postText").addClass("form-control-danger");
              }
        });
      }else{
        jQuery("#postCont").addClass("has-danger");
        jQuery("#postText").addClass("form-control-danger");
        jQuery("#result").html('<h6 class="text-danger">Please Enter Topic Contents</h6>');
        setTimeout((function(){
            jQuery("#postCont").removeClass("has-danger");
            jQuery("#postText").removeClass("form-control-danger");
            jQuery("#result").empty();
          }),3000);
      }
     });
}
function deleteC(Id){
    jQuery(document).ready(function(){
      jQuery.post("ajax/deleteTopic.php",{ topicID: Id },
      function(data, status){
        if(status == 'success'){
          console.log(status);
          console.log('\n'+data);
          console.log(Id);
          if(data == 'success'){
            jQuery("#deleteBtn"+Id).prop('disabled',true);
            jQuery("#statusP"+Id).removeClass("text-success").addClass("text-danger").text('Deleted');
            jQuery("#card"+Id).addClass("card-outline-danger");
            setTimeout((function(){
              jQuery("#card"+Id).remove();
            }),3000);
          }else{
            jQuery("#statusP"+Id).removeClass("text-success").addClass("text-danger").text('Failed to Delete :BE');
            jQuery("deleteBtn"+Id).prop('disabled',false);
          }
        }else{
          jQuery("#statusP"+Id).removeClass("text-success").addClass("text-danger").text('Failed to Delete: XHR');
          jQuery("deleteBtn"+Id).prop('disabled',false);
        }
        setTimeout((function(){
          jQuery("#statusP"+Id).remove();
        }),3000);
      });
    });
}
