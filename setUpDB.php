<html>
<head>
<style><!-- Style of the page-->
        html { background-color: lavenderblush; }
		body {
			text-align: center;
			size: 40px;
			background-color: lavenderblush;
			height: 1000px;
			font-size: 15px;
		}
        fieldset { color: indigo; }
		td { color: navy; }
		p {
			font-size: 1.5em;
			cellpadding: 10px;
			margin-left: auto;
			margin-right: auto;
			width: 50%;
		}
		nav {
		display: table;
		width: 100%;
		margin: auto;
		float: none;
		background-color: thistle;
		font-weight: bold;
		}
		nav ul {
		height: 20%;
		display: table-row;
		}
		nav ul li {
		display: table-cell;
		width: 15%;
		border: thin solid rgba(190, 80, 120,2.00);
		border-collapse: collapse;
		font-size: 1.5em;
		}
		nav ul li a {
		color: black;
		text-decoration: none;
		display: block;
		margin: 5px 5px 5px 5px;
		vertical-align: middle;
		line-height: 1.5;
		text-align: center;
		}
</style>
</head>

<?php

session_start();
if (isset($_SESSION['username']))//checks if user is log in 
	{
		$user = $_SESSION['username'];
		$loggedin = true; 
	}
else $loggedin = false;
if($loggedin)//if users is log in allows user to set up the database
	{
		echo <<<_LOGGEDIN
				<header>
				<nav>
					<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="setupDB.php">Set Up Page</a></li>
					<li><a href="add_remove.php">Add and Remove Shows</a></li>
					<li><a href="search.php">Search Show</a></li>
					<li><a href="listing.php">Listing Shows</a></li>
					<li><a href="logout.php">Log Out</a></li>
					</ul>
				  </nav>
				</header>
				<h1>Welcome to your watched shows list</h1>
				<h3> Setting up database </h3>
				</form>
			_LOGGEDIN;
//connect to mysql using root to create the shows database and give the user jim permission to it
	$server = 'localhost';
	$user = 'root';
	$pss = 'mysql';
	$connection = new mysqli($server, $user, $pss);
	if ($connection->connect_error) die("Fatal Error" . $connection->connect_error);
	
	$sql = "CREATE DATABASE IF NOT EXISTS shows;";
	$sql .= "GRANT ALL PRIVILEGES ON `shows`.* TO `jim`@`localhost`;";
	$r = $connection->multi_query($sql);
	if (!$r) die ("Database access failed");
	$connection->close();
	
//connects to mysql using jim user, creates the tables and populates them
	$hn = 'localhost';
	$un = 'jim';
	$pw = 'mypasswd';
	$db2 = 'shows';
	$conn = new mysqli($hn, $un, $pw, $db2);
	if ($conn->connect_error) die("Fatal Error" . $conn->connect_error);
	$query = "CREATE TABLE IF NOT EXISTS watched (
			showID INT NOT NULL ,
			title VARCHAR(128) NOT NULL,
			genre VARCHAR(128),
			year INT,
			producerID INT NOT NULL,
			PRIMARY KEY(showID) 
			); ";
		
	$query .= "CREATE TABLE IF NOT EXISTS producer (
			producerID INT NOT NULL,
			fname VARCHAR(128) NOT NULL,
			lname VARCHAR(128) NOT NULL,
			PRIMARY KEY(producerID)
			); " ;
	
	$query .= "CREATE TABLE IF NOT EXISTS users(
			email  VARCHAR(32) NOT NULL,
			username VARCHAR(32) NOT NULL UNIQUE PRIMARY KEY,
			password VARCHAR(100) NOT NULL
			);";
	
	$query .= "INSERT INTO producer (producerID, fname, lname) VALUES(1, 'Ryan', 'Condal');";
	
	$query .= "INSERT INTO producer (producerID, fname, lname) VALUES(2, 'Sam', 'Levison');";
	
	$query .= "INSERT INTO producer (producerID, fname, lname) VALUES(3, 'Mark', 'Gatiss');";
	
	$query .= "INSERT INTO producer (producerID, fname, lname) VALUES(4, 'Michael', 'Waldron');";
	
	$query .= "INSERT INTO producer (producerID, fname, lname) VALUES(5, 'Lauren', 'Schmidt');";
	
	$query .= "INSERT INTO producer (producerID, fname, lname) VALUES(6, 'Kevin', 'Lafferty');";
		
	$query .= "INSERT INTO watched(showID, title, genre, year, producerID) VALUES(1, 'House of Dragons', 
			'Fantasy', '2022', 1);";
			
	$query .= "INSERT INTO watched(showID, title, genre, year, producerID) VALUES(2, 'Euphoria', 
			'Drama', '2019', 2);";
			
	$query .= "INSERT INTO watched(showID, title, genre, year, producerID) VALUES(3, 'Sherlock', 
			'Crime', '2010', 3);";
			
	$query .= "INSERT INTO watched(showID, title, genre, year, producerID) VALUES(4, 'Loki', 
			'Action', '2021', 4);";
			
	$query .= "INSERT INTO watched(showID, title, genre, year, producerID) VALUES(5, 'The Witcher', 
			'Fantasy', '2019', 5);";
			
	$query .= "INSERT INTO watched(showID, title, genre, year, producerID) VALUES(6, 'The Umbrella Academy', 
			'Action Fiction', '2019', 6);";

	$result = $conn->multi_query($query);
	
	if (!$result) die("Fatal Error");
	else echo "<br><br><p>Database and tables successfully created</p>";
	$conn->close(); 
	}
	else //if users is not log in it tell them to log in
	{
		echo <<<_GUEST
				<header>
				<nav>
					<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="registration.php">Register</a></li>
					<li><a href="login.php">Log In</a></li>
					</ul>
				  </nav>
				</header>
				<p> (You must logged in to use this website) </p>
			
			_GUEST;
	}
?>
</body>
</html>
