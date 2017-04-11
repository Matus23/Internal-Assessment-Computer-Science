<?php
  // Inlcude 'connect.php' file to connect to the database
  include 'connect.php';
  // Set timezone
  date_default_timezone_set("Europe/Bratislava");
  
  // Retrieve id
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
  }
  else {
    $id = $_GET['id'];
  }
  // Retrieve time
  if (isset($_POST['time'])) {
    $receivedTime = $_POST['time'];
  }
  else {
    $receivedTime = $_GET['time'];  
  }
  if (!isset($id) || !isset($receivedTime)) {
    die("ID or time has not been set yet.");
  }
  
  // Authenticate whether received device ID is in the same as in the databases
  $result = mysqli_query($dbcon, "SELECT * FROM  `auth` WHERE (`id` =  '".$id."') ");
  // If id not found  
  if(mysqli_num_rows($result) == 0) {
    die ("ID is not in the database");
  }
    
  // Contacts
  if(isset($_POST['contactsCheck']) || isset($_GET['contactsCheck']))  {
    // Select data appropriate for the contacts table   
    $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='contacts'");
    // Fetch $result as associative array
    $row = mysqli_fetch_assoc($result);
    // Retrieve the 'latest upload time' from the database
    $lastTime = $row['lastUpdated'];
    // If the time from the database is newer than from the application
    if ($lastTime < $receivedTime) {
      die('There is nothing new to be updated.'.$lastTime.' --- '.$receivedTime);
    }
    
    // Select everything from the chosen table of the database
    $sql = mysqli_query($dbcon, "SELECT * FROM contacts") or die('query failed');
          
		if (isset($_POST['useJson'])) {
	    $returnArray = array();
		  while($row = mysqli_fetch_assoc($sql)) {
        $returnArray[] = array (
		    'name' => $row['name'],
			  'position' => $row['position'],
			  'phone_number' => $row['phone_number'],
			  'email' => $row['email'],
			  'profile_pic' => $row['profile_pic']
        );
      }
			echo json_encode(array ("entries"=>$returnArray));
		}
    else{
      // Get the number of rows of the table
    	$num_rows = mysqli_num_rows($sql);
    	
      if($num_rows >= 1) {
    	  // Retrieve the first row of the table as an associative array (headlines)
    	  $row = mysqli_fetch_assoc($sql);
    	  // Put empty value into the separators
    		$seperator = "";
    		$comma = "";
    			  
    		// Go through the array ($row) 
    		foreach($row as $name => $value) {
    		  $separator .= $comma . '' .str_replace('','""', $name);
    			$comma = ",";
    		}
    		// php separator
    		$separator .="\n";
    			  
    		// Do this for the whole .csv file
    		while($row = mysqli_fetch_assoc($sql)) {
    		  $seperator = "";
    			$comma = "";
    			foreach($row as $name => $value) {
    			  // Do not override the variable, just add to it the new value
    				$separator .= $comma . '' .str_replace('','""', $value);
    				$comma = ",";
    			}
    			// Add a new line in the end
    			$separator .="\n";
    		}
    		// Echo the output
    		echo $separator;
    	}
    }
  }
  // Contestants
  else if(isset($_POST['contestantsCheck']) || isset($_GET['contestantsCheck']))  {
    // Select data appropriate for the contestants table  
    $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='contestants'");
    // Fetch $result as associative array
    $row = mysqli_fetch_assoc($result);
    // Retrieve the 'latest upload time' from the database
    $lastTime = $row['lastUpdated'];
    // If the time from the database is newer than from the application
    if ($lastTime > $receivedTime) {
      die('There is nothing to be updated');
    }
    
    // Select everything from the chosen table of the database
    $sql = mysqli_query($dbcon, "SELECT * FROM contestants") or die('query failed');
      
    if (isset($_POST['useJson'])) {
		  $returnArray = array();
		  while($row = mysqli_fetch_assoc($sql)) {
        $returnArray[] = array (
		    'number' => $row['number'],
			  'position' => $row['position'],
			  'phone_number' => $row['phone_number'],
			  'email' => $row['email'],
			  'profile_pic' => $row['profile_pic']
        );  
        echo json_encode(array ("entries"=>$returnArray));    
      }
    }
    else {
      // Get the number of rows of the table
      $num_rows = mysqli_num_rows($sql);
        
      if($num_rows >= 1) {
        // Retrieve the first row of the table as an associative array (headlines)
        $row = mysqli_fetch_assoc($sql);
        // Put empty value into the separators
        $seperator = "";
        $comma = "";
          
        // Go through the array ($row) 
        foreach($row as $name => $value) {
          $separator .= $comma . '' .str_replace('','""', $name);
          $comma = ",";
        }
        // php separator
        $separator .="\n";
          
        // Do this for the whole .csv file
        while($row = mysqli_fetch_assoc($sql)) {
          $seperator = "";
          $comma = "";
          foreach($row as $name => $value) {
            // Do not override the variable, just add to it the new value
            $separator .= $comma . '' .str_replace('','""', $value);
            $comma = ",";
          }
          // Add a new line in the end
          $separator .="\n";
        }
        // Echo the output
        echo $separator;
      }
    }   
  }
  // Schedule
  else if(isset($_POST['scheduleCheck']) || isset($_GET['scheduleCheck']))  {
    // Select data appropriate for the schedule
    $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='schedule'");
    // Fetch $result as associative array
    $row = mysqli_fetch_assoc($result);
    // Retrieve the 'latest upload time' from the database
    $lastTime = $row['lastUpdated'];
    // If the time from the database is newer than from the application
    if ($lastTime > $receivedTime) {
      die("There is nothing new to be updated");
    }
    
    // Select everything from the chosen table of the database
    $sql = mysqli_query($dbcon, "SELECT * FROM schedule") or die('query failed');
      
    if (isset($_POST['useJson'])) {
    	$returnArray = array();
		  while($row = mysqli_fetch_assoc($sql)) {
        $returnArray[] = array (
		    'date' => $row['date'],
			  'time' => $row['time'],
			  'description' => $row['description'],
			  );
      echo json_encode(array ("entries"=>$returnArray));      
      }
    }
    else {
      // Get the number of rows of the table
      $num_rows = mysqli_num_rows($sql);
       
      if($num_rows >= 1) {
        // Retrieve the first row of the table as an associative array (headlines)
        $row = mysqli_fetch_assoc($sql);
        // Put empty value into the separators
        $seperator = "";
        $comma = "";
        // Go through the array ($row) 
        foreach($row as $name => $value) {
          $separator .= $comma . '' .str_replace('','""', $name);
          $comma = ",";
        }
        // php separator
        $separator .="\n";
        
        // Do this for the whole .csv file
        while($row = mysqli_fetch_assoc($sql)) {
          $seperator = "";
          $comma = "";
          foreach($row as $name => $value) {
            // Do not override the variable, just add to it the new value
            $separator .= $comma . '' .str_replace('','""', $value);
            $comma = ",";
          }
          // Add a new line in the end
          $separator .="\n";
        }
        // Echo the output
        echo $separator;
      }
    }     
  }
  // Map
  else if(isset($_POST['mapCheck']) || isset($_GET['mapCheck']))  {
    // Select appropriate data for the map table
    $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='map'");
    // Fetch $result as associative array
    $row = mysqli_fetch_assoc($result);
    // Retrieve the 'latest upload time' from the database
    $lastTime = $row['lastUpdated'];
    // If the time from the database is newer than from the application
    if ($lastTime < $receivedTime) {
      die('There is nothing to be updated');
    }
    
    // Select everything from the chosen table of the database
    $sql = mysqli_query($dbcon, "SELECT * FROM map") or die('query failed');
      
    if (isset($_POST['useJson'])) {
		  $returnArray = array();
			while($row = mysqli_fetch_assoc($sql)) {
        $returnArray[] = array (
		    'id' => $row['id'],
			  'name' => $row['name'],
			  'description' => $row['description'],
			  'url' => $row['url'],
			  'tags' => $row['tags']
        );
      }
			echo json_encode(array ("entries"=>$returnArray));
		}
    else {
      // Get the number of rows of the table
      $num_rows = mysqli_num_rows($sql);
        
      if($num_rows >= 1) {
        // Retrieve the first row of the table as an associative array (headlines)
        $row = mysqli_fetch_assoc($sql);
        // Put empty value into the separators
        $seperator = "";
        $comma = "";
        // Go through the array ($row) 
        foreach($row as $name => $value) {
          $separator .= $comma . '' .str_replace('','""', $name);
          $comma = ",";
        }
        // php separator
        $separator .="\n";
          
        // Do this for the whole .csv file
        while($row = mysqli_fetch_assoc($sql)) {
          $seperator = "";
          $comma = "";
          foreach($row as $name => $value) {
            // Do not override the variable, just add to it the new value
            $separator .= $comma . '' .str_replace('','""', $value);
            $comma = ",";
          }
          // Add a new line in the end
          $separator .="\n";
        }
        // Echo the output
        echo $separator;
      }
    }     
  }
  // debateSchedule
  else if(isset($_POST['debateScheduleCheck']) || isset($_GET['debateScheduleCheck']))  {
    // Select appropriate data for the debate schedule table  
    $result = mysqli_query($dbcon, "SELECT lastUpdated FROM times WHERE fileName='debateSchedule'");
    // Fetch $result as associative array
    $row = mysqli_fetch_assoc($result);
    // Retrieve the 'latest upload time' from the database
    $lastTime = $row['lastUpdated'];
    // If the time from the database is newer than from the application
    if ($lastTime < $receivedTime) {
      die('There is nothing new to be updated');
    }
    // Select everything from the chosen table of the database
    $sql = mysqli_query($dbcon, "SELECT * FROM debateSchedule") or die('query failed');
    
    // For judge
    if (isset($_POST['judge'])) {
      // Retrieve name of the judge
      $name = $_POST['judge'];
      // Select row where received time and name of judge are the same as in the table
      $sql = mysqli_query($dbcon, "SELECT classroom, teamA, teamB FROM debateSchedule WHERE ((judge1 = '".$name."') or (judge2 = '".$name."') or (judge3 = '".$name."'))");
      if ($sql->num_rows == 0) {
        die ("Judge was not found");
      }
       
      if (isset($_POST['useJson'])) {
      	$returnArray = array();
        while($row = mysqli_fetch_assoc($sql)) {
          $returnArray[] = array (
    		    'classroom' => $row['classroom'],
    			  'teamA' => $row['teamA'],
    			  'teamB' => $row['teamB'],
    			);
        }
        echo json_encode(array ("entries"=>$returnArray));   		
      }
      else {
        // Get the number of rows of the table
        $num_rows = mysqli_num_rows($sql);
          
        if($num_rows >= 1) {
          // Retrieve the first row of the table as an associative array (headlines)
          $row = mysqli_fetch_assoc($sql);
          // Put empty value into the separators
          $seperator = "";
          $comma = "";
          // Go through the array ($row) 
          foreach($row as $name => $value) {
            $separator .= $comma . '' .str_replace('','""', $name);
            $comma = ",";
          }
          // php separator
          $separator .="\n";
            
          // Do this for the whole .csv file
          while($row = mysqli_fetch_assoc($sql)) {
            $seperator = "";
            $comma = "";
            foreach($row as $name => $value) {
              // Do not override the variable, just add to it the new value
              $separator .= $comma . '' .str_replace('','""', $value);
              $comma = ",";
            }
            // Add a new line in the end
            $separator .="\n";
          }
          // Echo the output
          echo $separator;
        }
      }
    }
    // For contestant
    else if (isset($_POST['team'])) {
      // Retrieve name of the judge
      $team = $_POST['team'];
      $contA = mysqli_query($dbcon, "SELECT teamA FROM debateSchedule WHERE teamA = '".$team."'");
      $contB = mysqli_query($dbcon, "SELECT teamB FROM debateSchedule WHERE teamB = '".$team."'");
      //$sql = mysqli_query($dbcon, "SELECT classroom, teamA, teamB FROM debateSchedule WHERE ((judge1 = '".$name."') or (judge2 = '".$name."') or (judge3 = '".$name."'))");
      echo $contA;
      echo $contB;
      if ($contA->num_rows == 0 && $contB->num_rows == 0) {
        die("Contestant's team was not found");
      }
      if (!$contA->num_rows == 0 && !$contB->num_rows == 0) {
        die("Contestant found in more than one team");
      }
      // Contestant found in team A
      if (!$contA->num_rows == 0 && $contB->num_rows == 0) {
        $sql = mysqli_query($dbcon, "SELECT classroam, teamB FROM debateSchedule WHERE teamA = '".$team."'");
      }
      // Contestant found in team B
      else {
        $sql = mysqli_query($dbcon, "SELECT classroam, teamA FROM debateSchedule WHERE teamB = '".$team."'");  
      }
      echo $sql; 
      if (isset($_POST['useJson'])) {
      	$returnArray = array();
  		  while($row = mysqli_fetch_assoc($sql)) {
          $returnArray[] = array (
    		    'classroom' => $row['classroom'],
    			  'teamA' => $row['teamA'],
    			  'teamB' => $row['teamB'],
    			);
        }
        echo json_encode(array ("entries"=>$returnArray));   		
      }
      else {
        // Get the number of rows of the table
        $num_rows = mysqli_num_rows($sql);
          
        if($num_rows >= 1) {
          // Retrieve the first row of the table as an associative array (headlines)
          $row = mysqli_fetch_assoc($sql);
          // Put empty value into the separators
          $seperator = "";
          $comma = "";
          // Go through the array ($row) 
          foreach($row as $name => $value) {
            $separator .= $comma . '' .str_replace('','""', $name);
            $comma = ",";
          }
          // php separator
          $separator .="\n";
            
          // Do this for the whole .csv file
          while($row = mysqli_fetch_assoc($sql)) {
            $seperator = "";
            $comma = "";
            foreach($row as $name => $value) {
              // Do not override the variable, just add to it the new value
              $separator .= $comma . '' .str_replace('','""', $value);
              $comma = ",";
            }
            // Add a new line in the end
            $separator .="\n";
          }
          // Echo the output
          echo $separator;
        }
      }    
    }   
  }      
?>                  