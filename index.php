<?php
	session_start();
	if (isset($_SESSION['uname'])) header("location:view_product.php");
?>
<!DOCTYPE html>
<html lang="hr">
	<header>
		<meta charset="utf-8">
		<meta name="keywords" content="webshop">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Webshop</title>
	</header>

	<?php
		if (isset($_GET['msg'])) $msg = str_replace("_"," ",$_GET['msg']);
		else $msg = "";
	?>
	<body>
		<div id="wrapper">
			<h1>Danube webshop</h1>
			<table>
				<form  action="view_product.php" method="POST">
					<tr><td colspan="2"><span id="message"><?php echo $msg; ?></span></td></tr>
					<tr><td>Username:</td><td><input id="username" name="username" type="text"></td></tr>
					<tr><td>Password:</td><td><input id="password" name="password" type="password"></td></tr>
					<tr><td colspan="2"><input id="login" type="submit" value="Login"></td></tr>
				</form>
			</table>	
		<div>

		<script type="text/javascript">

			document.getElementById("login").onclick = function (event){

				var username = document.getElementById("username").value;
				var password = document.getElementById("password").value;

				if (username == "" || password == "") {
					document.getElementById("message").innerHTML = "Korisničko ime i lozinka su obavezna polja.";
				} else {
					var data = "username=" + username + "&password=" + password;
					var request = new XMLHttpRequest();

					request.onreadystatechange = function() {
            			if (this.readyState == 4 && this.status == 200) {
                			//document.getElementById("message").innerHTML = this.responseText;
                			if (this.responseText) window.location.replace("view_product.php");
                			else document.getElementById("message").innerHTML = "Korisničko ime ili lozinka su neispravni.";
            			}
        			}; 

        			request.open("POST", "login.php", true);
        			request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        			request.send(data);
				}

				event.preventDefault();
			}
		</script>
	</body>
</html>

