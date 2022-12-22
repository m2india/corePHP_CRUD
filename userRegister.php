<!DOCTYPE html>
<html>
<head>
	<title>Insert data in MySQL database using Ajax</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container mt-5">

<a class="btn btn-warning btn-sm" href="index.php">Home</a>

<button type="button" class="btn btn-success btn-sm" id="register">Register</button> <button type="button" class="btn btn-success btn-sm" id="login">Login</button>

<br>

    <div class="alert alert-success alert-dismissible" id="success" style="display:none;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    </div>
    <div class="alert alert-danger alert-dismissible" id="error" style="display:none;">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    </div>


<br>
<br>

    <!-- User Register form -->
    <form name="userregisterForm" id="userregisterForm" >
      <div class="form-group">
        <label>Name</label>
        <input type="text" class="form-control" name="name" id="name">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="email" id="email">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password" id="password">
      </div>
      <div class="form-group">
        <label>Gender</label>
        <input type="radio" class="" value="male" name="gender" id="gender"> Male /
        <input type="radio" class="" value="female" name="gender" id="gender"> Female
      </div>
      <input type="submit" name="send" value="Send" class="btn btn-primary btn-block">
    </form>

    <!-- User Login form -->

    <form id="loginForm" name="loginForm"  style="display:none;">
      <div class="form-group">
        <label>Email</label>
        <input type="email" class="form-control" name="logemail" id="logemail">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="logpassword" id="logpassword">
      </div>
      <input type="submit" name="loginButton" value="Login" class="btn btn-primary btn-block">
    </form>

</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.min.js"></script> -->

<script>
    $(document).ready(function(){

      $("input").on("keypress", function(e) {    
          if (e.which === 32 && !this.value.length)
          e.preventDefault();
      });

      	$('#login').on('click', function() {
		      $("#loginForm").show();
		      $("#userregisterForm").hide();
	      });

        $('#register').on('click', function() {
          $("#userregisterForm").show();
          $("#loginForm").hide();
        });

      $("form[name='userregisterForm']").validate({

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
                type: 1,
                name: $("#name").val().trim(),
                email: $("#email").val().trim(),
                password: $("#password").val().trim(),
                gender : $("[name='gender']:checked").val().trim()
              };
            
            $.ajax({
              url: "save.php",
              type: "POST",
              data: formData,
				      cache: false,
				      success: function(dataResult){
              // console.log(dataResult);

                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                  $("#butsave").removeAttr("disabled");
                  //$('#contactForm').find('input:text').val('');
                  $('#error').html('Email ID already exists !').hide();
                  $("#success").show();
                  $('#success').html('Registration successful !'); 

                  setTimeout(function() {
                          window.location = 'index.php';
                      }, 2000);						
                }
                else if(dataResult.statusCode==201){
                  $("#error").show();
                  $('#error').html('Email ID already exists !');

                  // setTimeout(function() {
                  //         window.location = 'userRegister.php';
                  //     }, 1000);
                }
				      }
		        });
        }
      });

      $("form[name='loginForm']").validate({

       

        rules: {
          logpassword: "required",

          logemail: {
            required: true,
            email: true
          },
        },
          // Specify validation error messages
        messages: {
          logemail: {
            required: "Please enter your email",
            minlength: "Please enter a valid email address"
          },
        },
        submitHandler: function(form) {

        //  var email = $("#logemail").val();
        //  console.log("email" ,email);

              var formData2 = {
                type: 2,
                email: $("#logemail").val().trim(),
                password: $("#logpassword").val().trim(),
              };

               console.log(formData2);
            
                  $.ajax({
                  url: "save.php",
                  type: "POST",
                  data: formData2,
                  cache: false,
                  success: function(dataResult){
                  // console.log(dataResult);

                    var dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode==200){
                      $("#success").show();
                      $('#success').html('Login Successful !'); 

                      setTimeout(function() {
                              window.location = 'userEditRegister.php';
                          }, 1000);						
                    }
                    else if(dataResult.statusCode==201){
                      $("#error").show();
                      $('#error').html('Invalid credentials !');
                    }
                  }
                });
                
        }

      });


      
    });    
  </script>
  
</body>
</html> 