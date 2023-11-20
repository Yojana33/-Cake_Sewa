<?php
include '../conect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$username = mysqli_real_escape_string($conn, $_POST["username"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);

	$password = hash("sha256", $password);

	$sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$user_type = $row['user_type'];

		session_start();
		$_SESSION["username"] = $row['username'];
		$_SESSION["user_id"] = $row['id'];
		$_SESSION["email"] = $row['email'];

		if ($user_type == "users") {
			header("location: ../customer/");
		} elseif ($user_type == "admin") {
			header("location:../admin/");
		} else {
			echo "Invalid user type.";
		}
	} else {
		// Login unsuccessful
		echo "Invalid username or password.";
	}
}

// Close connection
mysqli_close($conn);
?>




<!DOCTYPE html>
<html>

<head>
	<title>User Login Form</title>
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
			border-radius: 5px;
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
			border: 1px solid #ccc;
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
		<h2>User Login</h2>
		<form method="post" action="">
			<label for="username">Username</label>
			<input type="text" id="username" name="username" required>

			<label for="password">Password</label>
			<input type="password" id="password" name="password" required>


			<br>
			<button type="submit">Submit</button>
		</form>
		<br>
		<p>Don't have an account? <a href="register.php">Register</a></p>

	</div>
</body>

</html>