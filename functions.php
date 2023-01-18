<?php
//connecting to the database
  $hn = 'localhost';
  $db2 = 'shows';
  $un = 'jim';
  $pw = 'mypasswd';
  $connection = new mysqli($hn, $un, $pw, $db2);
  if ($connection->connect_error) die("Fatal Error" . $connection->connect_error);
  
   // The PHP functions
  function validate_email($field)//php validation of email 
	{
		//checks the require characters the email must have and that data has been entered
    if ($field == "") return "No Email was entered<br>";
      else if (!((strpos($field, ".") > 0) &&
                 (strpos($field, "@") > 0)) ||
                  preg_match("/[^a-zA-Z0-9.@_-]/", $field))
        return "The Email address is invalid<br>";
    return "";
  }
  
  function validate_username($field)//php validation of username
  {
	  //makes sure the username is 5 characters long and doe not contain most special characters
    if ($field == "") return "No Username was entered<br>";
    else if (strlen($field) < 5)
      return "Usernames must be at least 5 characters<br>";
    else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
      return "Only letters, numbers, - and _ in usernames<br>";
    return "";		
  }
  
  function validate_password($field)//php validation of password
  {
	  //checks that only letters and numbers are entered
	  //the password must be 6 characters long 
	  //and have at least one capital, and lower case letter as well as a number
    if ($field == "") return "No Password was entered<br>";
    else if (strlen($field) < 6)
      return "Passwords must be at least 6 characters<br>";
    else if (!preg_match("/[a-z]/", $field) ||
             !preg_match("/[A-Z]/", $field) ||
             !preg_match("/[0-9]/", $field))
      return "Passwords require 1 each of a-z, A-Z and 0-9<br>";
    return "";
  }
  function validate_cpassword($field1, $field2)//php validation of confirm password
  {
	  //checks that the password and confirm password are the same
	if ($field1 == "") return "No Confirm Password was entered<br>";
	else if ($field1 != $field2) return "Passwords are not the same<br>";
	else if($field1 == $field2) return "";
  }
  function fix_string($string)//sanitize string function
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return htmlentities ($string);
  }
  
   function add_user($conn, $e, $un, $pw)//adds user to the users table using a prepare statement
	{
		$stmt = $conn->prepare("INSERT INTO users VALUES(?,?,?);");
		$stmt->bind_param('sss', $e, $un, $pw);
		$stmt->execute();
		$stmt->close();
	}
	function add_show($conn, $showID, $title, $genre, $year, $producerID)//adds a show to the watched table using a prepare statement
	{
		$stmt = $conn->prepare("INSERT INTO watched VALUES(?,?,?,?,?);");
		$stmt->bind_param('issii', $showID, $title, $genre, $year, $producerID);
		$stmt->execute();
		if (!$stmt) echo "INSERT failed<br><br>";
		$stmt->close();
	}
  if(isset($_POST['logout'])){//if logout is press it logs user out 
    $logout = destroy_session_and_data();}
	
  function destroy_session_and_data()//destroy session and cookies
  {
    $_SESSION = array();
    setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
  }
  function queryMysql($query)//takes a query parameter and runs it
  {
	global $connection;
	$r = $connection->query($query);
	if (!$r) die("Faltal error");
	return $r;
  }
  function mysql_entities_fix_string($connection, $string)//sanitize string
  {
    return htmlentities(mysql_fix_string($connection, $string));
  }	

  function mysql_fix_string($connection, $string)//sanitize string
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return $connection->real_escape_string($string);
  }
  function get_post($connection, $var)//get the variable and connects to the database
  {
    return $connection->real_escape_string($_POST[$var]);
  }
  
?>
