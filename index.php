<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Videogame Archive</title>

		<link rel="stylesheet" href="styles/style.css">
		<link rel="icon" href="img/cartridge.png">
		<link href="https://fonts.googleapis.com/css?family=Rajdhani:400,700" rel="stylesheet">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
		<script src="scripts/main.js"></script>
	</head>


	<body>
		<div id="content">
			<div id="header">
				<img src="img/logo.png" alt="PC Game Archive">
				<div id="topbar">
					<form method="get" id="search">
						<input type="text" name="title" class="searchField" placeholder="Title">
						<input type="text" name="developer" class="searchField" placeholder="Developer">
						<input type="text" name="year" class="searchField" placeholder="Year of Release">
						<input type="text" name="tags" class="searchField" placeholder="Tag">
					</form>
					<div class="spacer"></div>
					<form method="get" id="sort">
						<select name="sort">
							<option value="default" selected> Sort by</option>
							<option value="title">Title</option>
							<option value="developer">Developer</option>
							<option value="date">Release Date</option>
						</select>
					</form>
					<div id="add_entry">
						+ Add Entry
					</div>
				</div>
				<div id="add_modal">
					<form method="post" id="add">
						<input type="text" name="addtitle" class="searchField" placeholder="Title">
						<input type="text" name="adddeveloper" class="searchField" placeholder="Developers, separated by pipes (|)">
						<input type="text" name="addyear" class="searchField" placeholder="Year of Release">
						<input type="text" name="addtags" class="searchField" placeholder="Tags, separated by pipes (|)">
						<input type="text" name="addimg" class="searchField" placeholder="Image URL">
						<input type="submit" name="submit">
					</form>
					<?php
						include 'includes/form.php';
					?>
				</div>
			</div>
			<div id="catalog">
				<!-- Photo credits as follows:
					Binding of Isaac: http://tinyurl.com/j8zfubz
					Dishonored: http://tinyurl.com/z5kbd7d
					FEZ: http://tinyurl.com/ov4uatw
					Lethal League: http://tinyurl.com/he746ng
					Mass Effect: http://tinyurl.com/ha5b5w7
					Stardew Valley: http://tinyurl.com/h43yklj
				-->
			</div>
		</div>
		
	</body>
</html>