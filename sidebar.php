<h1>Recently Added</h1>
<hr />

<ul>
<?php
$stmt = $db->query('SELECT projectTitle, projectSlug FROM projects ORDER BY projectID DESC LIMIT 5');
while($row = $stmt->fetch()){
	echo '<li><a href="'.$row['projectSlug'].'">'.$row['projectTitle'].'</a></li>';
}
?>
</ul>

<h1>Catgories</h1>
<hr />

<ul>
<?php
$stmt = $db->query('SELECT catTitle, catSlug FROM project_cats ORDER BY catID DESC');
while($row = $stmt->fetch()){
	echo '<li><a href="c-'.$row['catSlug'].'">'.$row['catTitle'].'</a></li>';
}
?>
</ul>