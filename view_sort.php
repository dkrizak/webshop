<?php
	session_start();

	if (!isset($_SESSION['uname'])) header("location:index.php");
	if (!isset($_GET['sort']) xor $_GET['sort'] != "name" xor $_GET['sort'] != "category" xor $_GET['sort'] != "date") header("location:view_product.php");

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
	   				<input id="idbtn" type="submit" value="Wellcome, <?php echo $_SESSION['uname']; ?>" />
				</form>
			</div>

			<div id="logout">
				<form action="logout.php">
	   				<input id="logoutbtn" type="submit" value="Logout" />
				</form>
			</div>
		</header>

		<div id="wrapper">
			<div id="left">
				<?php if ($_SESSION['admin']) echo '<input type="button" id="add" value="Add new item">';?>
			</div>

			<div id="right">
				<table id="search">
					<form action="javascript:search();">
						<tr>
							<td colspan="2"><input id="search_imput" type="txt" placeholder="Search..." onkeyup="update()"></td>
						</tr>
						<tr>
							<td colspan="2">
								<select id="category">
									<option value="">Category list...</option>
									<?php
										$query = "SELECT kategorija FROM products GROUP BY kategorija";
										$result = mysqli_query($dbc, $query);
										
										while ($row = mysqli_fetch_array($result)){
											echo '<option value="'.$row['kategorija'].'">'.$row['kategorija'].'</option>';
										} 
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td><input id="clear" type="button" value="Clear"></td>
							<td><input id="find" type="button" disabled value="Search" onclick="search();"></td>
						</tr>
					</form>
				</table>
			</div>

			<div id="preview">
				<table id="previewtb">
					<tr>
						<th>Picture</th>
						<th><a href="view_sort.php?sort=name" id="name">Name</a></th>
						<th><a href="view_sort.php?sort=category" id="category">Category</a></th>
						<th><a href="view_sort.php?sort=date" id="date">Date</a></th>
						<th>Add</th>
					</tr>
					<?php
						$query = "SELECT COUNT(*) as max FROM (SELECT * FROM products) as tmp";
						$result = mysqli_query($dbc, $query);
						$row = mysqli_fetch_array($result);
						
						$max = $row['max'];
						$limit = 4;
						$counter = 0;
						$offset = 0;
						if (isset($_GET['page'])) $page = $_GET['page'];
						else $page = 1;
						$sort = $_GET['sort'];

						switch ($sort) {
							case 'name':
								$query = "SELECT * FROM products ORDER BY naziv";
								$result = mysqli_query($dbc, $query);
								break;
							case 'category':
								$query = "SELECT * FROM products ORDER BY kategorija";
								$result = mysqli_query($dbc, $query);
								break;
							case 'date':
								$query = "SELECT * FROM products ORDER BY datum";
								$result = mysqli_query($dbc, $query);
								break;
						}
						
										
						while ($row = mysqli_fetch_array($result)){

							if ($counter == $limit) break;
							$offset++;
							if ($offset < $page * $limit - $limit + 1) continue;

							echo '<tr>
									<td>
										<figure><img src="'.$row['slika'].'"</figure>
									</td>
									<td>
										<a id="'.$row['id'].'-trigger" href="" onclick="open_modal(this.id);return false;">'.$row['naziv'].'</a>
									</td>
									<td>
										'.$row['kategorija'].'
									</td>
									<td>
										'.date("d.m.Y", strtotime($row['datum'])).'.
									</td>
									<td>
										<input type="button" id="'.$row['id'].'" class="add" value="Add" onclick="add(this.id)">
									</td>
								</tr>';
							$counter++;
						} 
						echo '</table>';

						if ($max > $limit){
							$maxpage = (int) ($max / $limit);
							if ($max % $limit) $maxpage++;

							if ($page == 1)
								echo '<div id="previous"><h2>Previous</h2></div><div id="page"><h2>'.$page.'/'.$maxpage.'</h2></div><div
								 id="next"><a href="view_sort.php?page='.($page + 1).'&sort='.$sort.'"><h2>Next</h2></a></div>';
							else if ($page == $maxpage)
								echo '<div id="previous"><a href="view_sort.php?page='.($page - 1).'&sort='.$sort.'"><h2>Previous</h2></a></div><div
								 id="page"><h2>'.$page.'/'.$maxpage.'</h2></div><div id="next"><h2>Next</h2></div>';
							else
								echo '<div id="previous"><a href="view_sort.php?page='.($page - 1).'&sort='.$sort.'"><h2>Previous</h2></a></div><div
								 id="page"><h2>'.$page.'/'.$maxpage.'</h2></div><div id="next"><a href="view_sort.php?page='.($page + 1).'&sort='.$sort.'"><h2>Next</h2></a></div>';
						}

						echo '<style type="text/css">
        						#'.$sort.' {
            						background-color: white !important;
            						color: navy !important;
        						}
        						</style>';

						mysqli_close($dbc); 
					?>
			</div>
		</div>

		<div id="modal" class="modal">
  			<div class="modal-content">
    			<span class="close">&times;</span>
    			<div id="product-desc">
    			</div>
  			</div>
		</div>

		<script type="text/javascript">
			<?php 
				if ($_SESSION['admin']) 
					echo '
						document.getElementById("add").onclick = function (event){
						window.location = "add_product.php";
						} ';
			?>

			document.getElementById("clear").onclick = function (event){
				/*document.getElementById("search_imput").value = "";
				document.getElementById("find").disabled = true;*/
				window.location = "view_product.php";
			}

			function update () {

				var search = document.getElementById("search_imput").value;

				if (search.length > 2) {
					document.getElementById("find").disabled = false;
				} else {
					document.getElementById("find").disabled = true;
				}

			}

			function add (id) {
				
				var str = "?id=" + id;
				var request = new XMLHttpRequest();

				request.onreadystatechange = function() {
            		if (this.readyState == 4 && this.status == 200) {
                		if (this.responseText) {
                			alert("Artikal je dodan u košaricu.");	
                		}  
            		}
        		}; 

        		request.open("GET", "add_to_cart.php" + str, true);
        		request.send();
			} 

			function search (page) {
				var str = document.getElementById("search_imput").value;
				if (str.length < 3) return false;
				document.getElementById("")
				var category = document.getElementById("category").value;
				if (page == undefined) str = "?str=" + str + "&category=" + category;
				else str = "?str=" + str + "&category=" + category + "&page=" + page;
				var request = new XMLHttpRequest();
				
				request.onreadystatechange = function() {
            		if (this.readyState == 4 && this.status == 200) {
                		document.getElementById("preview").innerHTML = this.responseText;

                		var s = document.createElement("script");
						s.type = "text/javascript";
						s.src = "script.js";
						document.body.appendChild(s);
                		}  

            		}; 

        		request.open("GET", "search_view.php" + str, true);
        		request.send();
			}

			// Get the <span> element that closes the modal
			var span = document.getElementsByClassName("close")[0];


			// When the user clicks on <span> (x), close the modal
			span.onclick = function() {
				var modal = document.getElementById('modal');
			    modal.style.display = "none";
			}

			// When the user clicks anywhere outside of the modal, close it
			window.onclick = function(event) {
			    if (event.target == modal) {
			        modal.style.display = "none";
			    }
			}

			function open_modal (id) {
				id = id.substring(0, id.indexOf('-'));
				var request = new XMLHttpRequest();

				request.onreadystatechange = function() {
            		if (this.readyState == 4 && this.status == 200) {
            			var modal = document.getElementById("modal");
                		document.getElementById("product-desc").innerHTML = this.responseText;
                		modal.style.display = "block";

                		var c = document.createElement("script");
						c.type = "text/javascript";
						c.src = "close.js";
						document.body.appendChild(c);
                	}  

            	}; 

        		request.open("GET", "product_info.php?id=" + id, true);
        		request.send();
			} 

		</script>

	</body>

</html>

