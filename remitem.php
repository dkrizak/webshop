<?php
	session_start();

	if (!isset($_SESSION['uname'])) header("location:index.php");

	require 'dbconnect.php';

	$id = $_GET['id'];
	$cart = $_SESSION['cart'];

	$key = array_search($id, $cart);

	unset($_SESSION['cart'][$key]);

	echo true;

	mysqli_close($dbc);
?>