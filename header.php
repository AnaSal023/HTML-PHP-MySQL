<>php
session_start();//starts session
echo <<<_INIT
	<!doctype html>
	<html lang="en-US">
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
		table {
		font-size: 1.3em;
		cellpadding: 10px;
		margin-left: auto;
		margin-right: auto;
		width: 95%;
		}
		.center {
			border: 2px solid pink;
			cellpadding: 2;
			cellspacing: 5;
			background-color: lavender;
			font: normal 14px helvetica;	
			margin-left: auto;
			margin-right: auto;
			width: 50%;
		}
		@keyframes spinning
		{ from { transform: rotateY(0deg);} 
		  to { transform: rotateY(180deg);}
		}
		.film {
			animation-name: spinning;
			animation-duration: 3s;
			animation-iteration-count: infinite;
			animation-timing-function: linear;
		}
		.shows {
			animation-name: spinning;
			animation-duration: 3s;
			animation-iteration-count: infinite;
			animation-timing-function: linear;
		}
	</style> <head>
	
_INIT;

	require_once('functions.php');//function file with all PHP functions and connection to the database
	$userstr = 'Welcome Guest';
	//checks if the user is login
	if (isset($_SESSION['username']))
	{
		$user = $_SESSION['username'];
		$loggedin = true;
		$userstr = "Welcome back $user"; 
	}
	else{
		$loggedin = false;
	}
	//head 
	echo <<<_MAIN
		
		<fieldset background-color="lumber" >BCS350 - Ana Salazar</fieldset><br>
		</head>
		<body>
		
		_MAIN;
	//if the user is login it shows the full menu, where user can choose to list records, add or remove records,
	//search a show, set the database, or log out
	if($loggedin)
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
			_LOGGEDIN;
	}
	//if the user is not log in it only shows a menu with a home page, a register page, and a log in page
	else 
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
				<img src="home.jpg" class="film">
			_GUEST;
		}	
?>


