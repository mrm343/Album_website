<?php
	session_start();
	require_once('include/../config.php');
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	foreach ($_POST as $key => $value) {
    	$_POST[$key] = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
	}

	if(isset($_POST['uploadUser']) && !empty($_POST['user']) && !empty($_POST['pass'])){

		//put into Photos
		//$uploading1 = strtolower($_FILES["user"]['username']);
		//$uploading2 = strtolower($_FILES["pass"]['password']);
		$user1 = $_POST['user'];
		$hashed1 = hash("sha256",$_POST['pass']);

		$sql1 = "INSERT INTO Users (username, password) VALUES ('$user1' , '$hashed1')";
		$mysqli->query($sql1);
    
    	//update Album date
    	//$sql3 = "UPDATE Albums SET date_modified = CURRENT_TIMESTAMP WHERE album_id=".$album_id.;
    	//$mysqli->query($sql3);
	}

	$mysqli->close();
	header("Location: {$_SERVER['HTTP_REFERER']}");
?>