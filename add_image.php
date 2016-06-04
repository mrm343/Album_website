<?php
	session_start();
	require_once('include/../config.php');
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	foreach ($_POST as $key => $value) {
    	$_POST[$key] = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
	}

	if(isset($_POST['uploadPhoto']) && !empty($_POST['caption']) && !empty($_POST['credit'])){

		//put into Photos
		$uploading = strtolower($_FILES["fileToUpload"]['name']);

		$photofolder = "photos/".$uploading;

		move_uploaded_file($_FILES["fileToUpload"]['tmp_name'], $photofolder);

		$sql1 = "INSERT INTO Photos (caption, photo_url, credit) VALUES ('".$_POST['caption']."', '$uploading' , '".$_POST['credit']."')";
		$mysqli->query($sql1);

		//update into Album_Photos
		$lastphotoid = "SELECT MAX(photo_id) AS photo FROM Photos";
		$resultmax = $mysqli->query($lastphotoid);
		$photomax = $resultmax->fetch_assoc()["photo"];
		echo($photomax);

    	$sql2 = "INSERT INTO Album_Photos (album_id, photo_id) VALUES ('".$_POST['album_id']."', $photomax)";
    	$mysqli->query($sql2);
    
    	//update Album date
    	//$sql3 = "UPDATE Albums SET date_modified = CURRENT_TIMESTAMP WHERE album_id=".$album_id.;
    	//$mysqli->query($sql3);
	}

	$mysqli->close();
	header("Location: {$_SERVER['HTTP_REFERER']}");
?>