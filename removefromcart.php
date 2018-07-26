<?php
	session_start();

	if (!isset($_SESSION['uname'])) header("location:index.php");

	require 'dbconnect.php';

	$idrem = $_GET['id'];

	if (strpos($idrem, '-')){
		$tmp = explode('-', $idrem);
		$id = $tmp[0];
	} else $id = $idrem;

	$query = "SELECT * FROM products WHERE id='$id'";
	$result = mysqli_query($dbc, $query);

	while ($row = mysqli_fetch_array($result)){
		echo '
			<table>
				<tr>
					<td colspan="3"><label>Molimo vas potvrdite uklanjanje sljedećeg artikla iz vaše košarice:</label></td>
				</tr>
				<tr>
					<td rowspan="4"><figure><img src="'.$row['slika'].'" height="200px" width="200px"></figure></td>
					<td>Serijski broj:</td>
					<td><input type="txt" value="'.$row['id'].'" disabled></td>
				</tr>
				<tr>
					<td>Naziv artikla:</td>
					<td><input type="txt" value="'.$row['naziv'].'" disabled></td>
				</tr>
				<tr>
					<td>Kategorija:</td>
					<td><input type="txt" value="'.$row['kategorija'].'" disabled></td>
				</tr>
				<tr>
					<td>Opis:</td>
					<td><textarea disabled>'.$row['opis'].'</textarea></td>
				</tr>
				<tr>
					<td colspan="3"><input type="button" onclick="remitem(\''.$idrem.'\');" value="Ok"></td>
				</tr>
			</table>
		';
	}

	mysqli_close($dbc);
?>