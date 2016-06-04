<?php
	session_start();
	$reset = false; //reditect away from page
	require_once('config.php');
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	foreach ($_POST as $key => $value) {
		$_POST[$key] = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
	}

	/*print_r($_POST);
	var_dump($_POST);*/
	if(isset($_POST['updatePhoto'])){
		echo "foobar";
		//$upload_error = "";
    	$sql = "UPDATE Photos SET caption = '".$_POST['titleChange']."', credit = '" .$_POST['creditChange']. "' WHERE photo_id=".$_GET['id'];
    	$db->query($sql);
    	var_dump($sql);
	}

	else if(isset($_POST['deletePhoto2'])){
		$reset = true;
		$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    	$sql = "DELETE FROM Photos WHERE (photo_id = ".$_GET['id'].")";
    	$db->query($sql);

    	$sql = "DELETE FROM Album_Photos WHERE (photo_id = ".$_GET['id'].")";
    	$db->query($sql);
	}

	else if(isset($_POST['deletePhoto1'])){

		$album_id = $_GET['album_id'];

		$reset = true;
		$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    	$sql = "DELETE FROM Photos WHERE (photo_id = ".$_GET['id'].")";
    	$db->query($sql);

    	$sql = "DELETE FROM Album_Photos WHERE photo_id = ".$_GET['id']." AND album_id = $album_id";
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