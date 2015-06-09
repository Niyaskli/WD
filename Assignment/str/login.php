<?php

		session_start();
		require_once('config.php');
		require_once('public/users.class.php');
		if(isset($_POST['luser'])){
				
				$aemail = $_POST['authemail'];
				$apassword = $_POST['authpassword'];
				$tpassword = md5( $apassword );
				
			 $query ="SELECT * FROM users WHERE email = '{$aemail}'  AND password = '{$apassword}' AND block = 0";
				$results = mysql_query($query);
					if(mysql_num_rows($results) == 1){
					while($result = mysql_fetch_array($results)){
						$_SESSION['auth_uid'] = $result['id'];
						$_SESSION['auth_uname'] = $result['username'];
						$_SESSION['auth_uemail'] = $result['email'];
						$_SESSION['auth_department'] = $result['department'];
						$_SESSION['auth_entity'] = $result['entity'];
						header("location:main.php");
					}
				}else{
						$_SESSION['error'] = array("login error");
						header("location:login.php");
						
				}
				
		
		
			exit(0);
		
		}
		
		if(isset($_SESSION['error'])){

			print_r($_SESSION['error']);
			unset($_SESSION['error']);
		}

?>