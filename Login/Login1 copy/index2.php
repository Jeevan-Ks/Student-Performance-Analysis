<?php 
include "config2.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Student Registration form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="nav.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Bootstrap JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	

	<?php 
	$error_message = "";$success_message = "";

	// Register user
	if(isset($_POST['btnsignup'])){
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$confirmpassword = trim($_POST['confirmpassword']);

		$isValid = true;

		// Check fields are empty or not
		if($fname == '' || $lname == '' || $email == '' || $password == '' || $confirmpassword == ''){
			$isValid = false;
			$error_message = "Please fill all fields.";
		}

		// Check if confirm password matching or not
		if($isValid && ($password != $confirmpassword) ){
			$isValid = false;
			$error_message = "Confirm password not matching.";
		}

		// Check if Email-ID is valid or not
		if ($isValid && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
		  	$isValid = false;
		  	$error_message = "Invalid Email-ID.";
		}

		if($isValid){

			// Check if Email-ID already exists
			$stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$result = $stmt->get_result();
			$stmt->close();
			if($result->num_rows > 0){
				$isValid = false;
				$error_message = "Email-ID is already existed.";
			}
			
		}

		// Insert records
		if($isValid){
			$insertSQL = "INSERT INTO users(fname,lname,email,password ) values(?,?,?,?)";
			$stmt = $con->prepare($insertSQL);
			$stmt->bind_param("ssss",$fname,$lname,$email,$password);
			$stmt->execute();
			$stmt->close();

			$success_message = "Account created successfully.";
		}
	}
	?>
</head>
<body>
	<div>
	<nav>
        <div class="nav-content">
            <div class="logo"><a href="dashboard.php">Student's Dash</a></div>
            <ul class="nav-links">
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </nav>
	</div>
	<div class='container'>
		<div class='row' style="padding:7%">
			<div class='col-md-12'>
				<h2></h2>
			</div>

			<div class='col-md-6' >
					
				<form method='post' action=''>

					<h1>Registration</h1>
					<?php 
					// Display Error message
					if(!empty($error_message)){
					?>
						<div class="alert alert-danger">
						  	<strong>Error!</strong> <?= $error_message ?>
						</div>

					<?php
					}
					?>

					<?php 
					// Display Success message
					if(!empty($success_message)){
					?>
						<div class="alert alert-success">
						  	<strong>Success!</strong> <?= $success_message ?>
						</div>

					<?php
					}
					?>
				
					<div class="form-group">
					    <label for="fname">First Name:</label>
					    <input type="text" class="form-control" name="fname" id="fname" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="lname">Last Name:</label>
					    <input type="text" class="form-control" name="lname" id="lname" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="email">Email address:</label>
					    <input type="email" class="form-control" name="email" id="email" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="password">Password:</label>
					    <input type="password" class="form-control" name="password" id="password" required="required" maxlength="80">
					</div>
					<div class="form-group">
					    <label for="pwd">Confirm Password:</label>
					    <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" required="required" maxlength="80">
					</div>
					
					<button type="submit" name="btnsignup" class="btn btn-default">Submit</button>
				</form>
			</div>
			
			
		</div>
	</div>
	<script>
        let nav = document.querySelector("nav");
        window.onscroll = function () {
            if (document.documentElement.scrollTop > 20) {
                nav.classList.add("sticky");
            } else {
                nav.classList.remove("sticky");
            }
        }
    </script>
</body>
</html>