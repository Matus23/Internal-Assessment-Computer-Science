<form method="post" action="main_menu.php">
  <input type="submit" name="backToLoginPage" value="Get back to the main menu">
</form>

<?php  
  // Include 'connnect.php' to connect to the database
  include 'connect.php';
  
  if(isset($_POST['publish']) || isset($_GET['publish'])) {
    $sql = mysqli_query($dbcon,"INSERT INTO debateSchedule SELECT * FROM debateScheduleUnpublished");
  }
  if($sql) {
    die('The table was successfully published');  
  }
  die('The table could no be inserted');
?>

