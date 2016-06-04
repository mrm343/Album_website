<?php
	session_start();
	$reset = false; //reditect away from page?
	require_once('config.php');
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	foreach ($_POST as $key => $value) {
		$_POST[$key] = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
	}

	if(isset($_POST['updateAlbum'])){
		//$upload_error = "";
    	$sql = "UPDATE Albums SET title = '" .$_POST['titleChange']. "', album_url = '".$_POST['urlChange']."', date_modified = CURRENT_TIMESTAMP WHERE album_id=".$_GET['id'];
    	$db->query($sql);
	}

	else if(isset($_POST['deleteAlbum'])){
		$reset = true;
		$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    	$sql = "DELETE FROM Albums WHERE (album_id = ".$_GET['id'].")";
    	$db->query($sql);

    	$sql = "DELETE FROM Album_Photos WHERE (album_id = ".$_GET['id'].")";
    	$db->query($sql);
	}
	
	$db->close();

	if($reset){
		header("Location: albums.php");
	}
	else{
		header("Location: {$_SERVER['HTTP_REFERER']}");
	}
?>