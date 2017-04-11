<?php
  // Start the session
  session_start();
?>
<!DOCTYPE>
<html>
  <head>
  <meta charser="UTF-8">
  <title> Title of the document </title>
  <link rel="stylesheet" type="text/css" href="style.css" />
  </head>

  <body> 
    <div class="moveToCenter">
      <div id="login">
        <p> Please, log in in the following formular </p>
        
        <?php 
          if (!isset($_SESSION['login'])) {
            echo "<form action='login_parse.php' method='post'>
            Username: <input type='text' name='username' />
            Password: <input type='password' name='password' />
            <input type='submit' name='submit' value='Log In' />";  
          }
          else {
            header("Location: main_menu.php");        
          }
        ?>
        
      </div>
    </div>
  </body>
</html>