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
    
  // Check if device ID and email pair exists in the 'pairs' table
  $result = mysqli_query($dbcon, "SELECT * FROM pairs WHERE (id = '$id') and (email = '$email') ");
  // If length of returned array is empty, the pair was not found
  if ($result->num_rows == 0) {
    die ("Contestant with the pair of received device id and email not found");
  }
  // Delete row of data where there is a pair of the retrieved device id and email
  $sql = "DELETE FROM pairs WHERE id='".$id."' and email='".$email."'";
  // If the pair was successfully found and deleted, output a message
  if (mysqli_query($dbcon, $sql)) {
    die("Record successfully deleted");
  }
  // The pair was not found in the table and the record could not be deleted
  die("Could not delete the record");
?>