<?php
//include config
require_once('../includes/config.php');

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: login.php'); }

//show message from add / edit page
if(isset($_GET['delproject'])){ 

	$stmt = $db->prepare('DELETE FROM projects WHERE projectID = :projectID') ;
	$stmt->execute(array(':projectID' => $_GET['delproject']));

	//delete post categories. 
	$stmt = $db->prepare('DELETE FROM project_link_cats WHERE projectID = :projectID');
	$stmt->execute(array(':projectID' => $_GET['delproject']));

	header('Location: index.php?action=deleted');
	exit;
} 

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>COMX Admin</title>
    
  <link rel="stylesheet" href="../css/main.css">
    
  <script type="text/javascript">
  function delproject(id, title) {
	  if (confirm("Are you sure you want to delete '" + title + "'")) {
	  	window.location.href = 'index.php?delproject=' + id;
	  }
  }
  </script>
</head>
<body>

	<div id="wrapper">

	<?php include('menu.php');?>

	<?php 
	//show message from add / edit page
	if(isset($_GET['action'])){ 
		echo '<h3>Post '.$_GET['action'].'.</h3>'; 
	} 
	?>

	<table>
	<tr>
		<th>Title</th>
		<th>Action</th>
	</tr>
	<?php
		try {

			$stmt = $db->query('SELECT projectID, projectTitle FROM projects ORDER BY projectID DESC');
			while($row = $stmt->fetch()){
				
				echo '<tr>';
				echo '<td>'.$row['projectTitle'].'</td>';
				?>

				<td>
					<a href="edit-project.php?id=<?php echo $row['projectID'];?>">Edit</a> | 
					<a href="javascript:delproject('<?php echo $row['projectID'];?>','<?php echo $row['projectTitle'];?>')">Delete</a>
				</td>
				
				<?php 
				echo '</tr>';

			}

		} catch(PDOException $e) {
		    echo $e->getMessage();
		}
	?>
	</table>

	<a href='add-project.php'>Add Project</a>

</div>

</body>
</html>
