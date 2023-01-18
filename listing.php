	<?php
  require_once('header.php');//style, functions, database connection, and menu come from header file
	if (!$loggedin){//checks if the user is log in
		 echo "Please <a href='login.php'>Click Here</a> to log in.";
	}

  //query that selects everything from the watched and producer table with a left join 
  $query  = "SELECT * FROM watched left join producer on watched.producerID = producer.producerID;";
  
  $result = $connection->query($query);
  if (!$result) die("Fatal Error");
  //converts result into rows
  $rows = $result->num_rows;

	echo "<br><h3>Shows</h3>";

	//creates a table 
	echo '<table border="1" width = "400" ><tr>';
	echo '<th bgcolor="thistle" style="text-align:center">ShowID</th>';
    echo '<th bgcolor="thistle" style="text-align:center">Title</th>';
    echo '<th bgcolor="thistle" style="text-align:center">Genre</th>';
    echo '<th bgcolor="thistle" style="text-align:center">Year</th>';
    echo '<th bgcolor="thistle" style="text-align:center">ProducerID</th>';
	echo '<th bgcolor="thistle" style="text-align:center">ProducerID</th>';
    echo '<th bgcolor="thistle" style="text-align:center">First Name</th>';
    echo '<th bgcolor="thistle" style="text-align:center">Last Name</th>';
	echo '</tr>';
  //prints every record of the watched table each on a row
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_ASSOC);
	echo '<tr>';
    echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['showID']) . '</td>';
    echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['title']) . '</td>';
    echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['genre']) . '</td>';
    echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['year']) . '</td>';
    echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['producerID']) . '</td>';
	echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['producerID']) . '</td>';
    echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['fname']) . '</td>';
    echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['lname']) . '</td>';
	echo '</tr>';
  }
	
  $result->close();
 
  $connection->close();
?>

</body>
</html>
