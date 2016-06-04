<?php	
	session_start();
if(isset($_GET['photo_id'])){
	require_once('config.php');
	$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$sql = "SELECT * FROM Photos WHERE photo_id = ".$_GET['photo_id'];
	$photo = ($db->query($sql)->fetch_assoc());
	}
?>
<!DOCTYPE html>
<html>

<?php include 'base.php';?>

                <div class="subtitle1">
                    Photo Viewer
                </div>

            <div class="paragraph_text">
                

                <div class="footer">
                    All images provided by 'Minnesota Birdwatching'
                </div>

<?php

		echo "<div class='center'>";
			echo "<h1>".$photo['caption']."</h1>";
				echo "<img src='photos/".$photo['photo_url']."' alt='".$photo['caption']."' class='photo_caption2'>";
				echo "<div class='photo_caption1'>Taken By: ".$photo['credit']."</div>";
		echo "</div>";

		// Display albums which photo is a part of
		$sql1 = "SELECT Albums.* FROM Albums INNER JOIN Album_Photos ON Albums.album_id = Album_Photos.album_id WHERE Album_Photos.photo_id = ".$_GET['photo_id'];
		$result = $db->query($sql1);
			echo "<div class = photo_caption1> This picture can be found in: </div>";
			echo "<ul>";
			$free = $result->num_rows == 0;
			

			$albums = array();
			while($row = $result->fetch_assoc()) {
				array_push($albums, $row);
			}


			if($free){
				echo "<li>none</li>";
			}
			else{
				foreach($albums as $album){
					echo "<li class='album'>";
						echo "<a href='view_album.php?album_id=".$album['album_id']."'>";
							echo "<img src='photos/".$album['album_url']."' alt='".$album['title']."' class='photo_images'>";
						echo "</a>";
						echo "<figcaption>".$album['title']."</figcaption>";
					echo "</li>";
				}
			echo "</ul>";
			}

			//Change or delete photo if admin
        	if(@$_SESSION['admin']){
        		echo "<div class=photo_caption>";
                	echo "<form action='change_photo.php?id=" . $photo["photo_id"] . "' method='post' enctype='multipart/form-data'>";
                		
                    	//delete photo from every album
                    	echo "<br> Delete Photo from Database?<br><input type='submit' value='Delete' name='deletePhoto2'><br><br>";
      			    	//update photo
      			    	echo "<u>Update Photo?</u><br>";
                    	echo "Change Title: <input type='text' name='titleChange'><br>";
                    	echo "Change Credit: <input type='text' name='creditChange'><br>";
                    	echo "<input type='submit' value='Update Photo' name='updatePhoto'>";
                    	echo "</form>";
                    	echo "</div><br>";
            }

		
	$db->close();
?>
</div>
</body>
</html>