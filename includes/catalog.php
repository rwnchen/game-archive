<?php
	class Game {
	public $title = "";
	public $releasedate = "";
	public $developer = "";
	public $tags;
	public $img;
}

$catalogArray = array();

// import external data
$entries = fopen("../data.txt", "r");
if ($entries !== FALSE) {
	while (($line = fgets($entries)) !== FALSE) {
		$entry = new Game();

		// parse each line of the txt file to create new entry
		$data = explode("~", $line);

		$devArray = explode("|", $data[1]);
		$tagArray = explode("|", $data[3]);
		
		$entry->title = $data[0];
		$entry->releasedate = $data[2];
		$entry->developer = $devArray;
		$entry->tags = $tagArray;
		$entry->img = $data[4];

		$catalogArray["$entry->title"] = $entry;
		}
}	
fclose($entries);

?>