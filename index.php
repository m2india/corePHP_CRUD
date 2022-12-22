<?php
include 'database.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Users List</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

</head>
<body>


<div class="container" style="margin-top:100px;">


<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="col-sm-6">
					<h2>Users List</h2>
				</div>
				<div class="col-sm-6">
					<a href="userRegister.php" class="btn btn-success" ><i class="material-icons"></i> <span>Register</span></a>
					<a href="userRegister.php" class="btn btn-danger" id="delete_multiple"><i class="material-icons"></i> <span>Login</span></a>						
				</div>
			</div>
		</div>
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>SL NO</th>
					<th>NAME</th>
					<th>EMAIL</th>
					<th>GENDER</th>
				</tr>
			</thead>
			<tbody>
			
			<?php
			$result = mysqli_query($conn,"SELECT * FROM crud WHERE status='0' ");
				$i=1;
				while($row = mysqli_fetch_array($result)) {
			?>
			<tr id="<?php echo $row["id"]; ?>">
					</td>
				<td><?php echo $i; ?></td>
				<td><?php echo ucfirst($row["name"]); ?></td>
				<td><?php echo strtolower($row["email"]); ?></td>
				<td><?php echo ucfirst($row["gender"]); ?></td>
			</tr>
			<?php
			$i++;
			}
			?>
			</tbody>
		</table>
		
	</div>
</div>
    

</div>


<script>
    $(document).ready(function(){


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
          phone: "required",
    
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
          phone: {
            required: true,
            minlength: 10,
            maxlength: 10,
            number: true
          }
        },


        messages: {
          name: "Please provide a valid name.",
          email: {
            required: "Please enter your email",
            minlength: "Please enter a valid email address"
          },
          phone: {
            required: "Please provide a phone number",
            minlength: "Phone number must be min 10 characters long",
            maxlength: "Phone number must not be more than 10 characters long"
          },
          password: {
            required: "Password is not strong enough"
          }
        },
        submitHandler: function(form) {
              var formData = {
                type: 1,
                name: $("#name").val(),
                email: $("#email").val(),
                password: $("#password").val(),
                phone: $("#phone").val(),
                gender: $("#gender").val(),
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
                  $("#success").show();
                  $('#success').html('Registration successful !'); 

                  setTimeout(function() {
                          window.location = 'index.php';
                      }, 5000);						
                }
                else if(dataResult.statusCode==201){
                  $("#error").show();
                  $('#error').html('Email ID already exists !');
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

        messages: {
          logemail: {
            required: "Please enter your email",
            minlength: "Please enter a valid email address"
          },
        },
        submitHandler: function(form) {

              var formData2 = {
                type: 2,
                email: $("#logemail").val(),
                password: $("#logpassword").val(),
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
                              window.location = 'dashboard.php';
                          }, 3000);						
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