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
  // Set the default time zone
  date_default_timezone_set("Europe/Bratislava");
  // Include 'connect.php' to connect to the database
  include 'connect.php';
  
  // User wants to update contacts table 
  if(isset($_POST['contactsUpload'])) {
    $temporaryName = $_FILES['contacts']['tmp_name'];
    $uploadType = $_FILES['contacts']['type'];
    $fileSize = $_FILES['contacts']['size'];
    
    // Check file size
    if ($fileSize > 1250000) {
      die ("The file is too big to be uploaded.");
    }                                                     
    
    // Open file in "read only" state
    $handle = fopen($temporaryName,"r");
    
    // If successfully opened
    if ($handle) {
      // While return csv field in array
      while (($fileop = fgetcsv($handle,1000,","))!=false) {
        $name = $fileop[0];
        $position = $fileop[1];
        $phone_number = $fileop[2];
        $email = $fileop[3];
        $profile_pic = $fileop[4]; 
        // Insert into the contacts table values from the file 
        $sql = mysqli_query($dbcon, "INSERT INTO contacts (name,position,phone_number,email,profile_pic) 
               VALUES ('$name','$position','$phone_number','$email','$profile_pic')");
      }
      if (!$sql) {
        die('Query to insert selected file into contacts table failed');
      }
                                    
      // The file was successfully uploaded
      echo "Contacts file was successfully uploaded at: ";  
      
      // Update the 'latest upload time' in the table
      $contactsTime = date('Y-m-d H:i:s', time());         
      echo $contactsTime;
      // Store the value of updated time in the table of the database
      mysqli_query($dbcon, "UPDATE times SET lastUpdated='$contactsTime' WHERE fileName='contacts'");    
    }
    else {
      die("The Contacts file could not be opened.");
    }
  }
  // User wants to update contestants table
  else if(isset($_POST['contestantsUpload'])) {
    $temporaryName = $_FILES['contestants']['tmp_name'];
    $uploadType = $_FILES['contestants']['type'];
    $fileSize = $_FILES['contestants']['size'];
    
    // Check file size
    if ($fileSize > 125000) {
      die ("The file is too big to be uploaded.");
    } 
    
    // open file in "read only" state
    $handle = @fopen($temporaryName,"r");
    
    if ($handle) {
      
      // while return csv field in array
      while (($fileop = fgetcsv($handle,1000,","))!=false) {
        $number = $fileop[0];
        $team = $fileop[1];
        $speaker = $fileop[2];
        $email = $fileop[3];
        $W1 = $fileop[4];
        $B1 = $fileop[5];
        $SP1A = $fileop[6];
        $SP1B = $fileop[7];
        $SP1C = $fileop[8];
        $W2 = $fileop[9];
        $B2 = $fileop[10];
        $SP2A = $fileop[11];
        $SP2B = $fileop[12];
        $SP2C = $fileop[13];
        $W3 = $fileop[14];
        $B3 = $fileop[15];
        $SP3A = $fileop[16];
        $SP3B = $fileop[17];
        $SP3C = $fileop[18];
        $W4 = $fileop[19];
        $B4 = $fileop[20];
        $SP4A = $fileop[21];
        $SP4B = $fileop[22];
        $SP4C = $fileop[23];
        $W5 = $fileop[24];
        $B5 = $fileop[25];
        $SP5A = $fileop[26];
        $SP5B = $fileop[27];
        $SP5C = $fileop[28];
        $W6 = $fileop[29];
        $B6 = $fileop[30];
        $SP6A = $fileop[31];
        $SP6B = $fileop[32];
        $SP6C = $fileop[33];
        $W = $fileop[34];
        $B = $fileop[35];
        $SP_team = $fileop[36];
        $SP_indiv = $fileop[37];
        $SP_average = $fileop[38];
        $numberOfDebates = $fileop[39]; 
        
        $sql = mysqli_query($dbcon, "INSERT INTO contestants 
        (number,team,speaker,email,W1,B1,SP1A,SP1B,SP1C,W2,B2,SP2A,SP2B,SP2C,
         W3,B3,SP3A,SP3B,SP3C,W4,B4,SP4A,SP4B,SP4C,W5,B5,SP5A,SP5B,SP5C,W6,B6,
         SP6A,SP6B,SP6C,W,B,SPteam,SPindiv,SPAverage,NumberOfDebates) 
        VALUES ('$number','$team','$speaker','$email','$W1','$B1','$SP1A','$SP1B','$SP1C',
        '$W2','$B2','$SP2A','$SP2B','$SP2C','$W3','$B3','$SP3A','$SP3B','$SP3C',
        '$W4','$B4','$SP4A','$SP4B','$SP4C','$W5','$B5','$SP5A','$SP5B','$SP5C',
        '$W6','$B6','$SP6A','$SP6B','$SP6C','$W','$B','$SP_team','$SP_indiv',
        '$SP_average','$numberOfDebates')");
      }
      if (!$sql) {
        die('Query to insert selected file into contestants table failed');
      }
      // The file was successfully uploaded
      echo "The contestants table was successfully uploaded at: ";  
      
      // Update the 'latest upload time'
      $contestantsTime = date('Y-m-d H:i:s', time());
      echo $contestantsTime;
      // Store the value of updated time in the table of the database
      mysqli_query($dbcon, "UPDATE times SET lastUpdated='$contestantsTime' WHERE fileName='contestants'");    
    }
    else {
      die("The Contestants table could not be opened.");
    }
  }
  // User wants to update map table
  else if (isset($_POST['mapUpload'])) {
    $temporaryName = $_FILES['map']['tmp_name'];
    $uploadType = $_FILES['map']['type'];
    $fileSize = $_FILES['map']['size'];
    
    // Check file size
    if ($fileSize > 125000) {
      die ("The file is too big to be uploaded.");
    } 
    
    // open file in "read only" state
    $handle = @fopen($temporaryName,"r");
    
    if ($handle) {
      // while return csv field in array
      while (($fileop = fgetcsv($handle,1000,","))!=false) {
          
        $id = $fileop[0];
        $name = $fileop[1];
        $description = $fileop[2];
        $url = $fileop[3];
        $tags = $fileop[4];
        
        $sql = mysqli_query($dbcon, "INSERT INTO map (id,name,description,url,tags) 
                                     VALUES ('$id','$name','$description','$url','$tags')");
      }
      if (!$sql) {
        die('Query to insert selected file into contestants table failed');     
      }
        // The file was successfully uploaded
        echo "Map file was uploaded";  
        
        // Update the 'latest upload time'
        $mapTime = date('Y-m-d H:i:s', time());
        echo $mapTime;
        // Store the value of updated time in the table of the database
        mysqli_query($dbcon, "UPDATE times SET lastUpdated='$mapTime' WHERE fileName='map'");    
    }
    else {
      die("The Schedule file could not be opened.");
    }      
  }
  
  // User wants to update schedule table
  else if (isset($_POST['scheduleUpload'])) {
    $temporaryName = $_FILES['schedule']['tmp_name'];
    $uploadType = $_FILES['schedule']['type'];
    $fileSize = $_FILES['schedule']['size'];
    
    // Check file size
    if ($fileSize > 125000) {
      die ("The file is too big to be uploaded.");
    } 
    
    // open file in "read only" state
    $handle = @fopen($temporaryName,"r");
    
    if ($handle) {
      // while return csv field in array
      while (($fileop = fgetcsv($handle,1000,","))!=false) {
        $date = $fileop[0];
        $time = $fileop[1];
        $description = $fileop[2];
        
        $sql = mysqli_query($dbcon, "INSERT INTO schedule (date,time,description) VALUES ('$date','$time','$description')");
      }
      if (!$sql) {
        die('Query to insert selected file into contestants table failed');        
      }
      // The file was successfully uploaded
      echo "Schedule file was uploaded";  
      
      // Update the 'latest upload time'
      $scheduleTime = date('Y-m-d H:i:s', time());
      echo $scheduleTime;
      // Store the value of updated time in the table of the database
      mysqli_query($dbcon, "UPDATE times SET lastUpdated='$scheduleTime' WHERE fileName='schedule'");                    
    }   
    else {
      die("The Schedule file could not be opened.");
    }
  }
  
  // User wants to update debate schedule table
  else if (isset($_POST['debateScheduleUpload'])) {                                              
    $temporaryName = $_FILES['debateSchedule']['tmp_name'];
    $uploadType = $_FILES['debateSchedule']['type'];
    $fileSize = $_FILES['debateSchedule']['size'];
    
    // Check file size
    if ($fileSize > 125000) {
      die ("The file is too big to be uploaded.");
    } 
    
    // open file in "read only" state
    $handle = @fopen($temporaryName,"r");
    
    if ($handle) {
      // while return csv field in array
      while (($fileop = fgetcsv($handle,1000,","))!=false) {
        $time = $fileop[0];
        $classroom = $fileop[1];
        $teamA = $fileop[2];
        $teamB = $fileop[3];
        $judge1 = $fileop[4];
        $judge2 = $fileop[5];
        $judge3 = $fileop[6];
        
        $sql = mysqli_query($dbcon, "INSERT INTO debateScheduleUnpublished (time,classroom,teamA,teamB,judge1,judge2,judge3) 
                                     VALUES ('$time','$classroom','$teamA','$teamB','$judge1','$judge2','$judge3')");
      }
      if (!$sql) {
        die('Query to insert selected file into contestants table failed');
      }
      // The file was successfully uploaded
      echo "Debate schedule file was uploaded";  
               
      // Update the 'latest upload time'
      $debateScheduleTime = date('Y-m-d H:i:s', time());
      echo $debateScheduleTime;
      // Store the value of updated time in the table of the database
      mysqli_query($dbcon, "UPDATE times SET lastUpdated='$debateScheduleTime' WHERE fileName='debateSchedule'");                       
    }
    else {
      die("The Debate schedule file could not be opened.");
    }
  }
  
  // The file was not recognized
  else {
    echo ("File not recognized in the request");
  }
?>