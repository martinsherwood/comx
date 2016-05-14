<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add User</title>
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="users.php">Manage Users</a></p>

	<h2>Add User</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($username ==''){
			$error[] = 'Please enter the username.';
		}

		if($password ==''){
			$error[] = 'Please enter the password.';
		}

		if($passwordConfirm ==''){
			$error[] = 'Please confirm the password.';
		}

		if($password != $passwordConfirm){
			$error[] = 'Passwords do not match.';
		}

		if($email ==''){
			$error[] = 'Please enter the email address.';
		}

		if(!isset($error)){

			$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

			try {

				//insert into database
				$stmt = $db->prepare('INSERT INTO comx_members (username,password,email) VALUES (:username, :password, :email)') ;
				$stmt->execute(array(
					':username' => $username,
					':password' => $hashedpassword,
					':email' => $email
				));

				//redirect to index page
				header('Location: users.php?action=added');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo '<p class="error">'.$error.'</p>';
		}
	}
	?>

	<form action='' method='post'>

		<label>Username</label>
		<input type='text' name='username' value='<?php if(isset($error)){ echo $_POST['username'];}?>'>

		<label>Password</label>
		<input type='password' name='password' value='<?php if(isset($error)){ echo $_POST['password'];}?>'>

		<label>Confirm Password</label>
		<input type='password' name='passwordConfirm' value='<?php if(isset($error)){ echo $_POST['passwordConfirm'];}?>'>

		<label>Email</label>
		<input type='text' name='email' value='<?php if(isset($error)){ echo $_POST['email'];}?>'>
		
		<input type='submit' name='submit' value='Add User'>

	</form>

</div>
