<?php
	//sve a tagove smo zamjenili sa funkcijom openPage gdje provjeravamo sa da li je zahtjev od ajaxa ili ne 
//da se stranice ne bi dva puta ucitavale
//fajl includedFiles
	  include("includes/includedFiles.php");
	 ?>

<script>
	openPage('browse.php');
</script>	