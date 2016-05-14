<?php require("includes/config.php"); ?>

<!doctype html>
<html class="no-js" lang="en-GB">
    <head>
        <meta charset="utf-8">
        
        <link rel="dns-prefetch" href="//ajax.googleapis.com">
        <link rel="dns-prefetch" href="//player.vimeo.com">
        
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
        <title>COMX</title>
        
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
                    <div class="content">
                        <h1>Projects</h1>
                        <p id="proj-intro">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
                        <div id="project-container">
                            <?php
                                try {

                                    $pages = new Paginator('1','p'); //or if you want them paginated put the number to split at

                                    $stmt = $db->query('SELECT projectID FROM projects');

                                    //pass number of records to
                                    $pages->set_total($stmt->rowCount());

                                    $stmt = $db->query('SELECT projectID, projectTitle, projectSlug, projectLogo, projectDesc FROM projects ORDER BY projectID DESC '.$pages->get_limit());
                                    while($row = $stmt->fetch()){
										echo '<div class="project">';
										
											echo '<img class="project-logo" src=img/projects/logos/' . $row['projectLogo'] . ' alt="' . $row['projectTitle'] . '">';
										
											echo '<div>';
												
												//echo '<div class="project-details">';
											
                                            		echo '<h2 class="project-title">' . $row['projectTitle'] . '</h2>';
												
														$stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM project_cats, project_link_cats WHERE project_cats.catID = project_link_cats.catID AND project_link_cats.projectID = :projectID');
														$stmt2->execute(array(':projectID' => $row['projectID']));
														$catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);
										
															/*echo '<div class="project-cats">';
																$links = array();
																foreach ($catRow as $cat) {
																	$links[] = "<a href='c-" . $cat['catSlug'] . "'>" . $cat['catTitle'] . "</a>";
																}
																echo implode(", ", $links);
															echo '</div>';*/
										
												//echo '</div>'; //close .project-details
										
													echo '<div class="project-cats">';
														$links = array();
														foreach ($catRow as $cat) {
															$links[] = "<a href='c-" . $cat['catSlug'] . "'>" . $cat['catTitle'] . "</a>";
														}
														echo implode(", ", $links);
													echo '</div>';
										
										
                                            	echo '<span class="project-desc">' . $row['projectDesc'] . '</span>';
												
                                            	echo '<a class="project-view button" href="' . $row['projectSlug'] . '">Go to ' . $row['projectTitle'] .'</a>';
												
											echo '</div>'; // close first div in .project
										
										echo '</div>'; //close .project
                                    }

                                    echo $pages->page_links(); //page selection if any

                                } catch(PDOException $e) {
                                    echo $e->getMessage();
                                }
                            ?>
                            
                            
                            <!--
                                <h2 >Project Title</h2>
                                <img class="project-logo" src="img/project-logos/zeus.png" alt="Project Image">
                                <p >Cloud based project management for you and your business. Providing simple, powerful metrics for accurately measuring how your projects run.</p>
                                <a  href="#"><i class="fa fa-chevron-right"></i></a>
                            -->
                        </div>
                    </div>
                </div>
            </div>
			
            <?php include ("includes/footer.php"); ?>
			
		</main>
        
        <!--mobile navigation is off side-->
		<?php include ("includes/mobilenav.php"); ?>
		
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC6n-3I8KfH6ReeERae16W5M8B1QtzjPGc"></script>
        
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>
    
    </body>
</html>
