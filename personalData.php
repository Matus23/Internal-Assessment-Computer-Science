<?php
  // Include 'connect.php' to connect to the database
  include 'connect.php';
  
  // Retrieve id from the application
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
  }
  else {
    $id = $_GET['id'];
  }
  
  // If $id is not set, stop the operation
  if (!isset($id)) {
    die("Device ID not set with request");
  }
  
  // Store into $result all rows in which device id from the application matches device id from the table
  $result = mysqli_query($dbcon, "SELECT * FROM pairs WHERE (id = '$id')");
  // Message to be outputted if device ID is not in the database
  $message = "ID is not in the database";
    
  // If returned array is empty, no pair was found
  if(mysqli_num_rows($result) == 0) {
    // Create an array that will be sent back
    $returnArray = array (
      'wasSuccessful' => 0,
      'message' => $message,
    );
      
    //Serialize the data that will be sent back
    echo json_encode($returnArray);
      
  }
  // If a pair was found
  else {
    // Store into $result all rows in which retrieved device ID matches with device ID in the table
    $result = mysqli_query($dbcon, "SELECT * FROM personalData WHERE (id = '$id') ");
    $row = mysqli_fetch_row($result);
      
    // Create an array that will be sent back 
    $returnArray = array (
      'wasSuccessful' => 1,
      'name' => $row[0],
      'team' => $row[1],
    );
    
    //Serialize the data that will be sent back  
    echo json_encode($returnArray);
    
  }
?>