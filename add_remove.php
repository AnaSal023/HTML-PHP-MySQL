	<?php
  require_once('header.php');//style, functions, database connection, and menu come from header file
		
	//checks  that the user is login to access the page
	if (!$loggedin){
		 echo "Please <a href='login.php'>Click Here</a> to log in.";
	}
	//if the user press delete it gets the showID and removes the record from the table
     if (isset($_POST['delete']) && isset($_POST['showID']))
	  {
		$showID   = get_post($connection, 'showID');
		$query  = "DELETE FROM watched WHERE showID='$showID'; ";
		$result = $connection->query($query);
		if (!$result) echo "DELETE failed<br><br>";
	  }
	  //if the user adds a record
  if ( isset($_POST['showID']) &&
	  isset($_POST['title'])   &&
      isset($_POST['genre'])    &&
      isset($_POST['year']) &&
      isset($_POST['producerID']))
  {
	//sanitize input data
    $showID   		= fix_string($_POST['showID']);
    $title    		= fix_string($_POST['title']);
    $genre 	 		= fix_string($_POST['genre']);
    $year    		= fix_string($_POST['year']);
    $producerID     = fix_string($_POST['producerID']);
	//uses the add show funtion to add the show to the watched table
	$stmt = add_show($connection, $showID, $title, $genre, $year, $producerID);
    
  }
//form with text field so the user can enter the data to add a show
  echo <<<_END
  <h2>Add a Show</h2>
  <form action="add_remove.php" method="post"><pre>
	Show ID      <input type="text" name="showID" ><br>
	Title 	     <input type="text" name="title" ><br>
	Genre        <input type="text" name="genre" ><br>
	Release Year <input type="text" name="year" ><br>
	Producer ID  <input type="text" name="producerID" ><br>
    <input type="submit" value="ADD RECORD">
  </pre></form><br></body>
</html>
_END;
//prints all the shows in the watched table and prints a delete button for user to delete a record
	echo '<h2>Delete a Show</h2>';
  $query  = "SELECT * FROM watched";
  $result = $connection->query($query);
  if (!$result) die ("Database access failed");

  $rows = $result->num_rows;

 for ($j = 0 ; $j < $rows ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_NUM);

    $r0 = htmlspecialchars($row[0]);
    $r1 = htmlspecialchars($row[1]);
    $r2 = htmlspecialchars($row[2]);
    $r3 = htmlspecialchars($row[3]);
	$r4 = htmlspecialchars($row[4]);
	
    echo '<br><fieldset>';
    echo <<<_END
  <pre><center>Show ID:&emsp;$r0
      Title:&emsp;$r1
      Genre:&ensp;$r2
      Year:&ensp;$r3
      Productor ID:&ensp;$r4  
  </pre>
  <form action='add_remove.php' method='post'>
  <input type='hidden' name='delete' value='yes'>
  <input type='hidden' name='showID' value='$r0'></center>
  <input type='submit' value='DELETE RECORD'></form><br>
  _END;
echo '</fieldset>';
	
  }

  $result->close();
  $connection->close();

  
?>
