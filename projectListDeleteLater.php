<?php require('includes/config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Projects</title>
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/main.css">
</head>
<body>

	<div id="wrapper">


		<h1>Projects</h1>
		<hr />

		<div id="main">

			<?php
				try {

					$pages = new Paginator('1','p');

					$stmt = $db->query('SELECT projectID FROM projects');

					//pass number of records to
					$pages->set_total($stmt->rowCount());

					$stmt = $db->query('SELECT projectID, projectTitle, projectSlug, projectDesc FROM projects ORDER BY projectID DESC '.$pages->get_limit());
					while($row = $stmt->fetch()){

							echo '<h1><a href="'.$row['projectSlug'].'">'.$row['projectTitle'].'</a></h1>';
								
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
					}

					echo $pages->page_links();

				} catch(PDOException $e) {
				    echo $e->getMessage();
				}
			?>

		</div>

		<div id="clear"></div>

	</div>


</body>
</html>