<?php

require_once('header.php');//style, functions, database connection, and menu come from header file

echo "<div font-size='4em' class='center'>Welcome to your watched shows list, ";
if ($loggedin) { 
	echo "$user, you are logged in</div><br>";//checks if the user is log in 
	echo "<img src='shows.jpg' alt class='shows'><br>";
}
else echo "<br>Please <a data-transition='slide'
				href='registration.php?'>sign up</a> or <a data-transition='slide'
				href='login.php?'>log in</a>";

echo <<<_END
</div><br>
</body>
</html>
_END;

?>
