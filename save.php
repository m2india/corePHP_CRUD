<?php

	include 'database.php';


	session_start();
	if($_POST['type']==1){
        $name=$_POST['name'];
		$email=$_POST['email'];
		$gender=$_POST['gender'];
		$password=$_POST['password'];

		// print_r($_POST);
		// exit();


		
		$duplicate=mysqli_query($conn,"select * from crud where email='$email'");
		if (mysqli_num_rows($duplicate)>0)
		{
			echo json_encode(array("statusCode"=>201));
		}

		else{
			$sql = "INSERT INTO `crud`( `name`, `email`, `gender`, `password`) 
			VALUES ('$name','$email','$gender', '$password')";
			if (mysqli_query($conn, $sql)) {
				echo json_encode(array("statusCode"=>200));
			} 
			else {
				echo json_encode(array("statusCode"=>201));
			}
		}
		mysqli_close($conn);
	}
	
	if($_POST['type']==2){

		$email=$_POST['email'];
		$password=$_POST['password'];

		//print_r($_POST);
		//exit();


		$check=mysqli_query($conn,"select * from crud where email='$email' and password='$password'");
		if (mysqli_num_rows($check)>0)
		{
			$_SESSION['email']=$email;
			echo json_encode(array("statusCode"=>200));
		}
		else{
			echo json_encode(array("statusCode"=>201));
		}
		mysqli_close($conn);
	}

	if($_POST['type']==3){

		date_default_timezone_set('Asia/Kolkata');

		$id=$_POST['id'];
		$name=$_POST['name'];
		$email=$_POST['email'];
		$gender=$_POST['gender'];
		$password=$_POST['password'];
		$timestamp = date("Y-m-d H:i:s");


		$duplicate=mysqli_query($conn,"select * from crud where email ='$email' and id != $id " );

		if (mysqli_num_rows($duplicate) > 0)
		{
			echo json_encode(array("statusCode"=>201));
		}
		else
		{
			$sql = "UPDATE `crud` SET `name`='$name', `email`='$email', `gender`='$gender', `password`='$password', `updated_at`='$timestamp' WHERE id = $id";
			if (mysqli_query($conn, $sql)) {
				echo json_encode(array("statusCode"=>200));
			} 
			else {
				echo json_encode(array("statusCode"=>201));
			}
		}
		

		mysqli_close($conn);
	}


	if($_POST['type']==4){

		$id=$_POST['id'];

		$sql = "DELETE FROM `crud` WHERE id=$id";

		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
			echo json_encode(array("statusCode"=>201));
		}
		mysqli_close($conn);
	}
	


?>