<!DOCTYPE html>
<html>

<?php
    session_start();
    include 'base.php';
    require_once('include/../config.php');
?>

            <div class="subtitle1">
                Add Albums and Images
            </div>

            <div class="paragraph_text">

            <?php
                
                //add and upload only if admin
                if(@$_SESSION['admin']){

                    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                    //get all photo urls into photoarray, use this for selecting an album cover
                    $result1 = $mysqli->query("SELECT photo_url FROM Photos");
                    $photoarray = array();
                    while($row = $result1->fetch_assoc()) {
                        array_push($photoarray, $row);
                    }

                    //get all array ids into albumarray, use this for selecting an album
                    $result2 = $mysqli->query("SELECT album_id FROM Albums");
                    $albumarray = array();
                    while($row = $result2->fetch_assoc()) {
                        array_push($albumarray, $row);
                    }

                    //connect this to add_album.php, using photoarray
                    echo "<u><b>Make A New Album?</b></u>";
                        echo "<form action='add_album.php' method='post'>";
                            echo "What is your album title? <input type='text' name='title'><br>";
                            echo "Which picture would you like for your album cover?";
                                echo "<select name='album_url'>";
                                    foreach($photoarray as $url) {
                                        echo "<option value='".$url['photo_url']."'>".$url['photo_url']."</option>";
                                    }
                                echo "</select>";
                            echo "<br><input type='submit' value='Make A New Album' name='newAlbum'>";  
                        echo "</form>";

                    echo "<br>";

                    //upload photos
                    echo "<u><b>Upload A Photo?</b></u>";
                        echo "<form action='add_image.php' method='post' enctype='multipart/form-data'>";
                            echo "Image File: <input type='file' name='fileToUpload' id='fileToUpload'><br>";
                            echo "Image Caption: <input type='text' name='caption'><br>";
                            echo "Image Credit: <input type='text' name='credit'><br>";
                            echo "In which album would you like to place your picture?   ";
                            echo "<select name='album_id'>";
                                    foreach($albumarray as $url) {
                                        echo "<option value='".$url['album_id']."'>".$url['album_id']."</option>";
                                    }
                                echo "</select>";
                            echo "<br><input type='submit' value='Upload Photo' name='uploadPhoto'><br></br>"; 
                        echo "</form>";
                }
                else{
                    echo "<p class='green'>You must be an admin to make a new album or upload a photo.</p>";
                }

                ?>
                
                <div class="footer">
                    All images provided by 'Minnesota Birdwatching'
                </div>

            </div>

        </body>

</html>

