<?php
	require 'dbconnect.php';
	session_start();

	$user = $_POST['username'];
	$pass = md5($_POST['password']);

	$sql = "SELECT user, password, admin FROM users WHERE user=? AND password=?";
	$stmt = mysqli_stmt_init($dbc);

	if (mysqli_stmt_prepare($stmt, $sql)){

		mysqli_stmt_bind_param($stmt, 'ss', $user, $pass);

		mysqli_stmt_execute($stmt);
		mysqli_stmt_store_result($stmt);

	}

	if (mysqli_stmt_num_rows($stmt) > 0){
		echo true;
		mysqli_stmt_bind_result($stmt, $username, $password, $admin);
		mysqli_stmt_fetch($stmt);

		$_SESSION['uname'] = $username;
		$_SESSION['admin'] = $admin;
		$_SESSION['cart'] = array();
								
	} else {
		echo false;
	}

	mysqli_close($dbc);
?>