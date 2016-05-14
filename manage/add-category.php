<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Category</title>
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<p><a href="categories.php">Manage Categories</a></p>

	<h2>Add Category</h2>

	<?php

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		$_POST = array_map("stripslashes", $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($catTitle ==''){
			$error[] = 'Please enter the Category.';
		}

		if(!isset($error)){

			try {

				$catSlug = slug($catTitle);

				//insert into database
				$stmt = $db->prepare('INSERT INTO project_cats (catTitle,catSlug) VALUES (:catTitle, :catSlug)') ;
				$stmt->execute(array(
					':catTitle' => $catTitle,
					':catSlug' => $catSlug
				));

				//redirect to index page
				header('Location: categories.php?action=added');
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

	<form action="" method='post'>

		<label>Title</label>
		<input type='text' name='catTitle' value='<?php if(isset($error)){ echo $_POST['catTitle'];}?>'></p>

		<input type='submit' name='submit' value='Submit'>

	</form>

</div>
