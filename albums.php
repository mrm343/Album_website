<!DOCTYPE html>
<html>

<?php 
    include 'base.php';
?>

            <div class="subtitle1">
                Display Albums
            </div>

            <div class="paragraph_text">

                <?php
                    session_start();
                    require_once 'config.php';
                    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

                    //get all photo urls into photoarray, use this for selecting an album cover
                    $resultphoto = $mysqli->query("SELECT photo_url FROM Photos");
                    $photoarray = array();
                    while($row = $resultphoto->fetch_assoc()) {
                        array_push($photoarray, $row);
                    }

                    if(!(@$_SESSION['admin'])){
                        echo "<p class='green'>You must be an admin to update or delete an album.</p>";
                    }

                    //print the albums
                    $result = $mysqli->query("SELECT * FROM Albums");
                    while($row = $result->fetch_assoc()) {
                            echo "<h2>"
                                .$row['title']
                                ."<br></h2>";
                            echo "<a href='view_album.php?album_id=" . $row['album_id'] . "'><img class='photo_images' alt='Photo Images' src='photos/".$row['album_url']."'/> </a>";

                            
                            //allow option to change album if admin
                            if($_SESSION['admin']){
                                echo "<div class='photo_caption'>";
                                echo "<form action='change_album.php?id=" . $row["album_id"] . "' method='post' enctype='multipart/form-data'>";
                                    //delete
                                    //echo "<div name='album_id'>" . $row["album_id"] . "</div>";
                                    echo "<u><b>Update/Delete this Album?</b></u><br></br>";
                                    echo "Delete Album?<br><input type='submit' value='Delete Album' name='deleteAlbum'><br><br>";
                                    //update
                                    echo "Change Title: <input type='text' name='titleChange'><br>";
                                    echo "Change album cover picture?";
                                    echo "<select name='urlChange'>";
                                        foreach($photoarray as $url) {
                                            echo "<option value='".$url['photo_url']."'>".$url['photo_url']."</option>";
                                        }
                                    echo "</select>";
                                    echo "<br><input type='submit' value='Update Album' name='updateAlbum'>";
                                echo "</form>";
                                echo "</div>";
                            }
                    }

                ?>


                
                <div class="footer">
                    All images provided by 'Minnesota Birdwatching'
                </div>

            </div>

        </body>

</html>
