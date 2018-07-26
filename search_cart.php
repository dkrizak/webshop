<?php
	session_start();

	if (!isset($_SESSION['uname'])) header("location:index.php");

	require 'dbconnect.php';

	error_reporting(E_ERROR | E_PARSE);

	$str = $_GET['str'];
	$category = $_GET['category'];
			
	$max = 0;
	$limit = 4;
	$counter = 0;
	$offset = 0;
	if (isset($_GET['page'])) $page = $_GET['page'];
	else $page = 1;

	//lista id-a
	$list = "";
	foreach ($_SESSION['cart'] as $id) {
		if (strpos($id, '-')){
			$tmp = explode('-', $id);
			$list .= $tmp[0].','; 
		} else $list .= $id.',';
	}
	$list = rtrim($list,',');

	//duplikati
	$tmplist = explode(',', $list);
	$duplicates = array_count_values($tmplist);

	if ($category == "") $query = "SELECT * FROM products WHERE id IN ($list)";
	else $query = "SELECT * FROM products WHERE kategorija='$category' AND id in ($list)";
	$result = mysqli_query($dbc, $query);

	echo '<table id="previewtb">
			<tr>
				<th>Picture</th>
				<th><a href="cart_sort.php?sort=name" id="name">Name</a></th>
				<th><a href="cart_sort.php?sort=category" id="category">Category</a></th>
				<th><a href="cart_sort.php?sort=date" id="date">Date</a></th>
				<th>Add</th>
			</tr>';



	while ($row = mysqli_fetch_array($result)){

		if ($counter == $limit) break;

		if ((strpos(strtolower($row['naziv']), strtolower($str)) !== false) || (strpos(strtolower($row['opis']), strtolower($str)) !== false))
		{
			$id = $row['id'];
			for ($i = 0; $i < $duplicates[$row['id']]; $i++){
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
							'.date("d.m.Y", strtotime($row['datum'])).'
						</td>
						<td>
							<input type="button" id="'.$id.'" value="Remove" onclick="remove(this.id)">
						</td>
					</tr>';

				$id .= '-'.$row['id'];
				$counter++;
			}	
		}
								
	} 

	$result_max = mysqli_query($dbc, $query);
	while ($row = mysqli_fetch_array($result_max)){
		if ((strpos(strtolower($row['naziv']), strtolower($str)) !== false) || (strpos(strtolower($row['opis']), strtolower($str)) !== false))
		{
			$id = $row['id'];
			for ($i = 0; $i < $duplicates[$row['id']]; $i++){
				$max++;
			}
		}
	}

	if ($max < 1){
		echo '<tr><td colspan="5"><h3>Ne postoji niti jedan artikal koji odgovara uvjetima pretrage.</h3></td></tr>';
	}
	echo '</table>';

	if ($max > $limit){
		$maxpage = (int) ($max / $limit);
		if ($max % $limit) $maxpage++;

		if ($page == 1){
			echo '<div id="previous"><h2>Previous</h2></div><div id="page"><h2>'.$page.'/'.$maxpage.'</h2></div><div
			 id="next"><a id="nextl" href="#"><h2>Next</h2></a></div>';

			 $content = '
				var link = document.getElementById("nextl");
					
				link.onclick = function(){
					search('.($page + 1).');
				};
			';
		}
		else if ($page == $maxpage){
			echo '<div id="previous"><a id="previousl" href="#"><h2>Previous</h2></a></div><div
			 id="page"><h2>'.$page.'/'.$maxpage.'</h2></div><div id="next"><h2>Next</h2></div>';

			 $content = '
				var link = document.getElementById("previousl");
					
				link.onclick = function(){
					search('.($page - 1).');
				};
			';
		}
		else{
			echo '<div id="previous"><a id="previousl" href="#"><h2>Previous</h2></a></div><div
			 id="page"><h2>'.$page.'/'.$maxpage.'</h2></div><div id="next"><a id="nextl" href="#"><h2>Next</h2></a></div>';

			 $content = '
				var linkn = document.getElementById("nextl");
				var linkp = document.getElementById("previous");
					
				linkn.onclick = function(){
					search('.($page + 1).');
				};

				linkp.onclick = function(){
					search('.($page - 1).');
				};
			';
		}

		$fp = fopen("script.js","wb");
		fwrite($fp,$content);
		fclose($fp);

	}

	mysqli_close($dbc);
	
?>