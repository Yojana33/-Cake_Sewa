<?php
session_start();
include '../conect.php';


// check if the form has been submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Retrieve the form data
	$username = mysqli_real_escape_string($conn, $_POST["username"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$cpassword = mysqli_real_escape_string($conn, $_POST["cpassword"]);
	$number = mysqli_real_escape_string($conn, $_POST["number"]);
	$address = mysqli_real_escape_string($conn, $_POST["address"]);

	// Check if the passwords match
	if ($password != $cpassword) {
		echo "Passwords do not match.";
		exit();
	}

	// Hash the password
	$password = hash("sha256", $password);

	// Check if the username already exists
	$check_username_query = "SELECT * FROM users WHERE username = '$username'";
	$check_username_result = mysqli_query($conn, $check_username_query);
	if (mysqli_num_rows($check_username_result) > 0) {
		echo "Username already exists. Please choose a different username.";
		exit();
	}

	// Prepare SQL query
	$sql = "INSERT INTO users (username, password, email, number, address) VALUES ('$username', '$password', '$email', '$number', '$address')";

	// Execute SQL query
	if (mysqli_query($conn, $sql)) {
		// Registration successful
		$_SESSION["username"] = $username;
		header("location: login.php");
	} else {
		// Registration unsuccessful
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
}

// Close connection
mysqli_close($conn);
?>



<!DOCTYPE html>
<html>

<head>
	<title>User Registration Form</title>
	<style>
		body {
			background-image: url('../images/background.png');
			background-repeat: no-repeat;
			background-size: cover;
			font-family: Arial, sans-serif;
		}

		.container {
			width: 300px;
			margin: 0 auto;
			margin-top: 100px;
			background-color: #fff;
			padding: 50px;
			border-radius: 10px;
			box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
		}

		.container h2 {
			text-align: center;
			margin-bottom: 20px;
		}

		.container input {
			width: 100%;
			padding: 10px;
			margin-bottom: 10px;
			border: 1px solid #432109;
			border-radius: 3px;
		}

		.container select {
			width: 100%;
			padding: 10px;
			margin-bottom: 10px;
			border: 1px solid #ccc;
			border-radius: 3px;
		}

		.container button {
			width: 100%;
			padding: 10px;
			background-color: #432109;
			color: #fff;
			border: none;
			border-radius: 3px;
			cursor: pointer;
		}
	</style>
</head>

<body>
	<div class="container">
		<h2>Registration Form</h2>
		<form method="post" action="">
			<label for="username">Username</label>
			<input type="text" id="username" name="username" required>

			<label for="email">Email</label>
			<input type="email" id="email" name="email" required>

			<label for="password">Password</label>
			<input type="password" id="password" name="password" required>

			<label for="cpassword"> Confirm Password</label>
			<input type="password" id="cpassword" name="cpassword" required>

			
			<label for="number">Number</label>
			<input type="text" id="number" name="number" required>

			<label for="address">Address</label>
			<input type="text" id="address" name="address" required>
			<br>
			<br>
			<button type="submit">Submit</button>

		</form>
		<br>

		<p>Already have an account? <a href="login.php">Login</a></p>

	</div>
</body>

</html>