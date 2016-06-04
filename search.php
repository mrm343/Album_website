<?php   
    session_start();
    require_once('config.php');
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
?>
<!DOCTYPE html>
<html>

    <?php include 'base.php';?>

    <div class="subtitle1">
        Search Images
    </div>

    <?php
        echo "<div class='paragraph_text'>";

                echo "<u>Search</u>";
                echo "<p class='center'>Use the search field to find photos with captions matching your query.</p>";

                //Search form
                echo "<form action='search.php' method='post'>";
                echo "<input type='text' name='query'><br><br>";
                echo "<input type='submit' value='Search' name='search'>";
                echo "</form>";
    

                // If search submitted
                if(isset($_POST['query'])){

                    foreach ($_POST as $key => $value) {
                        $_POST[$key] = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
                    }

                    $sql = "SELECT * FROM Photos WHERE caption LIKE '%".$_POST['query']."%'";
                    $result = $db->query($sql);
                    $match = ($result->num_rows == 0);

                    $photos = array();
                    while($row = $result->fetch_assoc()) {
                        array_push($photos, $row);
                    }


                    if($match){
                        echo "<p>There were no matches for '".$_POST['query']."'.</p>";
                    }
                    else{       
                        echo "<ul>";
                        //Display matched photo
                        foreach($photos as $photo){
                                    //echo "<img class='photo_images' alt='Photo Images' src= {$photo['photo_url']}>";
                                    echo "<a href='view_photo.php?photo_id=".$photo['photo_id']."'>";
                                        echo "<img src='photos/".$photo['photo_url']."' alt='".$photo['caption']."' class='photo_caption'>";
                                    echo "</a>";
                                    echo "<div class = caption_text>"
                                    .$photo['caption']
                                    ."<br></div><br><br>";
                                    //echo "<div class = credit_text>"
                                    //." by "
                                    //.$photo['credit']
                                    //."<br></div>";
                                    //echo"<br><br>";
                        }
                        echo "</ul>";
                    }
                }
        echo "</div>";    
            $db->close();
    ?>

                <div class="footer">
                    All images provided by 'Minnesota Birdwatching'
                </div>

        </body>


</html>