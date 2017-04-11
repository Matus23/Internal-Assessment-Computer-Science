<?php
  // Include 'connect.php' to login to the database
  include 'connect.php';
  
  // Retrieve device ID from the application
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
  $result = mysqli_query($dbcon, "SELECT * FROM pairs WHERE (id = '$id') and (email = '$email') ");
  // If length of returned array of pairs is not 0, then login is successful
  if ($result->num_rows > 0)
  {
    die ("Login successful.");
  }
   
  $result = mysqli_query($dbcon, "SELECT * FROM contestants WHERE (email = '$email') ");
  // If length of returned array of pairs is 0
  if ($result->num_rows == 0)
  {
    die ("Email not found.");
  }

  // Get associative array of strings
  $row = mysqli_fetch_assoc($result);
  // If retrieved device ID matches with the device ID in the table, the confirmation email has already been sent
  if ($row['id'] == $id) {
    die ("Confirmation email has already been sent.");
  }

  // Generate random token
  $token = bin2hex(openssl_random_pseudo_bytes(16));

  // Update table with the retrieved data
  $query = "UPDATE `contestants` SET `id`='".$id."', `token`='".$token."' WHERE `email`='".$email."'";
  mysqli_query($dbcon, $query);

  // Generate confirmation mail, with the id and token and send to the email 
  // When clicked, a pair between the email and device ID will be generated, authenticating the device
  mail($row["email"], 'Login confirmation', 'http://slovenska-debatna-asociacia.esy.es/confirmation.php?token='.$token.'&id='.$id);

  echo 'Confirmation email sent.';
  mysqli_close($dbcon);	
?>