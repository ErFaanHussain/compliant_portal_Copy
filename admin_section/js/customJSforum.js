$(document).ready(function(){
  $("#forumLink").addClass("active");
});
function postComment(Id){
     jQuery(document).ready(function(){
        var com = jQuery("#comment"+Id).val();
        console.log(com);
        if(!com == ""){
          jQuery.post("ajax/postComment.php",{ topicId: Id , comment: com },
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
