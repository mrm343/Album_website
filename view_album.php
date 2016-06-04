<?php	
	session_start();
	if(isset($_GET['album_id'])){
		require_once('include/../config.php');
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		$sql = "SELECT * FROM Albums WHERE album_id = ".$_GET['album_id'];
		$result = $mysqli->query($sql);
		//put the album in $album
		$album = $result->fetch_assoc();


	}
?>

<!DOCTYPE html>
<html>

<?php include 'base.php';?>

                <div class="subtitle1">
                    Album Viewer
                </div>

            <div class="paragraph_text">
                

                <div class="footer">
                    All images provided by 'Minnesota Birdwatching'
                </div>

<?php	
	if(isset($_GET['album_id'])){


		//get an array of the album photos
		$sql = "SELECT Photos.* FROM Photos INNER JOIN Album_Photos ON Photos.photo_id = Album_Photos.photo_id INNER JOIN Albums ON Album_Photos.album_id = Albums.album_id WHERE Albums.album_id = ".$_GET['album_id'];

		$result = $mysqli->query($sql);

			
		//Display album cover, date created, date modified
		echo "<h1>".$album['title']."</h1>";
        //admin warning
        if (!(@$_SESSION['admin'])) {
            echo "<div class='green'> You must be an admin to delete photos</div>";
        }

		echo "<figure>";
			echo "<img class='photo_images2' src='photos/".$album['album_url']."' alt='".$album['title']."'>";
			echo "<figcaption>Date Created: ".$album['date_created']."</figcaption>";
			echo "<figcaption>Date Modified: ".$album['date_modified']."</figcaption>";
		echo "</figure>";
		echo "<br><br>";

		//Display each photo in the album
		while($photo = $result->fetch_assoc()) {
            echo "<a href='view_photo.php?photo_id=".$photo['photo_id']."'>";
            echo "<img src='photos/".$photo['photo_url']."' alt='".$photo['caption']."' class='photo_caption'>";
            echo "</a>";
            echo "<div class = caption_text>"
                .$photo['caption']
                ."</div>";
            echo "<div class = credit_text>"
                ." by "
                .$photo['credit']
                ."<br></div>";
        

        	//delete photo if admin
        	if(@$_SESSION['admin']){
        		echo "<br><div class=photo_images>";
                	echo "<form action='change_photo.php?album_id=" . $album["album_id"] . "&id=" . $photo['photo_id'] . "' method='post' enctype='multipart/form-data'>";
                		//delete photo from this album
                		echo "<u>Delete Photo?</u>";
                    	echo "<br><input type='submit' value='Delete Photo from this Album' name='deletePhoto1'><br>";
                echo "</form></div>";
      			    	
        	}
    	}



		$mysqli->close();
	}
?>

</div>
</body>
</html>