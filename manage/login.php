<?php
//include config
require_once("../includes/config.php");

//check if already logged in
if ($user->is_logged_in()) { header("Location: index.php"); } 
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div id="login">

	<?php

	//process login form if submitted
	if(isset($_POST["submit"])){

		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		
		if ($user->login($username, $password)){ 
			//logged in return to index page
			header("Location: index.php");
			exit;
		} else {
			$message = '<p class="error">Wrong username or password</p>';
		}

	}//end if submit

	if (isset($message)) { echo $message; }
	?>
    
    <h1>COMX Login</h1>
	<form action="" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" value="">

        <label for="password">Password</label>
        <input type="password" name="password" value="">

        <input type="submit" name="submit" value="Login">
	</form>

</div>
</body>
</html>