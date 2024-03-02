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
        <h1>Add student</a></h1>
          <span class="success" style="color:green; margin-top:10px; margin-bottom: 10px;"></span>
        <form id="ajaxform">
            <div class="form-group">
                <label>First name:</label>
                <input type="text" name="firstName" class="form-control" placeholder="Enter first name" required="">
            </div>

            <div class="form-group">
                <label>Last name:</label>
                <input type="text" name="lastName" class="form-control" placeholder="Enter last name" required="">
            </div>

            <div class="form-group">
                <strong>Student number:</strong>
                <input type="text" name="studentNumber" class="form-control" placeholder="Enter student number" required="">
            </div>
            <div class="form-group">
                <strong>Faculty:</strong>
                <input type="text" name="faculty" class="form-control" placeholder="Enter faculty" required="">
            </div>
            <div class="form-group">
                <label>Department:</label>
                <input type="text" name="department" class="form-control" placeholder="Enter department" required="">
            </div>
            <div class="form-group">
                <label>Year of study:</label>
                <input type="text" name="yearofstudy" class="form-control" placeholder="Enter year" required="">
            </div>
            <div class="form-group">
                <button class="btn btn-success save-data">Add student</button>
            </div>
        </form>
    </div>
</body>

<div style="margin-left:200px"> Would you like to see the student table with your changes included?  <a href="http://xmlhw.hu/xslt">Click here!</a><div>
<div> You can also modify a timetable node by clicking <a href="http://xmlhw.hu/modifynode">here</a> or delete a student <a href="http://xmlhw.hu/deletestudent">here</a>.<div>

</html>

<script>

  $(".save-data").click(function(event){
    event.preventDefault();

      let firstName = $("input[name=firstName]").val();
      let lastName = $("input[name=lastName]").val();
      let studentNumber = $("input[name=studentNumber]").val();
      let faculty = $("input[name=faculty]").val();
      let department = $("input[name=department]").val();
      let yearofstudy = $("input[name=yearofstudy]").val();

      $.ajax({
        url: "http://xmlhw.hu/api/request/addStudent",
        type:"POST",
        data:{
            firstName:firstName,
            lastName:lastName,
            studentNumber:studentNumber,
            faculty:faculty,
            department:department,
            yearofstudy:yearofstudy,
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