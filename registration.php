<?php
require_once('header.php');//requires header file that shows the menu 

	$email = $username = $password = $cpass = "";//makes the field blank

	
	 echo <<<_END
	  
	<!-- JavaScript section -->
    <script>
      function validate(form)
      {
        fail = validateUsername(form.username.value)
        fail += validatePassword(form.password.value)
        fail += validateEmail(form.email.value)
		fail += validateCPassword(form.cpass.value, form.password.value)
      
        if (fail == "")     return true
        else { alert(fail); return false }
      }

      function validateUsername(field)
      {
        if (field == "") return "No Username was entered.\n"
        else if (field.length < 5)
          return "Usernames must be at least 5 characters.\\n"
        else if (/[^a-zA-Z0-9_-]/.test(field))
          return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames.\\n"
        return ""
      }

      function validatePassword(field)
      {
        if (field == "") return "No Password was entered.\\n"
        else if (field.length < 6)
          return "Passwords must be at least 6 characters.\\n"
        else if (!/[a-z]/.test(field) || ! /[A-Z]/.test(field) ||
                 !/[0-9]/.test(field))
          return "Passwords require one each of a-z, A-Z and 0-9.\\n"
        return ""
      }
 
      function validateEmail(field)
      {
        if (field == "") return "No Email was entered.\\n"
          else if (!((field.indexOf(".") > 0) &&
                     (field.indexOf("@") > 0)) ||
                    /[^a-zA-Z0-9.@_-]/.test(field))
            return "The Email address is invalid.\\n"
        return ""
      }
	  
	  function validateCPassword(field1, fiedl2){
		  if (field == "") return "No Confirm Password was entered.\\n"
		  else if (field1 != field2) return "Passwords are not the same.\\n"
		  else return ""
	  }
	</script>

_END; 

if (isset($_SESSION['username'])) destroy_session_and_data();//if the user is login in, it logs out



$checkuser ="";

//sanitize the data that the user entered
  if (isset($_POST['email']))
    $email = fix_string($_POST['email']);
  if (isset($_POST['username']))
    $username = fix_string($_POST['username']);
  if (isset($_POST['password']))
    $password = fix_string($_POST['password']);
  if (isset($_POST['cpass']))
    $cpass = fix_string($_POST['cpass']);
//validates the input data with php functions
  $fail  = validate_email($email);
  $fail .= validate_username($username);
  $fail .= validate_password($password);
  $fail .= validate_cpassword($cpass, $password);

	//if it passed the php validations
	if ($fail == "")
	{
		$result = queryMysql("SELECT * from users WHERE username='$username'");
		//checks that the username does not exist
		if(mysqli_num_rows($result)>0){
			$checkuser =  "<span color='red'><br>Sorry, the following errors were found<br>
			  in your form: That username already exists</span><br><br>";
			  
		}
		else {//if it doesnt exist it addes it to the database with a hash and salted password
			$hash = password_hash($password, PASSWORD_DEFAULT);
			add_user($connection, $email, $username, $hash);
			die("<body><br><h4>Account created</h4><br>
			Please Log In</body></html>");
			exit;
		}
		
	}
echo <<<_END
<!-- registration form is print in the form of a table --> 
			<table class="center">
			  <th colspan="2" align="center"><br></th>
				
			  <form method="post" action="registration.php" onSubmit="return validate(this)" ><!-- validate(this) checks the input data with javascript functions -->
				<font color=red size=1><br><i>$fail</i></font>
				<tr><td>Email</td>
				<td><input type="text" maxlength="64" name="email" value="$email">
				</td></tr>
				<tr><td>Username</td><div data-role='fieldcontain'>
				  <td><input type="text" maxlength="16" name="username" value="$username" >
				</td><br><td>$checkuser</td></tr>
				<tr><td>Password</td>
				  <td><input type="password" maxlength="12" name="password" value="$password" >
				</td><td><div data-role='fieldcontain'></tr>
				<tr><td>Confirm Password</td>
				  <td><input type="password" maxlength="12" name="cpass" value="$cpass">
				</td></tr><tr><td colspan="2" align="center"><input type="submit"
				  value="Signup"></td></tr>
			  </form>
		</table>
		</body>
		</html>
_END;

  ?>
