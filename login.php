<?php
require_once('header.php');//style, functions, database connection, and menu come from header file
$error = $username = $password = "";//sets the values to default value

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//sanitize data
	$username = fix_string($_POST['username']);
	$password = fix_string($_POST['password']);
	//if username and password are empty
	if($username == "" || $password == "")
	{
		$error = 'Not all fields were entered';
	}
	else {//if a username and password has been entered it checks the users table 
		$query = "SELECT * FROM users WHERE username='$username'";
		$result = queryMysql($query);
		if (!$result) { $error = "Invalid login attempt"; }//if the username was not found
		elseif ($result->num_rows){//if the username was found it gets the username and password
			$row = $result->fetch_array(MYSQLI_NUM);
			$result->close();
			if (password_verify($password, $row[2])){//if the password is correct
				$_SESSION['username'] = $username;//starts session
				setcookie('username', $username, time()+60*60*24*7, '/');//sets cookie to username
				die("<p><br>You are now logged in. Please <a data-transition='slide'
				href='index.php?view=$username'> click here </a>to continue.</div><p></body></html>");	//gives user a link to go to the main page		
			}
			else //if the password/username is invalid it lets user try again
				die("Invalid username/password combination<br><br>
				<a data-transition='slide'
				href='login.php?'>Try Again</a>");
			
		}
	}
}
	//login form
	echo <<<_END
      <br><form class='center' method='post' action='login.php'>
        <div data-role='fieldcontain'>
          <label></label>
          <span class='error'>$error</span><!-- prints error message-->
        </div>
        <div data-role='fieldcontain'>
          <label></label>
          Please enter your details to log in
        </div><br>
        <div data-role='fieldcontain'>
          <label>Username</label>
          <input type='text' maxlength='16' name='username' value='$username'>
        </div><br>
        <div data-role='fieldcontain'>
          <label>Password</label>
          <input type='password' maxlength='16' name='password' value='$password'>
        </div><br>
        <div data-role='fieldcontain'>
          <label></label>
          <input data-transition='slide' type='submit' value='Login'>
        </div>
      </form>
    </div>
  </body>
</html>
_END;

  ?>
