<?php
	session_start();
	if (!isset($_SESSION['uname']) || !$_SESSION['admin']) header("location:index.php");
	require 'dbconnect.php';
	
	//check user session
	$uname = $_POST['uname'];
	if ($uname != $_SESSION['uname']) header("location:logout.php");

	$picture = $_POST['picture'];
	$number = $_POST['number'];
	$product = $_POST['product'];
	$category = $_POST['category'];
	$description = $_POST['description'];
	$date = date("Y-m-d", strtotime(str_replace(".","-",$_POST['date'])));

	//check insertion ID
	$query = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'products' AND table_schema = DATABASE()";
	$result = mysqli_query($dbc,$query);
	$row = mysqli_fetch_array($result);

	if ($row[0] == $number){

		$sql = "INSERT INTO products (naziv, kategorija, opis, dodao, datum, slika) values (?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_stmt_init($dbc);

		if (mysqli_stmt_prepare($stmt, $sql)){

			mysqli_stmt_bind_param($stmt, 'ssssss', $product, $category, $description, $uname, $date, $picture);

			mysqli_stmt_execute($stmt);
		}
		echo false;
	} else {
		echo $row[0];
	}

	mysqli_close($dbc);
?>