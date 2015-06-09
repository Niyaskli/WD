<?php
/** its for ajax calling **/
	//Start the session
	session_start();

	//Defining FRAMEWORK_PATH
	DEFINE("FRAMEWORK_PATH", dirname( __FILE__ ) ."/" );

	// database settings
	include(FRAMEWORK_PATH . 'config.php');

	require_once( FRAMEWORK_PATH . 'public/users.class.php');
	if(authenticate()){
		$user = new users();
        
		if(isset($_POST["handler"]) && $_POST["handler"] =="getuserdet" )
		{
		
				$user->getuserdet();
		}
		}else{
				echo "you not logged in";
		}

	

	exit(0);

		function authenticate(){
			if( isset( $_SESSION['auth_uid'] ) && intval( $_SESSION['auth_uid'] ) > 0 ){
				return true;
			}else{
				return false;
			}
		}


?>

