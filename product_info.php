<?php
	session_start();

	if (!isset($_SESSION['uname'])) header("location:index.php");

	require 'dbconnect.php';

	$id = $_GET['id'];

	$query = "SELECT * FROM products WHERE id='$id'";
	$result = mysqli_query($dbc, $query);

	while ($row = mysqli_fetch_array($result)){
		echo '
			<table>
				<tr>
					<td rowspan="6"><figure><img src="'.$row['slika'].'" height="200px" width="200px"></figure></td>
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
					<td>Dodao:</td>
					<td><input type="txt" value="'.$row['dodao'].'" disabled></td>
				</tr>
				<tr>
					<td>Datum:</td>
					<td><input type="txt" value="'.date("d.m.Y", strtotime($row['datum'])).'." disabled></td>
				</tr>
				<tr>
					<td colspan="3"><input id="close" type="button" value="Ok"></td>
				</tr>
			</table>
		';
	}

	$content = '
		document.getElementById("close").onclick = function (){
				var modal = document.getElementById("modal");
				modal.style.display = "none";
			}
	';

	$fp = fopen("close.js","wb");
	fwrite($fp,$content);
	fclose($fp);

	mysqli_close($dbc);
?>