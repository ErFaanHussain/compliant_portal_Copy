function fillCourse(){
  var deptId = $('#depttSelect').val();
  console.log(deptId);
  jQuery.post("course.php",{ DeptID : deptId },
        function(data,status){
          if(status == 'success'){
            console.log(data);
            if(data[0] === 'success'){
              var select = $('#courseSelect');
              select.html('<option selected value="">--Select Course--</option>').removeClass("form-control-danger").parent().removeClass("has-danger");
              $('#courseStatus').text('');
                for (var i=1; i<data.length; i++) {
                   select.append('<option value="' + data[i].courseID + '">' + data[i].courseName + '</option>');
                } 
            }
            else if(data[0] === 'no course'){
              $('#courseSelect').html('<option selected value="">--Select Course--</option>').addClass("form-control-danger").parent().addClass("has-danger");
              $('#courseStatus').addClass('text-danger').text('No Course added for selected department');
            }
            
          }
          else{
            console.log('XHR failed');
          }
        
    }, "json");
}


// courseSelect