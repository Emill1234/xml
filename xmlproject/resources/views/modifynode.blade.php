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
        <h1>Change node information in XML timetable</a></h1>
          <span class="success" style="color:green; margin-top:10px; margin-bottom: 10px;"></span>
        <form id="ajaxform">
            <div class="form-group">
                <label>Department:</label>
                <input type="text" name="department" class="form-control" placeholder="Enter department" required="">
            </div>

            <div class="form-group">
                <label>Year of study:</label>
                <input type="text" name="yearofstudy" class="form-control" placeholder="Enter year" required="">
            </div>

            <div class="form-group">
                <strong>Day:</strong>
                <input type="text" name="dayName" class="form-control" placeholder="Enter day" required="">
            </div>
            <div class="form-group">
                <strong>Subject name:</strong>
                <input type="text" name="subjectName" class="form-control" placeholder="Enter subject name" required="">
            </div>
            <div class="form-group">
                <strong>Choose class type:</strong><br>
                <input type="radio" class="classType" name="classType" value="lecture">
                <label for="lecture" style="font-weight:normal;">Lecture</label><br>
                <input type="radio" class="classType" name="classType" value="lab">
                <label for="lab" style="font-weight:normal;">Lab</label>
            </div>
            <div class="form-group">
                <strong>What data you like to modify from this lecture/lab?</strong><br>
                <input type="radio" class="nodeToModify" name="nodeToModify" value="subjectName">
                <label for="subjectName" style="font-weight:normal;">Subject name</label><br>
                <input type="radio" class="nodeToModify" name="nodeToModify" value="teacher">
                <label for="teacher" style="font-weight:normal;">Teacher</label><br>
                <input type="radio" class="nodeToModify" name="nodeToModify" value="startTime">
                <label for="startTime" style="font-weight: normal;">Start time</label><br>
                <input type="radio" class="nodeToModify" name="nodeToModify" value="endTime">
                <label for="endTime" style="font-weight: normal;">End time</label><br>
            </div>
            <div class="form-group">
                <strong>Enter new value for chosen data:</strong>
                <input type="text" name="modification" class="form-control" placeholder="Enter text" required="">
            </div>
            <div class="form-group">
                <button class="btn btn-success save-data">Modify timetable</button>
            </div>
        </form>
    </div>
</body>

<div style="margin-left:200px"> Would you like to see the timetable with your changes included?  <a href="http://xmlhw.hu/xslt">Click here!</a><div>
<div> You can also add a student by clicking <a href="http://xmlhw.hu/addstudent">here</a>.<div>

</html>

<script>

  $(".save-data").click(function(event){
    event.preventDefault();

      let department = $("input[name=department]").val();
      let yearofstudy = $("input[name=yearofstudy]").val();
      let dayName = $("input[name=dayName]").val();
      let classType = $(".classType:checked").val();
      let subjectName = $("input[name=subjectName]").val();
      let nodeToModify = $(".nodeToModify:checked").val();
      let modification = $("input[name=modification]").val();

      $.ajax({
        url: "http://xmlhw.hu/api/request/modifyNode",
        type:"POST",
        data:{
          department:department,
          yearofstudy:yearofstudy,
          dayName:dayName,
          classType:classType,
          subjectName:subjectName,
          nodeToModify:nodeToModify,
          modification:modification
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