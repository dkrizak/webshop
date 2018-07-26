<?php
	session_start();
	if (!isset($_SESSION['uname'])) header("location:index.php");
	require 'dbconnect.php';
	
	$id = $_GET['id'];

	if (sizeof($_SESSION['cart']) > 0) {
		$notduplicate = 1;
		foreach ($_SESSION['cart'] as $id2) {
			if ($id == $id2) {

				if (isset($_SESSION['duplicates']["$id"])) $_SESSION['duplicates']["$id"]++;
				else $_SESSION['duplicates']["$id"] = 1;

				$newid = $id;
				for ($i=0; $i<$_SESSION['duplicates']["$id"]; $i++){
					$newid .= "-$id";
				}
				$_SESSION['cart'][] = $newid;
				$notduplicate = 0;
				break;
			}
		}
		if ($notduplicate) $_SESSION['cart'][] = $id;
	} else {
		$_SESSION['cart'][] = $id;
	}

	//rjesenje bez duplikata
	//$_SESSION['cart'][] = $_GET['id'];
	echo true;

	mysqli_close($dbc);
?>