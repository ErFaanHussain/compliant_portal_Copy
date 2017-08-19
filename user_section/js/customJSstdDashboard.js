$(document).ready(function(){
    $("#dashboardLink").addClass("active");
        var validator1 = $( "#followUpForm1" ).validate( {
        rules: {
          followUpText1: {
            required: true,
            maxlength: 300
          }
        },
        messages: {
          followUpText1: {
            required: "Please enter Follow Up contents",
            maxlength: "Follow Up must be less than 300 characters"
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
         $("#followUpModal").on('hide.bs.modal', function(e){
          validator1.resetForm();
          $('#followUpCont').removeClass("has-success has-danger");
          $('#followUpText').removeClass("form-control-danger form-control-success");
  });
});
function resolveC(Id){
  	jQuery.post("resolve.php",{ ComptID: Id },
  		function(data, status){
   		console.log(Id);
	    if(status == 'success'){
	    	  console.log(status);
	     	  console.log('\n'+data);
	     	  var stat = data["status"];
	     	  console.log(stat);
	     		 if(stat == 'success'){
	        		jQuery("#resolveBtn"+Id).prop('disabled',true);
              jQuery("#resolveBtnMob"+Id).prop('disabled',true);
	        		jQuery("#statusP"+Id).removeClass("text-danger").addClass("text-primary").text('| Resolved');
	        		jQuery("#publishResult"+Id).html('<h6 class="text-primary mb-0">Marked Resolved</h6>');
	        		jQuery("#followUp"+Id).prop('disabled',true);
              jQuery("#followUpMob"+Id).prop('disabled',true);
              jQuery("#Card"+Id).removeClass("bs-callout-success").addClass("bs-callout bs-callout-primary");

	      		}else{
	        		jQuery("#publishResult"+Id).html('<h6 class="text-danger">Failed to Mark Resolved</h6>');
	        		jQuery("resolveBtn"+Id).prop('disabled',false);
	      		}
	    	}else{
	      		jQuery("#publishResult"+Id).html('<h6 class="text-danger">Failed to Mark Resolved</h6>');
	      		jQuery("resolveBtn"+Id).prop('disabled',false);
	    	}
		});
		setTimeout((function(){
    	jQuery("#publishResult"+Id).remove();
  		}),3000);
}
        // Resolve Complaint AJAX XHR END

function followUp(cId){
  var fUpModal = $("#followUpModal");
  fUpModal.find('.modal-title').text('Add Follow-Up');
  fUpModal.modal('show');
  $("#followUpText").val("");
  console.log("follow up button clicked");
  $("#saveFollowUp").data("comptId",cId);
  // $("#followUpModal").on('hidden.bs.modal',function(){
  //   console.log('follow up function stopped');
  //   res = 'stop';
  // });
  return;
}
function saveFollowUpN(){
    var cId = $("#saveFollowUp").data("comptId");
    console.log("save follow up called for: "+cId);
    var followUp = $("#followUpText").val();
    console.log(followUp);
    var form = $('#followUpForm1');
    if(!form.valid()){
      $("#mesFollowUp").text('');
      // $("#followUpCont").addClass("has-danger");
      // $("#followUpText").addClass("form-control-danger");
      // $("#resFollowUp").addClass("text-danger").text('Sorry, we don\'t accept empty follow ups');
      // setTimeout((function(){
      //                 $("#followUpCont").removeClass("has-danger");
      //                 $("#followUpText").removeClass("form-control-danger");
      //                 $("#resFollowUp").removeClass("text-success text-danger").text('');
      //               }),3000);
          }
    else
    {
      $("#followUpCont").removeClass("has-danger").addClass("has-success");
      $("#followUpText").removeClass("form-control-danger").addClass("form-control-success");
      $("#resFollowUp").text('');
      $("#saveFollowUp").prop('disabled',true);
      jQuery.post("postFollowUp.php",
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
                  // $("#followUp"+cId).prop('disabled',true);
                  $("#followUpCard"+cId).append('<p class="card-text mb-0">'+followUp+'<small class="float-right">'+timeStamp+'</small><footer class="blockquote-footer"><cite>You</cite></footer></p>');                
                  setTimeout((function(){
                      $("#followUpCont").removeClass("has-success");
                      $("#followUpText").removeClass("form-control-success");
                      $("#mesFollowUp").removeClass("text-success text-danger").text('');
                      $("#followUpText").val("");
                      $("#saveFollowUp").prop('disabled',false);
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
                      $("#saveFollowUp").prop('disabled',false)
                    }),3000);
                }
        }
        else
        {
          console.log('XHR Returned Null');
          $("#mesFollowUp").removeClass("text-success").addClass("text-danger").text('Failed to Post Follow-Up: XHR');
          $("#saveFollowUp").prop('disabled',false)
        }
      });
    }
}


function hideColl(id){
  // $("#collapse"+id).removeClass("collapse show").addClass("collapse");
$("#collapse"+id).collapse('toggle');
}

