<?php
if(isset($_POST['submit'])){

	echo "<meta http-equiv='refresh' content='0'>";

	$error = FALSE;

	// make sure all fields are filled in
	// if (empty($title) || empty($devs) || empty($year) || 
	// 	empty($tags) || empty($img)) {
	// 	echo empty($title);
	// 	$error = "Please fill in all fields.";
	// }

	$title = strip_tags($_POST['addtitle']);
	$devs = strip_tags($_POST['adddeveloper']);

	// filter inputs
	if (filter_input(INPUT_POST, 'addyear', FILTER_VALIDATE_INT) !== FALSE) {
		$year = filter_input(INPUT_POST, 'addyear', FILTER_VALIDATE_INT);
	}
	else {$error = "Only numbers are allowed in the year field.";}
	if (filter_input(INPUT_POST, 'addimg', FILTER_VALIDATE_URL) !== FALSE) {
		$img = filter_input(INPUT_POST, 'addimg', FILTER_VALIDATE_URL);
	}
	else {$error = "Please enter a valid URL.";}
	if (preg_match('/[-a-zA-Z0-9\'.|]*/', $_POST['addtags'])) {
		$tags = $_POST['addtags'];
	}
	else {$error = "Only alphanumeric characters, hyphens, and pipes are allowed in tags.";}


	if (empty($title)) {
		$error = "Please fill in title.";
	}

	if (empty($devs)) {
		$error = "Please fill in developer.";
	}

	if (empty($year)) {
		$error = "Please fill in year.";
	}

	if (empty($tags)) {
		$error = "Please fill in tags.";
	}

	if (empty($img)) {
		$error = "Please fill in thumbnail.";
	}

	// proceed if no error
	if ($error == FALSE) {
		include 'catalog.php';

		if (!array_key_exists($title, $catalogArray)) {	
			$newline = "\n" . $title . '~' . $devs . '~' . $year . '~' . $tags . '~' . $img;
			file_put_contents('data.txt', $newline, FILE_APPEND);
		}
		else {echo "<script type='text/javascript'>alert('Entry already in database');</script>";}
	}
	else {echo "<script type='text/javascript'>alert('$error');</script>";} 
}
?>