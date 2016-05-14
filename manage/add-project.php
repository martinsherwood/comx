<?php //include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Project</title>
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

	<h2>Add Post</h2>

	<?php
	
	$LOGO_PATH = "../img/projects/logos/";

	//if form has been submitted process it
	if(isset($_POST['submit'])){

		//collect form data
		extract($_POST);

		//very basic validation
		if($projectTitle ==''){
			$error[] = 'Please enter the title.';
		}

		if($projectDesc ==''){
			$error[] = 'Please enter the description.';
		}

		if($projectCont ==''){
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

		if (!isset($error)) {
			try {
				$projectSlug = slug($projectTitle);
				
				move_uploaded_file($logo["tmp_name"], $LOGO_PATH); //if this does not work check php.ini upload_max_filesize setting

				//insert into database
				$stmt = $db->prepare('INSERT INTO projects (projectTitle, projectSlug, projectLogo, projectDesc, projectCont, projectWebsite, projectFacebook, projectTwitter, projectYoutube) VALUES (:projectTitle, :projectSlug, :projectLogo, :projectDesc, :projectCont, :projectWebsite, :projectFacebook, :projectTwitter, :projectYoutube)') ;
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
				));
				
				$projectID = $db->lastInsertId();
                
                //add categories
                if (is_array($catID)) {
                    foreach($_POST['catID'] as $catID){
                        $stmt = $db->prepare('INSERT INTO project_link_cats (projectID, catID)VALUES(:projectID, :catID)');
                        $stmt->execute(array(
                            ':projectID' => $projectID,
                            ':catID' => $catID
                        ));
                    }
                }
				
				//echo "<pre>"; echo "POST:"; print_r($_POST); echo "FILES:"; print_r($_FILES); echo "</pre>";
				
				//redirect to index page
				header('Location: index.php?action=added');
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

	<form action="" method="post" enctype="multipart/form-data">

		<label>Title *</label>
		<input type='text' name='projectTitle' value='<?php if(isset($error)){ echo $_POST['projectTitle'];}?>'>

		<label>Description *</label>
		<textarea name='projectDesc' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['projectDesc'];}?></textarea>
		
		<label>Logo</label>
		<input type="file" name='projectLogo' id='projectLogo'>

		<label>Content *</label>
		<textarea class="cont" name='projectCont' cols='60' rows='10'><?php if(isset($error)){ echo $_POST['projectCont'];}?></textarea>
        
        <label>Website URL</label>
        <input type='text' name='projectWebsite' value='<?php if(isset($error)){ echo $_POST['projectWebsite'];}?>'>
        
        <label>Facebook Page URL</label>
        <input type='text' name='projectFacebook' value='<?php if(isset($error)){ echo $_POST['projectFacebook'];}?>'>
        
        <label>Twitter Page URL</label>
        <input type='text' name='projectTwitter' value='<?php if(isset($error)){ echo $_POST['projectTwitter'];}?>'>
        
        <label>Youtube Page URL</label>
        <input type='text' name='projectYoutube' value='<?php if(isset($error)){ echo $_POST['projectYoutube'];}?>'>

		<fieldset>
			<legend>Categories</legend>

			<?php	

			$stmt2 = $db->query('SELECT catID, catTitle FROM project_cats ORDER BY catTitle');
			while($row2 = $stmt2->fetch()){

				if(isset($_POST['catID'])){

					if(in_array($row2['catID'], $_POST['catID'])){
                       $checked="checked='checked'";
                    }else{
                       $checked = null;
                    }
				}

			    echo "<input type='checkbox' name='catID[]' value='".$row2['catID']."' > ".$row2['catTitle']."<br />"; //$checked
			}

			?>

		</fieldset>

		<input type='submit' name='submit' value='Submit'>

	</form>

</div>
