<?php require('includes/config.php');

$stmt = $db->prepare('SELECT * FROM projects WHERE projectSlug = :projectSlug');
$stmt->execute(array(':projectSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['projectID'] == ''){
	header('Location: projects.php');
	exit;
}

?>

<!doctype html>
<html class="no-js" lang="en-GB">
    <head>
        <meta charset="utf-8">
        
        <link rel="dns-prefetch" href="//ajax.googleapis.com">
        <link rel="dns-prefetch" href="//player.vimeo.com">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <title><?php echo $row['projectTitle'];?></title>
        
        <meta name="description" content="University of Gloucestershire COMX Exhibition">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
		<?php include_once ("includes/cookies.php"); ?>
		
		<main id="page" class="page-wrapper">
            
            <?php include ("includes/header.php"); ?>
            
            <div id="page-content">
                <div class="inner-wrap content-block">
                    <div id="project-information" class="content">
                        <!--<a href="projects">Back to projects</a>-->
                        <?php	
                            echo '<div class="proj-top">';
								echo '<div>';
						
                                echo '<h1>'.$row['projectTitle'].'</h1>';
									//cats
                                    $stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM project_cats, project_link_cats WHERE project_cats.catID = project_link_cats.catID AND project_link_cats.projectID = :projectID');
                                    $stmt2->execute(array(':projectID' => $row['projectID']));
                                    $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
									
										echo '<div class="proj-cats">';
											$links = array();
											foreach ($catRow as $cat) {
												$links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
											}
											echo implode(", ", $links);
										echo '</div>';
										
										//these needs an if = "", do not display on them
										echo '<ul class="proj-social">';
											echo '<li><a href="'. $row['projectWebsite'] .'" class="icon fa fa-globe" target="_blank"></a></li>';
											echo '<li><a href="'. $row['projectFacebook'] .'" class="icon fa fa-facebook" target="_blank"></a></li>';
											echo '<li><a href="'. $row['projectTwitter'] .'" class="icon fa fa-twitter" target="_blank"></a></li>';
											echo '<li><a href="'. $row['projectYoutube'] .'" class="icon fa fa-youtube" target="_blank"></a></li>';
										echo '</ul>';
						
									echo '</div>'; //inner div for .proj-top
						
									echo '<img src=img/projects/logos/' . $row['projectLogo'] . ' alt="' . $row['projectTitle'] . '">';
						
                            echo '</div>'; //proj-top
						
                            //project desc
                            echo '<p id="short-desc">'.$row['projectDesc'].'</p>';	
							
							//main content
							echo '<div class="proj-content">'.$row['projectCont'].'</div>';	
							
							
                            //echo '</div>';
                        ?>
						<h2>Meet the team</h2>
						<!--THIS SECTION IS INCOMPLETE ON THE DATABASE SIDE:

							It needs a students table, with their bio and skills, the skills should be seperate like the project categories and an intersection table used for the references
							The code/functionality is basically the same as used for the projects and their associated categories.
							
						-->
						
						<div id="the-team">
							<div class="member">
								<img class="photo" src="img/students/default.png" alt="Their name from the database">
								<div>
									<h3>Sarah Smith</h3>
									<h4>Web Designer</h4>
									<span class="skills"><a href="#">web</a>, <a href="#">html5 animation</a>, <a href="#">graphic design</a>, <a href="#">microsoft office</a></span>
									<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.</p>
								</div>
							</div>
						</div><!--/the-team-->
						
                    </div><!--/project-info-->
                </div><!--/content-block-->
            </div><!--/page-content-->
			
            <?php include ("includes/footer.php"); ?>
			
		</main>
        
        <!--mobile navigation is off side-->
		<?php include ("includes/mobilenav.php"); ?>
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    
    </body>
</html>