<?php    
  // Start the session
  session_start();
  // Redirect the user into the login page if he has not logged in
  if (!isset($_SESSION['username'])){
    header('location: index.php');
    exit;
  }  
  // If the user is inactive for the given time period, redirect him back to the login page
  if(time() - $_SESSION['timestamp'] > 900) { 
    header('location: index.php'); 
    exit;
  }
  // Update timestamp when the user performs an action
  $_SESSION['timestamp'] = time(); 

?>       

<div class="moveToCenter">
   <form method="post" action="main_menu.php">
    <input type="submit" name="backToLoginPage" value="Get back to the main menu">
  </form>
</div>

<?php

  // Include 'connnect.php' to connect to the database
  include 'connect.php';
    
  if(isset($_POST['notification'])) {
    
    // Retrieve message that the user typed
    $message = $_POST['push_message'];
    if (mysqli_num_rows($message)==0) {
      die ('Empty message');
    }
    // time of the notification
    $time = date('Y-m-d H:i:s', time());
    // Store time of the notification in the table
    mysqli_query($dbcon, "INSERT INTO notification (time,description) VALUES ('$time','$message')");          

    die ("Notification successfully sent");    
  } 
?>