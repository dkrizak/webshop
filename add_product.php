<?php
	session_start();

	if (!isset($_SESSION['uname']) || !$_SESSION['admin']) header("location:index.php");

	require 'dbconnect.php';
?>

<!DOCTYPE html>
<html lang="hr">
	<header>
		<meta charset="utf-8">
		<meta name="keywords" content="webshop">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Webshop</title>
	</header>

	<body>

		<header>
			<div id="user"> 
				<form action="cart.php">
	   				<input id="usrbtn" type="submit" value="Wellcome, <?php echo $_SESSION['uname']; ?>" />
				</form>
			</div>

			<div id="logout">
				<form action="logout.php">
	   				<input id="logoutbtn" type="submit" value="Logout" />
				</form>
			</div>
		</header>

		<h1>Add new article</h1>

		<div id="wrapper">

			<table id="add_product">
				<tr>
					<td>Picture:</td>
					<td><input id="picture" type="txt"><br><span id="picturemsg"></span></td>
				</tr>
				<tr>
					<td>Product number:</td>
					<?php 
						$query = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = 'products' AND table_schema = DATABASE()";
						$result = mysqli_query($dbc,$query);
						$row = mysqli_fetch_array($result);
				        echo '<td><input id="number" type="txt" value="'.$row[0].'" disabled></td>'; 
				    ?>				
				</tr>
				<tr>
					<td>Product name:</td>
					<td><input id="product" type="txt"><br><span id="productmsg"></span></td>
				</tr>
				<tr>
					<td>Product category:</td>
					<td>
						<select id="category">
							<option value="Smartphone">Smartphone</option>
							<option value="Laptop">Laptop</option>
							<option value="TV">TV</option>
							<option value="Headphones">Headphones</option>
							<option value="Printer">Printer</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>Product description:</td>
					<td><textarea id="description"></textarea><br><span id="descriptionmsg"></span></td>
				</tr>
				<tr>
					<td>Added by:</td>
					<?php echo '<td><input id="uname" type="txt" disabled value="'.$_SESSION['uname'].'"></td>';?>		
				</tr>
				<tr>
					<td>Date Added:</td>
					<?php echo '<td><input id="date" type="txt" disabled value="'.date("d.m.Y").'"></td>';
						mysqli_close($dbc);
					?>		
				</tr>
				<tr>
					<td><input id="cancel" type="button" value="Cancel"></td>
					<td><input id="save" type="submit" value="Save"></td>
				</tr>
			</table>
		</div>

		<script type="text/javascript">
			document.getElementById("cancel").onclick = function (event){
				window.location = "view_product.php";
			}

			function isURL(str) {
  				var pattern = new RegExp('^(https?:\\/\\/)?'+ // protocol
  				'((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.?)+[a-z]{2,}|'+ // domain name
				'((\\d{1,3}\\.){3}\\d{1,3}))'+ // OR ip (v4) address
				'(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*'+ // port and path
				'(\\?[;&a-z\\d%_.~+=-]*)?'+ // query string
				'(\\#[-a-z\\d_]*)?$','i'); // fragment locator
  				return pattern.test(str);
  			}

			document.getElementById("save").onclick = function (event){
				var send = 1;

				var picture = document.getElementById("picture");
				if (isURL(picture.value) || picture.value == "") {
					send = 0;
					picture.style.border = "1px solid red";
					document.getElementById("picturemsg").innerHTML = "Uneseni link nije ispravan.";
				} else {
					picture.style.border = "";
					document.getElementById("picturemsg").innerHTML = "";
				}

				var product = document.getElementById("product");
				if (product.value.length < 1) {
					send = 0;
					product.style.border = "1px solid red";
					document.getElementById("productmsg").innerHTML = "Molimo unesite naziv artikla.";
				} else {
					product.style.border = "";
					document.getElementById("productmsg").innerHTML = "";
				}

				var description = document.getElementById("description");
				if (description.value.length < 1) {
					send = 0;
					description.style.border = "1px solid red";
					document.getElementById("descriptionmsg").innerHTML = "Opis mora biti minimalne duljine jednog znaka.";
				} else {
					description.style.border = "";
					document.getElementById("descriptionmsg").innerHTML = "";
				}

				if (send){
					picture = picture.value;
					var number = document.getElementById("number").value;
					product = product.value;
					var category = document.getElementById("category").value;
					description = description.value;
					var uname = document.getElementById("uname").value;
					var date = document.getElementById("date").value;

					var data = "picture=" + picture + "&number=" + number + "&product=" + product + "&category=" + category + 
					"&description=" + description + "&uname=" + uname + "&date=" + date;
					var request = new XMLHttpRequest();

					request.onreadystatechange = function() {
            			if (this.readyState == 4 && this.status == 200) {
                			if (this.responseText) {
                				document.getElementById("number").value = this.responseText;
                				alert("Došlo je do promjene ID-a, pokušajte ponovno.");	
                			} else {
                				window.location.replace("view_product.php");
                			}  
            			}
        			}; 

        			request.open("POST", "check_add_product.php", true);
        			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        			request.send(data);

				}

			}
		</script>
	</body>

</html>