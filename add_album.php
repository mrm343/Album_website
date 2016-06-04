<?php
	session_start();
	require_once('include/../config.php');
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	foreach ($_POST as $key => $value) {
    	$_POST[$key] = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
	}

	if(isset($_POST['newAlbum']) && !empty($_POST['title'])) {

		//put into Albums
		$sql1 = "INSERT INTO Albums (title, album_url, date_created, date_modified) VALUES ('".$_POST['title']."', '".$_POST['album_url']."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
		$mysqli->query($sql1);

	}

	$mysqli->close();
	header("Location: {$_SERVER['HTTP_REFERER']}");
?>