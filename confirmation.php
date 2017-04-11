<?php
  // Include 'connect.php' to login to the database
  include 'connect.php';

  // Retrieve id from the application
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
  }
  else {
    $id = $_GET['id'];  
  }
  // Retrieve email from the application
  if (isset($_POST['email'])) {
    $email = $_POST['email'];
  }
  else {
    $email = $_GET['email'];
  }
    
  // If $id or $email is not set, stop the operation
  if (!isset($id) || !isset($email))        
  {
    die ("Device ID or email not set with request");
  }
  
  // Check if device ID and email pair exists in the 'authentication' table
  $result = mysqli_query($dbcon, "SELECT * FROM  `auth` WHERE (`id` =  '".$id."') AND (`email` =  '".$email."')");
  // If returned array is empty, pair was not found
  if ($result->num_rows == 0) {
    die ("Confirmation email invalid. Pair of retrieved variables not found in the authentication table");
  }
  // Get associative array of strings
  $row = mysqli_fetch_assoc($result);
  // Set email from the associative array from the table
  $email = $row["email"];
  // Look if this pair already exists
  $result = mysqli_query($mysqli, "SELECT * FROM  `pairs` WHERE (`id` =  '".$id."') AND (`email` =  '".$email."')");
                              
  // If the returned array is not empty, the pair already exists in the table
  if ($result->num_rows > 0) {
    die ("This device has already been confirmed.");
  }

  // Create a new device ID and email pair and insert it into table 'pairs'
  mysqli_query($dbcon, "INSERT INTO pairs (email,id) VALUES ('$email','$id')");
  echo "INSERT INTO pairs (email,id) VALUES ('$email','$id')";
  // Update authentication table
  mysqli_query($dbcon, "UPDATE `auth` SET `token`='' WHERE `email`='".$email."'");

  die ("Device confirmed successfully.");
?>