<?php
require_once('header.php');//style, functions, database connection, and menu come from header file
//checks if the user is log in
if(isset($_SESSION['username']))
{
	//destroy the session and gives user link to refresh the page
	destroy_session_and_data();
	echo "<br><div class='center'>You have been logged out. Please
         <a data-transition='slide' href='index.php'>click here</a>
         to refresh the screen.</div>";
  }
  else echo "<div class='center'>You cannot log out because
             you are not logged in</div>";//if the user is not log in it prints a message to the user

?>
  </div>
  </body>
</html>
