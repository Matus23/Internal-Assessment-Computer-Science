<?php
  //Start the session
  session_start();
  // Redirect user to the login page
  header("Location: index.php");
  // Stop the sesson
  session_destroy();
?>