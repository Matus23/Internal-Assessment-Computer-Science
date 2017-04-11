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
  // Include 'connect.php' to login to the database
  include 'connect.php';

  // Download contacts table
  if(isset($_POST['contactsDownload']) || isset($_GET['contactsDownload']))  {
           
    // Select everything from the contacts table 
    $result = mysqli_query($dbcon, "SELECT * FROM contacts") or die('query failed');
    // Get the number of rows of the table
    $num_rows = mysqli_num_rows($result);
    // Check if table is not empty
    if($num_rows == 0) {
      die ('Contacts table is empty');
    }   
      
    // Retrieve the first row of the table as an associative array (headlines)
    $row = mysqli_fetch_assoc($result);
    // Open the file in "write-mode"
    $file_open = fopen($filename,"w");
    // Initialize the separators as empty
    $seperator = "";
    $comma = "";
        
    // Go through the whole row of data 
    foreach($row as $name => $value) {
      $separator .= $comma . '' .str_replace('','""', $name);
      $comma = ",";
    }
    
    // Go to the next line
    $separator .="\n";
    // Write to the open file
    fputs($file_open, $separator);
        
    // Do this for the whole file 
    while($row = mysqli_fetch_assoc($result)) {
      $seperator = "";
      $comma = "";
      foreach($row as $name => $value) {
        $separator .= $comma . '' .str_replace('','""', $value);
        $comma = ",";
      }
      // Add a new line in the end
      $separator .="\n";
      fputs($file_open, $separator);
    }
    // The file has been successfully processed, echo it
    echo $separator;
        
    // Close the file
    fclose($file_open);  
  }
    
  // Download contestants table
  else if(isset($_POST['contestantsDownload']) || isset($_GET['contestantsDownload']))  {
                                    
    // Select everything from the contestants table
    $result = mysqli_query($dbcon, "SELECT * FROM contestants") or die('query failed');
    // Get the number of rows of the table
    $num_rows = mysqli_num_rows($result);
    // Check if table is not empty
    if($num_rows == 0) {
      die('Contestants table is empty');
    }
      
    // Retrieve the first row of the table as an associative array (headlines)
    $row = mysqli_fetch_assoc($result);
    // Open the file in "write-mode"
    $file_open = fopen($filename,"w");
    // Initialize the separators as empty 
    $seperator = "";
    $comma = "";
       
    // Go through the whole row of data 
    foreach($row as $name => $value) {
      $separator .= $comma . '' .str_replace('','""', $name);
      $comma = ",";
    }
    
    // Go to the next line
    $separator .="\n";
    // Write to the open file
    fputs($file_open, $separator);
        
    // Do this for the whole file
    while($row = mysqli_fetch_assoc($result)) {
      $seperator = "";
      $comma = "";
      foreach($row as $name => $value) {
        // Do not override the variable, just add to it the new value
        $separator .= $comma . '' .str_replace('','""', $value);
        $comma = ",";
      }
      // Add a new line in the end
      $separator .="\n";
      fputs($file_open, $separator);
    }
    
    // The file has been successfully processed, echo it
    echo $separator;
    // Close the file
    fclose($file_open);  
  }
  
  // Download schedule table
  else if (isset($_POST['scheduleDownload']) || isset($_GET['scheduleDownload']))  {
                                    
    // Select everything from the table 'schedule'
    $result = mysqli_query($dbcon, "SELECT * FROM schedule") or die('query failed');
    // Get the number of rows of the table
    $num_rows = mysqli_num_rows($result);
    // Check if table is not empty
    if($num_rows == 0) {
      die('Schedule table is empty');
    }
    
    // Retrieve the first row of the table as an associative array (headlines)
    $row = mysqli_fetch_assoc($result);
    // Open the file in "write-mode"
    $file_open = fopen($filename,"w");
    // Initialize the separators as empty
    $seperator = "";
    $comma = "";
        
    // Go through the whole row 
    foreach($row as $name => $value) {
      $separator .= $comma . '' .str_replace('','""', $name);
      $comma = ",";
    }
    
    // Go to the next line
    $separator .="\n";
    // Write to the open file
    fputs($file_open, $separator);
        
    // Do this for the whole file
    while($row = mysqli_fetch_assoc($result)) {
      $seperator = "";
      $comma = "";
      foreach($row as $name => $value) {
        $separator .= $comma . '' .str_replace('','""', $value);
        $comma = ",";
      }
      // Add a new line in the end
      $separator .="\n";
      fputs($file_open, $separator);
    }
    
    // The file has been successfully processed
    echo $separator;
    // Close the file
    fclose($file_open);  
  }

  // Download table map
  else if (isset($_POST['mapDownload']) || isset($_GET['mapDownload']))  {
       
    // Select everything from the chosen table of the database
    $result = mysqli_query($dbcon, "SELECT * FROM map") or die('query failed');
    // Get the number of rows of the table
    $num_rows = mysqli_num_rows($result);
    // Check if table is not empty
    if($num_rows == 0) {
      die('Map table is empty');
    }    
    
    // Retrieve the first row of the table as an associative array (headlines)
    $row = mysqli_fetch_assoc($result);
    // Open the file in "write-mode"
    $file_open = fopen($filename,"w");
    // Initialize the separators as empty
    $seperator = "";
    $comma = "";
          
    // Go through the whole row
    foreach($row as $name => $value) {
      $separator .= $comma . '' .str_replace('','""', $name);
      $comma = ",";
    }
    
    // Go to the next line
    $separator .="\n";
    // Write to the open file
    fputs($file_open, $separator);
         
    // Do this for the whole .csv file
    while($row = mysqli_fetch_assoc($result)) {
      $seperator = "";
      $comma = "";
      foreach($row as $name => $value) {
        $separator .= $comma . '' .str_replace('','""', $value);
        $comma = ",";
      }
      // Add a new line in the end
      $separator .="\n";
      fputs($file_open, $separator);
    }
    
    // The file has been successfully processed
    echo $separator;
    // Close the file
    fclose($file_open);  
  }
  
  // Download table debate schedule
  else if (isset($_POST['debateScheduleDownload']) || isset($_GET['debateScheduleDownload']))  {
                               
    // Select everything from the chosen table of the database
    $result = mysqli_query($dbcon, "SELECT * FROM debateSchedule") or die('query failed');
    // Get the number of rows of the table
    $num_rows = mysqli_num_rows($result);
    // Check if table is not empty
    if($num_rows == 0) {
      die('Debate schedule table is empty');
    }
    
    // Retrieve the first row of the table as an associative array (headlines)
    $row = mysqli_fetch_assoc($result);
    // Open the file in "write-mode"
    $file_open = fopen($filename,"w");
    // Initialize the separators as empty
    $seperator = "";
    $comma = "";
    
    // Go through the whole row 
    foreach($row as $name => $value) {
      $separator .= $comma . '' .str_replace('','""', $name);
      $comma = ",";
    }
    
    // Go to the next line
    $separator .="\n";
    // Write to the open file
    fputs($file_open, $separator);
    
    // Do this for the whole file
    while($row = mysqli_fetch_assoc($result)) {
      $seperator = "";
      $comma = "";
      foreach($row as $name => $value) {
        $separator .= $comma . '' .str_replace('','""', $value);
        $comma = ",";
      }
      // Add a new line in the end
      $separator .="\n";
      fputs($file_open, $separator);
    }
    
    // The file has been successfully processed
    echo $separator;
    // Close the file
    fclose($file_open);
  }  
  
  // File was not recognized
  else {
    die('File was not recognized in request');
  }  
?>