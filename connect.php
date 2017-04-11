<?php
  // Set paramaters required to log in to the database
  $hosting ="mysql.hostinger.co.uk";
  $databaseUsername ="u663984006_admin";
  $databasePassword ="TBwMHaIFTlVdjMt6as";
  $database ="u663984006_data";
  
  // Connect to the database with appropriate parameters
  $dbcon = mysqli_connect($hosting,$databaseUsername,$databasePassword,$database) or die(mysql_error());                                                         
?>