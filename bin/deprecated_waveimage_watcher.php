<?php

require_once('waveimage.php');
	
$dbc = mysqli_connect('localhost', 'root', '', 'alonewithtiger');
if(!$dbc) {		// prints an error if the connection could not be made
	trigger_error('Could not connect to MySQL: ' . mysqli_connect_error());
}

while(true) {

	$songs = fetchSongDetails($dbc);

	foreach($songs as $song) {

		$imgMaker = new WaveImageMaker(array(
			'mp3_filename'	=> $song['mp3']['path'],
			'width'			=> 340,
			'height'		=> 80,
			'foreground'	=> "#8ee68c",
			'background'	=> "#FFFFFF",
			'draw_flat'		=> false,
			'detail'		=> 5,
			'is_stereo'		=> false
		));

		$imgMaker->process();

		if($imgMaker->saveAs($song['img']['path'])) {
			// write the waveimageUrl to the db
			$insert = sprintf("UPDATE song SET wavform_url = '%s' WHERE id = %s", $song['img']['url'], $song['id']);
			$stm = mysqli_prepare($dbc, $insert);
			// mysqli_execute($stm);
		}
		unset($imgMaker);
		
		sleep(2);		// don't hog the CPU
	}
	
	sleep(15);			// check again in one minute
	
}

function fetchSongDetails($dbc) {

	$query = "SELECT id, file_name FROM song WHERE waveform_image IS NULL";
	$r = mysqli_query($dbc, $query);	// Counts how many records match the username and activation code sent in the URL

	$rv = array();
	
	if($r) {
		$count = 0;
		while($row = mysqli_fetch_array($r)) {
			$mp3_filename		= $row[1];
			$mp3_url		= pathToUrl($mp3_path);
			// $mp3_url		= $row[1];
			// $mp3_path		= urlToPath($mp3_url);

			preg_match('/(?P<filepart>.+)\.(?P<ext>\w{1,4})$/', $mp3_url, $mUrl);
			preg_match('/(?P<filepart>.+)\.(?P<ext>\w{1,4})$/', $mp3_path, $mPath);
			$waveimge_url	= sprintf("%s_waveform.png", $mUrl['filepart']);
			$waveimge_path	= sprintf("%s_waveform.png", $mPath['filepart']);
			
			$rv[$count] = array(
				'id'	=> $row[0],
				'mp3'	=> array(
					'path'	=> $mp3_path,
					'url'	=> $mp3_url,
				),
				'img'	=> array(
					'path'	=> $waveimge_path,
					'url'	=> $waveimge_url
				),
			);
			$count++;
		}
		die(var_dump($rv));

		if(!$r) {
			die("not r");
		}
		return $rv;
	}
}

function urlToPath($url) {
	return "C:\\xampp\\htdocs" . join('\\', preg_split('/\//', $url));
}

function pathToUrl($url) {
	preg_split('/\/', $url);
}

?>