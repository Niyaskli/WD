<?php
session_start();
	require_once('public/screen.class.php' );


$screen = new screen(); 

	if(isset($_GET["strno"])){
	
		$screen->removestr($_GET["strno"]);
	}
?>