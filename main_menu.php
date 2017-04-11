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

<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="style.css" />
  <meta http-equiv="Content-Type" content="text/html"; charset="utf-8" />
  <title>Main menu</title>
</head>

<body>
  <div class="fileTransfer">
    <div class="moveToCenter">
      <p> Contacts:  Last updated: 
        <?php
          $dbcon = mysqli_connect("mysql.hostinger.co.uk", "u663984006_admin", "TBwMHaIFTlVdjMt6as","u663984006_data") or die(mysql_error());
          $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='contacts'");
          $row = mysqli_fetch_assoc($result);
          $lastTime = $row['lastUpdated'];
          echo $lastTime;
        ?>
      </p>
      <!-- Select a file which the user decides to upload to the appropriate table in the database based on 
      the 'name' value. In this case, the selected .csv file will be uploaded to contacts table-->
      <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="contacts" >                  
        <input type="submit" name="contactsUpload" value="Upload">
      </form>
      <form method="post" action="download.php">    
        <input type="submit" name="contactsDownload" value="Download">
        <br />
      </form>

      <p> Contestants table:  Last updated:
        <?php
          $dbcon = mysqli_connect("mysql.hostinger.co.uk", "u663984006_admin", "TBwMHaIFTlVdjMt6as","u663984006_data") or die(mysql_error());
          $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='contestants'");
          $row = mysqli_fetch_assoc($result);
          $lastTime = $row['lastUpdated'];
          echo $lastTime;
        ?>  
      </p>
      <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="contestants" >                  
        <input type="submit" name="contestantsUpload" value="Upload">
      </form>
      <form method="post" action="download.php">    
        <input type="submit" name="contestantsDownload" value="Download">
        <br />
      </form>
            
      <p> Schedule:  Last updated:  
        <?php
          $dbcon = mysqli_connect("mysql.hostinger.co.uk", "u663984006_admin", "TBwMHaIFTlVdjMt6as","u663984006_data") or die(mysql_error());
          $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='schedule'");
          $row = mysqli_fetch_assoc($result);
          $lastTime = $row['lastUpdated'];
          echo $lastTime;
        ?>          
      </p>
      <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="schedule" >                  
        <input type="submit" name="scheduleUpload" value="Upload">
      </form>
      <form method="post" action="download.php">    
        <input type="submit" name="scheduleDownload" value="Download">
        <br /> 
      </form>
       
      <p> Map: Last updated: 
        <?php
          $dbcon = mysqli_connect("mysql.hostinger.co.uk", "u663984006_admin", "TBwMHaIFTlVdjMt6as","u663984006_data") or die(mysql_error());
          $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='map'");
          $row = mysqli_fetch_assoc($result);
          $lastTime = $row['lastUpdated'];
          echo $lastTime;    
        ?>
      </p>
      <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="map">
        <input type="submit" name="mapUpload" value="Upload">
      </form>
      <form method="post" action="download.php">
        <input type="submit" name="mapDownload" value="Download">
        <br />
      </form>
         
      <p> Debate schedule:  Last updated:  
        <?php
          $dbcon = mysqli_connect("mysql.hostinger.co.uk", "u663984006_admin", "TBwMHaIFTlVdjMt6as","u663984006_data") or die(mysql_error());
          $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='debateSchedule'");
          $row = mysqli_fetch_assoc($result);
          $lastTime = $row['lastUpdated'];
          echo $lastTime;
        ?>          
      </p>
      <!-- Clicking on 'Upload' button with input type 
      'submit' will give signal to upload.php-->
      <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="debateSchedule" >                  
        <input type="submit" name="debateScheduleUpload" value="Upload">
      </form>
      <!-- Clicking on 'Download' button with input type 
      'submit' will give signal to download.php-->
      <form method="post" action="download.php">    
        <input type="submit" name="debateScheduleDownload" value="Download">
        <br />
      </form> 
      <!-- Clicking on 'Publish' button with input type 
      'submit' will give signal to publish.php-->
      <div class="publishButton">
        <form method="post" action="publish.php">
          <input type="submit" name="publish" value="Publish">
          <br />
        </form>    
      </div>
      <!-- Clicking on 'Send notification' button with input type 
      'submit' will give signal to notification_panel.php-->
      <form method="post" action="notification_panel.php">
        <input type ="text" name="push_message">
        <input type ="submit" name="notification" value ="Send notification">
        <br />
      </form>  
      <!-- Clicking on 'Log out' button with input type 
      'submit' will give signal to logout_parse.php-->      
      <div class="logoutButton">
        <form method="post" action="logout_parse.php">
          <input type="submit" name="logout" value="Log out">
        </form>
      </div>
    </div>  
  </div>      
</body>
</html>