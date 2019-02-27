<?php
	include 'catalog.php';

	$request = $_POST['requestType'];

	if (empty($request)) {
		echo 'Missing requestType.';
		die();
	} elseif ($request == 'default') {
		$result = array();
		foreach ($catalogArray as $game) {
			$result[] = $game;
		}
		echo json_encode($result);
	} elseif ($request == 'search') {
		$title = $_POST['title'];
		$devs = $_POST['devs'];
		$tags = $_POST['tags'];
		$year = $_POST['year'];

		// generate array of games with titles matching search term
		if ($title != '') {
			foreach ($catalogArray as $game) {
				if (!(stripos($game->title, $title)===FALSE)) { $titleMatch[] = $game; }
			}
			if (is_null($titleMatch)) { $titleMatch = array(); }
		} else { $titleMatch = $catalogArray; }
		
		// generate array of games with developers matching search term
		if ($devs != '') {
			foreach ($catalogArray as $game) {
				foreach ($game->developer as $dev) { 
					if (!(stripos($dev, $devs)===FALSE)) { $devMatch[] = $game; }
				}
			}		
			if (is_null($devMatch)) { $devMatch = array(); }
		} else { $devMatch = $catalogArray; }

		// generate array of games with year matching search term
		if ($year != '') {
			foreach ($catalogArray as $game) { 
				if (!(stripos($game->releasedate, $year)===FALSE)) {
					$yearMatch[] = $game; 
				}
			}		
			if (is_null($yearMatch)) { $yearMatch = array(); }
		} else { $yearMatch = $catalogArray; }

		// generate array of games with tags matching search term
		if ($tags != '') {
			foreach ($catalogArray as $game) {
				$gameTags = "";
				foreach ($game->tags as $tag) {
					$gameTags .= $tag;
					$gameTags .= " "; 
				}
				if (!(stripos($gameTags, $tags)===FALSE)) { $tagsMatch[] = $game; }
			}		
			if (is_null($tagsMatch)) { $tagsMatch = array(); }
		} else { $tagsMatch = $catalogArray; }

		foreach ($titleMatch as $key=>$value){
    		if (!in_array($value,$devMatch)){
        		unset($titleMatch[$key]);
    		}
    		if (!in_array($value,$yearMatch)){
        		unset($titleMatch[$key]);
    		}
    		if (!in_array($value,$tagsMatch)){
        		unset($titleMatch[$key]);
    		}
		}
		echo json_encode($titleMatch);
	}

?>