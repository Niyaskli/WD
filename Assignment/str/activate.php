<?php
	
		require_once('public/users.class.php');
		if(isset($_GET["dt"])  && isset($_GET["k"]) && isset($_GET["u"]) )
			{
				$data = array( "userid"=> $_GET["u"],"key"=> $_GET["k"],"screen" => $_GET["dt"] );
				$users = new Users();
				$users->activatescreen($data);
			}

?>