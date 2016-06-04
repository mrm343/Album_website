<?php
    session_start(); 
    require_once('config.php');
    $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    foreach ($_POST as $key => $value) {
        $_POST[$key] = filter_input( INPUT_POST, $key, FILTER_SANITIZE_STRING );
    }
?>
<!DOCTYPE html>
<html>

        <?php include 'base.php';?>

            <div class="subtitle1">
                Login or Logout
            </div>

        <?php

        echo "<div class='paragraph_text'>";
        
        // If submission made (submit, username, password), check database for user
        if(isset($_POST['in']) && isset($_POST['username']) && isset($_POST['password'])){
            
            $hashed = hash("sha256",$_POST['password']);

            $sql = "SELECT * FROM Users WHERE username = '".$_POST['username']."' AND password = '".$hashed."'";
            
            $result = $db->query($sql);

            // If user found
            if ( $result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $_SESSION['logged_user'] = $row['username'];
                // If user admin
                $sql = "SELECT * FROM Admins WHERE user_id = '".$row['user_id']."' " ;
                $result2 = $db->query($sql);
                if ($result2 && $result2->num_rows == 1) {
                    $_SESSION['admin'] = true; 
                }
            }
            // If user not found
            else {
                echo '<p>' . $db->error . '</p>';
                echo "<p>Wrong username and password! Try Again</p>";
            }
        }
        // if logged out, end session
        else if(isset($_POST['out'])){
            unset($_SESSION['logged_user']);
            session_destroy();
            session_start();
        }
        // if not logged in, show option to log in
        if(!isset($_SESSION['logged_user'])){
            echo "<u><b>Log In</b></u>";
            echo "<form action='login.php' method='post' class='center'>";
                echo "Enter Username: <input type='text' name='username'> <br>";
                echo "Enter Password: <input type='password' name='password'> <br>";
                echo "<input type='submit' name='in' value='Log In'>";
            echo "</form><br><br>";
        }
        // if logged in, show option to log out
        else{
            echo "<p>Welcome to Moreyra Birdwatching, ".$_SESSION['logged_user'].".<p>";
            echo "<form action='login.php' method='post'>";
                echo "<input type='submit' name='out' value='Log Out'><br><br>";
            echo "</form>";
        }
        // allow the option to make a new user
        echo "<u><b>Make a New User</b></u>";
            echo "<form action='add_user.php' method='post' enctype='multipart/form-data'>";
                echo "New Username: <input type='text' name='user'><br>";
                echo "New Password: <input type='text' name='pass'><br>";
                echo "<input type='submit' value='Make User' name='uploadUser'><br><br>";     
            echo "</form>";
        echo "</div>";
        $db->close();
        
        ?>      

        <div class="footer">
            All images provided by 'Minnesota Birdwatching'
        </div>

        </body>


</html>
