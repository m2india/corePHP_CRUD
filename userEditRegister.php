<?php
include 'database.php';
session_start(); 
 if(!empty($_SESSION['email'])){
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Edit</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">

<!-- <button type="button" class="btn btn-success btn-sm" id="register">Register</button> <button type="button" class="btn btn-success btn-sm" id="login">Login</button> -->

<div class="alert alert-success alert-dismissible" id="success" style="display:none;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    </div>
    <div class="alert alert-danger alert-dismissible" id="error" style="display:none;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    </div>




<h4>Welcome : <?php echo $_SESSION['email']; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="logout.php">Logout</a></h4>

      <?php

			$result = mysqli_query($conn,"SELECT * FROM crud WHERE email = '".$_SESSION['email']."' ");

				while($row = mysqli_fetch_array($result)) {
			?> 

    <!-- User Edit Register form -->
    <form name="userEditRegisterForm" id="userEditRegisterForm" >
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php echo $row["name"]; ?>" >
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email" id="email" value="<?php echo $row["email"]; ?>" >
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="text" class="form-control" name="password" id="password" value="<?php echo $row["password"]; ?>" >
      </div>
      <div class="form-group">
        <label>Gender</label> 
        <input type="radio" name="gender" id="gender" <?=$row['gender']=="male" ? "checked" : "" ?> value="male"> Male /
        <input type="radio" name="gender" id="gender" <?=$row['gender']=="female" ? "checked" : "" ?> value="female"> Female
      </div>
      <input type="hidden" class="form-control" name="userId" id="userId" value="<?php echo $row["id"]; ?>" >
      <input type="submit" name="send" value="Send" class="btn btn-primary btn-block">
    </form>

    <br>

    <button class="btn btn-danger btn-block" onclick="deleteRow('delete',<?php echo $row['id'] ; ?>)">Delete</button>

    <?php
			}
		?>



</div>



<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script> -->

<script>
    $(document).ready(function(){

      $("input").on("keypress", function(e) {    
          if (e.which === 32 && !this.value.length)
          e.preventDefault();
      });

      $("form[name='userEditRegisterForm']").validate({

        // Define validation rules
        rules: {
          name: "required",
          email: "required",
          password: "required",
          gender: "required",

          name: {
            required: true
          },
          email: {
            required: true,
            email: true
          },
          password:{
            minlength: 6,
            maxlength: 30,
            required: true,  
          },
          gender: {
            required: true
          },
        },
          // Specify validation error messages
        messages: {
          name: "Please provide a valid name.",
          email: {
            required: "Please enter your email",
            minlength: "Please enter a valid email address"
          },
          password: {
            required: "Password is not strong enough"
          }
        },
        submitHandler: function(form) {
              var formData = {
                type: 3,
                id: $("#userId").val(),
                name: $("#name").val(),
                email: $("#email").val(),
                gender : $("[name='gender']:checked").val(),
                password: $("#password").val(),
              };
            
            $.ajax({
              url: "save.php",
              type: "POST",
              data: formData,
				      cache: false,
				      success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                  $("#butsave").removeAttr("disabled");
                  $("#success").show();
                  $('#success').html('User updated  !'); 

                  setTimeout(function() {
                          window.location = 'userEditRegister.php';
                      }, 2000);						
                }
                else if(dataResult.statusCode==201){
                  $("#error").show();
                  $('#error').html('Email ID already exists !');

                  setTimeout(function() {
                          window.location = 'userEditRegister.php';
                      }, 1000);
                }
				      }
		        });
        }
      });      
    }); 
    
    
    function deleteRow(id){

        var checkDelete =  confirm(' Are you sure you want to delete this users ? ');
        if(checkDelete == true){

                  var formData4 = {
                    type: 4,
                    id: $("#userId").val(),
                  };

              $.ajax({
                url: 'save.php',
                type: "POST",
                data: formData4,
                cache: false,

                success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                  setTimeout(function() {
                          window.location = 'logout.php';
                      }, 100);						
                }
                // else if(dataResult.statusCode==201){
                //   $("#error").show();
                //   $('#error').html('Email ID already exists !');
                // }
				      }
              });
        }else{
          return false;
        }

    }
  </script>
  


</body>
</html> 

<?php
}
else{
  header('Location: index.php');
  exit();
}
?>