<!DOCTYPE html>
<html>
<head>
    <title>XML Operations</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Delete student</a></h1>
          <span class="success" style="color:green; margin-top:10px; margin-bottom: 10px;"></span>
        <form id="ajaxform">
            <div class="form-group">
                <strong>Student number:</strong>
                <input type="text" name="studentNumber" class="form-control" placeholder="Enter student number" required="">
            </div>
            <button class="btn btn-success save-data">Delete student</button>
        </form>
    </div>
</body>

<br><div style="margin-left:200px"> Would you like to see the student table with your changes included? <a href="http://xmlhw.hu/xslt">Click here!</a><div>
<div> You can also modify a timetable node by clicking <a href="http://xmlhw.hu/modifynode">here</a> or add a student <a href="http://xmlhw.hu/addstudent">here</a>.<div>

</html>

<script>

  $(".save-data").click(function(event){
    event.preventDefault();

      let studentNumber = $("input[name=studentNumber]").val();

      $.ajax({
        url: "http://xmlhw.hu/api/request/deleteStudent",
        type:"POST",
        data:{
            studentNumber:studentNumber
        },
        success:function(response){
          console.log(response);
          if(response) {
            $('.success').text(response.message);
          }
        },
       });
  });
</script>