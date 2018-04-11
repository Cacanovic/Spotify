
<?php
	 include("includes/includedFiles.php");
	 if(isset($_POST['add_artist'])){
	 	if($_POST['name']!=""){
	 		$artist=$_POST['name'];
	 		$query="INSERT INTO artists (id,name) VALUES (NULL,'{$artist}');";
	 		mysqli_query($conn,$query);
	 		// header('Location: index.php');
	 	}
	 }
?>
<div class="col-md-4">
	<h1>Add Artist</h1>
	<form action="dodaj.php" method="post">
		<input  type="text" class="crna" name="name" placeholder="Enter Artist Name">
		<input type="submit" class="crna" name="add_artist" value="Add Artist">
	</form>
</div>