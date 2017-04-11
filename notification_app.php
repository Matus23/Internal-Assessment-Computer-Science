<?php
  // Set timezone
  date_default_timezone_set("Europe/Bratislava");
  include 'connect.php';
  
  // Retrieve id
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
  }
  else {
    $id = $_GET['id'];
  }
  // Retrieve time
  if (isset($_POST['notificationTime'])) {
    $notificationTime = $_POST['notificationTime'];
  }
  else {
    $notificationTime = $_GET['notificationTime'];
  }    
  if (!isset($id) || !isset($notificationTime)) {
    die("ID or time has not been set yet.");
  }
  
  // Check if the id is indeed in the database
  $result = mysqli_query($dbcon, "SELECT * FROM  `auth` WHERE (`id` =  '".$id."')");
  if ($result->num_rows == 0) {
    die ("No such id was found in the database");
  }
     
  // Retrieve all data from the table ordered by time from latest to oldest     
  $data = mysqli_query($dbcon, "SELECT * FROM notification ORDER BY time DESC");
      
  $returnArray = array ();

  // Newer time has a higher value in string comparison 
  // While time retrieved from the application is older than in the database, add the notification
  while ($row = mysqli_fetch_assoc($data)) {
    if ($notificationTime < $row['time']) {
      $returnArray[] = array("time"=>$row['time'], "description"=>$row['description']);
    }
  }
      
  echo json_encode(array ("entries"=>$returnArray));
?>