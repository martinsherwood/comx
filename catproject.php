<?php require('includes/config.php'); 


$stmt = $db->prepare('SELECT catID, catTitle FROM project_cats WHERE catSlug = :catSlug');
$stmt->execute(array(':catSlug' => $_GET['id']));
$row = $stmt->fetch();

//if post does not exists redirect user.
if($row['catID'] == ''){
	header('Location: ./');
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
        
        <title><?php echo $row['catTitle'];?></title>
        
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
                <div id="cat-sort" class="inner-wrap content-block">
                    <div class="content">
                        <h1>Projects related to <?php echo $row['catTitle'];?></h1>
                        <a href="projects">Back to projects</a>
                        <?php	
                            try {

                                $pages = new Paginator('999','p');

                                $stmt = $db->prepare('SELECT projects.projectID FROM projects, project_link_cats WHERE projects.projectID = project_link_cats.projectID AND project_link_cats.catID = :catID');
                                $stmt->execute(array(':catID' => $row['catID']));

                                //pass number of records to
                                $pages->set_total($stmt->rowCount());

                                $stmt = $db->prepare('
                                    SELECT 
                                        projects.projectID, projects.projectTitle, projects.projectSlug, projects.projectDesc
                                    FROM 
                                        projects,
                                        project_link_cats
                                    WHERE
                                         projects.projectID = project_link_cats.projectID
                                         AND project_link_cats.catID = :catID
                                    ORDER BY 
                                        projectID DESC
                                    '.$pages->get_limit());
                                $stmt->execute(array(':catID' => $row['catID']));
                                while($row = $stmt->fetch()){

                                    echo '<div>';
                                        echo '<h3><a href="'.$row['projectSlug'].'">'.$row['projectTitle'].'</a></h3>';

                                            $stmt2 = $db->prepare('SELECT catTitle, catSlug	FROM project_cats, project_link_cats WHERE project_cats.catID = project_link_cats.catID AND project_link_cats.projectID = :projectID');
                                            $stmt2->execute(array(':projectID' => $row['projectID']));

                                            $catRow = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                                            $links = array();
                                            foreach ($catRow as $cat)
                                            {
                                                $links[] = "<a href='c-".$cat['catSlug']."'>".$cat['catTitle']."</a>";
                                            }
                                            echo implode(", ", $links);

                                        echo '</p>';
                                        echo '<p>'.$row['projectDesc'].'</p>';				
                                        echo '<p><a href="'.$row['projectSlug'].'">Read More</a></p>';				
                                    echo '</div>';

                                }

                                echo $pages->page_links('c-'.$_GET['id'].'&');

                            } catch(PDOException $e) {
                                echo $e->getMessage();
                            }
                        ?>
                    </div>
                </div>
            </div>
			
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