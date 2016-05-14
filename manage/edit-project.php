<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Edit Project</title>
  <link rel="stylesheet" href="../css/main.css">
  <script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
  <script>
          tinymce.init({
              selector: "textarea.cont",
              plugins: [
                  "advlist autolink lists link image charmap print preview anchor",
                  "searchreplace visualblocks code fullscreen",
                  "insertdatetime media table contextmenu paste"
              ],
              toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
          });
  </script>
</head>
<body>

<div id="wrapper">

	<?php include('menu.php');?>
	<a href="./">Manage Projects</a>

	<h2>Edit Project</h2>


	<?php
    
    $LOGO_PATH = "../img/projects/logos/";

	//if form has been submitted process it
	if(isset($_POST['submit'])){

        //$_POST = array_map( 'stripslashes', $_POST );

		//collect form data
		extract($_POST);

		//very basic validation
		if($projectID == ''){
			$error[] = 'This project is missing a valid id!.';
		}

		if($projectTitle == ''){
			$error[] = 'Please enter the title.';
		}

		if($projectDesc == ''){
			$error[] = 'Please enter the description.';
		}

		if($projectCont == ''){
			$error[] = 'Please enter the content.';
		}
        
        $logo = $_FILES["projectLogo"];
        
        //use default if not provided
        if (empty($_FILES["projectLogo"]["name"])) {
            $newFilename = "default.png";
        } else {
            //strip the file extension and name for rename (basename is the filename before any changes)
            $logoBasename = substr($logo["name"], 0, strripos($logo["name"], "."));
            $logoExtension = substr($logo["name"], strripos($logo["name"], "."));

            //generate a unique ID for the file
            $uniqueID = uniqid();

            //rename with md5 hashtag and the generated unique ID ("$newFilename" is the new filename to be inserted into the database)
            $newFilename = md5($logoBasename) . $uniqueID . $logoExtension;

            //clean the filename using regex
            $newFilename = preg_replace("/[^\w\.]/", "", strtolower($newFilename));

            //build the full string for the target path
            $LOGO_PATH .= $newFilename;
        }

		if(!isset($error)){

			try {

				$projectSlug = slug($projectTitle);

				//insert into database
				$stmt = $db->prepare('UPDATE projects SET projectTitle = :projectTitle,
                                                          projectSlug = :projectSlug,
                                                          projectDesc = :projectDesc,
                                                          projectLogo = :projectLogo,
                                                          projectCont = :projectCont,
                                                          projectWebsite = :projectWebsite,
                                                          projectFacebook = :projectFacebook,
                                                          projectTwitter = :projectTwitter,
                                                          projectYoutube = :projectYoutube
                                      WHERE projectID = :projectID');
				$stmt->execute(array(
					':projectTitle' => $projectTitle,
					':projectSlug' => $projectSlug,
					':projectDesc' => $projectDesc,
                    ':projectLogo' => $newFilename,
					':projectCont' => $projectCont,
                    ':projectWebsite' => $projectWebsite,
                    ':projectFacebook' => $projectFacebook,
                    ':projectTwitter' => $projectTwitter,
                    ':projectYoutube' => $projectYoutube,
					':projectID' => $projectID
				));

				//delete all items with the current projectID
				$stmt = $db->prepare('DELETE FROM project_link_cats WHERE projectID = :projectID');
				$stmt->execute(array(':projectID' => $projectID));

                //var_dump($catID);
                
				if (is_array($catID)) {
					foreach($_POST['catID'] as $catID){
						$stmt = $db->prepare('INSERT INTO project_link_cats (projectID, catID) VALUES (:projectID, :catID)');
						$stmt->execute(array(
							':projectID' => $projectID,
							':catID' => $catID
						));
					}
				}
                
                //echo "<pre>"; echo "POST:"; print_r($_POST); echo "FILES:"; print_r($_FILES); echo "</pre>";
                
				//redirect to index page
				header('Location: index.php?action=updated');
				exit;

			} catch(PDOException $e) {
			    echo $e->getMessage();
			}

		}

	}

	?>


	<?php
	//check for any errors
	if(isset($error)){
		foreach($error as $error){
			echo $error.'<br />';
		}
	}

		try {

			$stmt = $db->prepare('SELECT projectID, projectTitle, projectDesc, projectCont, projectWebsite, projectFacebook, projectTwitter, projectYoutube FROM projects WHERE projectID = :projectID') ;
			$stmt->execute(array(':projectID' => $_GET['id']));
			$row = $stmt->fetch(); 

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}

	?>

	<form action='' method='post' enctype="multipart/form-data">
		<input type='hidden' name='projectID' value='<?php echo $row['projectID']; ?>'>

		<label>Title</label>
		<input type='text' name='projectTitle' value='<?php echo $row['projectTitle']; ?>'>

		<label>Description</label>
		<textarea name='projectDesc' cols='60' rows='10'><?php echo $row['projectDesc']; ?></textarea>
        
        <label>Logo</label>
		<input type="file" name='projectLogo' id='projectLogo' value="">

		<label>Content</label>
		<textarea class="cont" name='projectCont' cols='60' rows='10'><?php echo $row['projectCont'];?></textarea>
        
        <label>Website URL</label>
        <input type='text' name='projectWebsite' value='<?php echo $row['projectWebsite']; ?>'>
        
        <label>Facebook Page URL</label>
        <input type='text' name='projectFacebook' value='<?php echo $row['projectFacebook']; ?>'>
        
        <label>Twitter Page URL</label>
        <input type='text' name='projectTwitter' value='<?php echo $row['projectTwitter']; ?>'>
        
        <label>YouTube Page URL</label>
        <input type='text' name='projectYoutube' value='<?php echo $row['projectYoutube']; ?>'>

		<fieldset>
			<legend>Categories</legend>

			<?php

			$stmt2 = $db->query('SELECT catID, catTitle FROM project_cats ORDER BY catTitle');
			while($row2 = $stmt2->fetch()){

				$stmt3 = $db->prepare('SELECT catID FROM project_link_cats WHERE catID = :catID AND projectID = :projectID') ;
				$stmt3->execute(array(':catID' => $row2['catID'], ':projectID' => $row['projectID']));
				$row3 = $stmt3->fetch(); 

				if($row3['catID'] == $row2['catID']){
					$checked = 'checked=checked';
				} else {
					$checked = null;
				}

			    echo "<input type='checkbox' name='catID[]' value='".$row2['catID']."' $checked> ".$row2['catTitle']."<br />";
			}

			?>

		</fieldset>

		<input type='submit' name='submit' value='Update'>

		

	</form>

</div>

</body>
</html>	
