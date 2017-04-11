<?php
  // Start the session
  session_start();
  
  //include 'connect.php' to connect to the database
  include 'connect.php';
  
  // If the user has performed action
  if (isset($_POST['username'])) {
  
    // Retrieve log-in variables from the user
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Get log-in data from the database 
    $sql = mysqli_query($dbcon, "SELECT * FROM login WHERE username = '".$username."' AND password='".$password."' LIMIT 1") or die("Query failed");
    
    // Only one log-in can be correct
    if (mysqli_num_rows($sql) == 1) {
      $row = mysqli_fetch_assoc($sql);
      
      // Set session variables
      $_SESSION['login'] = $row['id'];
      $_SESSION['username'] = $row['username'];
      $_SESSION['timestamp'] = time();  
      // Direct the user to the main menu page
      header("Location: main_menu.php");
      exit();
    }
    else {
      echo "Invalid login information. Please return to the previous page."; ?>
      <form method="post" action="index.php">
        <input type="submit" name="backToLoginPage" value="Get back to the login page">
      </form>
<?php     
    }
  }
?>