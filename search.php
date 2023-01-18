<?php
require_once('header.php');	//style, functions, database connection, and menu come from header file
if(!$loggedin) {//checks if the user is log in
		 echo "Please <a href='login.php'>Click Here</a> to log in.";
	}
//search form - with a drop down list to let the user choose which value they want to enter and search the show
//the user will not be ask to enter every field only the one they choose from the list 
echo <<<_END
<table class="center"> 
 <th colspan="2" align="center"> Search Shows </th>
 <form action="search.php" method="post" onclick"text(this.value)">
		
		
		<tr><td colspan="2" align="center"><select size="1" class="form-control option" name="option">
		<option value=""> Select an option </option>
		<option value="title"> Title </option>
		<option value="genre"> Genre </option>
		<option value="year"> Release Year </option>
		<option value="producerID"> ProducerID </option>
		</select></tr></td>
		<tr><td  align="right"><label>Enter Title </label></td>
		<td><input type="text" name="title" class="form-control title"  /></td><br></tr>
		<tr><td  align="right"><label>Enter Genre </label></td>
		<td><input type="text" name="genre" class="form-control genre"  /></td><br></tr>
		<tr><td align="right"><label>Enter Release Year </label></td>
		<td><input type="text" name="year" class="form-control year"  /></td><br></tr>
		<tr><td align="right"><label>Enter Producer ID </label></td>
		<td><input type="text" name="producerID" class="form-control producerID"  /></td><br></tr>
		<tr><td colspan="2" align="center">
			<input type="hidden" name="choice" value="" class="form-control" required />
			<input type="submit" name="search" value="Search" /></td></tr>
		</form>
	  </table><br><br>
	  <script>
	  <!--Javascript -->
		  function text(val)<!-- Function to get variable text -->
		  {
			var t = val;
			 document.getElementsByName("element").value=t;
		  }
			$(document).ready(function() <!-- Function to allow user to enter only the select value from the list -->
			{
				$('.option').on('change',function()){
				
					if($('.option').find(":selected").text() === "author"){
						$('.title').attr('readonly', true);
						$('.genre').attr('readonly', false);
						$('.year').attr('readonly', false);
						$('.producerID').attr('readonly', false);
						$('.choice').val('1');
					}
					else if($('.option').find(":selected").text() === "genre"){
						$('.title').attr('readonly', false);
						$('.genre').attr('readonly', true);
						$('.year').attr('readonly', false);
						$('.producerID').attr('readonly', false);
						$('.choice').val('2');
					}
					else if($('.option').find(":selected").text() === "year") {
						$('.title').attr('readonly', false);
						$('.genre').attr('readonly', false);
						$('.year').attr('readonly', true);
						$('.producerID').attr('readonly', false);
						$('.choice').val('3');
					}
					else if($('.option').find(":selected").text() === "producerID"){
						$('.title').attr('readonly', false);
						$('.genre').attr('readonly', false);
						$('.year').attr('readonly', false);
						$('.producerID').attr('readonly', true);
						$('.choice').val('4');
					});
			});
			</script>
	  </body>
	  </html>
_END;
//if the user clicks search 
if(isset($_POST['search'])){

	$success = [];

	//sanitize user's input data with PHP function
	$option = $_POST['option'];
	$title = fix_string($_POST['title']);
	$genre =fix_string($_POST['genre']);
	$year = fix_string($_POST['year']);
	$producerID = fix_string($_POST['producerID']);
	$choice = $_POST['choice'];//gets the value the user choice
	$data =  array();
	//checks if the user's selection is empty
	if($option == "" && $choice == ""){
		echo "Option should not be empty!";
		
	}
	//if user's option is not empty
	else{
		if($option == 'title' )//if the option is title prints the show with that title if found
		{
		$query = "select * from watched where title='$title'";
		$result = $connection->query($query);
		$rows = $result->num_rows;
			echo '<table border="1" width = "400" ><tr>';
			echo '<th bgcolor="thistle" style="text-align:center">ShowID</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Title</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Genre</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Year</th>';
			echo '<th bgcolor="thistle" style="text-align:center">ProducerID</th>';
			echo '</tr>';
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			echo '<tr>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['showID']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['title']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['genre']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['year']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['producerID']) . '</td>';
			echo '</tr>';
		  }
		if (!$result) echo "Search failed<br><br>";
	  }
	  else if ($option == 'genre')//if the option is genre it prints the show or shows with that genre if found
	  {
		$query = "select * from watched where genre='$genre'";
		$result = $connection->query($query);
		$rows = $result->num_rows;
			echo '<table border="1" width = "400" ><tr>';
			echo '<th bgcolor="thistle" style="text-align:center">ShowID</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Title</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Genre</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Year</th>';
			echo '<th bgcolor="thistle" style="text-align:center">ProducerID</th>';
			echo '</tr>';
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			echo '<tr>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['showID']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['title']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['genre']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['year']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['producerID']) . '</td>';
			echo '</tr>';
		}
		if (!$result) echo "Search failed<br><br>";
	  }
	  else if ($option == 'year')//if the option is release year it prints the show or shows with that release year if found
	  {
		$query = "select * from watched where year='$year'";
		$result = $connection->query($query);
		$rows = $result->num_rows;
			echo '<table border="1" width = "400" ><tr>';
			echo '<th bgcolor="thistle" style="text-align:center">ShowID</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Title</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Genre</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Year</th>';
			echo '<th bgcolor="thistle" style="text-align:center">ProducerID</th>';
			echo '</tr>';
		for ($j = 0 ; $j < $rows ; ++$j)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			echo '<tr>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['showID']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['title']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['genre']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['year']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['producerID']) . '</td>';
			echo '</tr>';
		}
		if (!$result) echo "Search failed<br><br>";
	  }
	  else if ($option == 'producerID')//if option is producer id prints the show or show with that producer id if found
	  {
		$query = "select * from watched where producerID='$producerID'";
		$result = $connection->query($query);
		$rows = $result->num_rows;
			echo '<table border="1" width = "400" ><tr>';
			echo '<th bgcolor="thistle" style="text-align:center">ShowID</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Title</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Genre</th>';
			echo '<th bgcolor="thistle" style="text-align:center">Year</th>';
			echo '<th bgcolor="thistle" style="text-align:center">ProducerID</th>';
			echo '</tr>';
		 for ($j = 0 ; $j < $rows ; ++$j)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			echo '<tr>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['showID']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['title']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['genre']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['year']) . '</td>';
			echo '<td bgcolor="pink" style="text-align:center">' . htmlspecialchars($row['producerID']) . '</td>';
			echo '</tr>';
		}
		if (!$result) echo "Search failed<br><br>";
	  }
	}	
}
		
?>
