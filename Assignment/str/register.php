<?php
		
		 $registrationErrorLabels = "";
		session_start();
		require_once('config.php');
		require_once('public/users.class.php');
		DEFINE("FRAMEWORK_PATH", dirname( __FILE__ ) ."/" );
		if(isset($_POST['ruser'])){
		
				if((isset($_POST['username']) )	 &&
				(isset($_POST['email'])  ) &&
				(isset($_POST['password']) ) &&
				(isset($_POST['cpassword']) ) &&
				(isset($_POST['department'])) &&
				(isset($_POST['entity'])  ))
				{

					$datas = array( 'username'=> $_POST['username'],'password' => $_POST["password"], 'cpassword' => $_POST["cpassword"], "email" => $_POST["email"], 'department' => $_POST['department'],'entity' => $_POST["entity"]);
					$ret = checkRegistration($datas) ;
					
					if( !is_array($ret )&& $ret == true )
					{

						$users = new Users();
						unset($datas['cpassword']); 
						$users->registerUser($datas);
					
						//header("location:success");				
									
			
					}
					else
					{
				
						$_SESSION['error'] = $ret;
					//	header("location:register.php");	

					}
				}else{
					echo "Please enter details";
					exit(0);		
				}
			
		}
		
	function checkRegistration($values)
	{
		 $registrationErrors = array();
		$allClear = true;

		foreach ($values as $reg_vals => $key){
			
			$$reg_vals = trim($key);
		}

		

		if (strlen($username) < 6){
			$allClear = false;
			$registrationErrors[] = 'Your username is too short, it must be at least 6 characters';
			$registrationErrorLabels['register_password_label'] = 'error';
			$registrationErrorLabels['register_password_confirm_label'] = 'error';
		}
	//ADDED
		//username valid
		if( ! preg_match('/^[a-zA-Z0-9.]{1,}+$/', $username ) )
		{
			$allClear = false;
			$registrationErrors[] = 'Provide only alphanumeric characters and periods for username';
			$registrationErrorLabels['register_password_label'] = 'error';
			$registrationErrorLabels['register_password_confirm_label'] = 'error';
		}
		
		// passwords match
		if( $password != $cpassword )
		{
			$allClear = false;
			$registrationErrors[] = 'Password entries does not match';
			$registrationErrorLabels['register_password_label'] = 'error';
			$registrationErrorLabels['register_password_confirm_label'] = 'error';
		}

		// password length
		if( strlen( $password ) < 6 && strlen($cpassword) < 6)
		{
			$allClear = false;
			$registrationErrors[] = 'Your password is too short, it must be at least 6 characters';
			$registrationErrorLabels['register_password_label'] = 'error';
			$registrationErrorLabels['register_password_confirm_label'] = 'error';
		}


		// email headers
		if( strpos( ( urldecode( $email ) ), "\r" ) === true || strpos( ( urldecode( $email ) ), "\n" ) === true )
		{
			$allClear = false;
			$registrationErrors[] = 'Your email address is not valid (security)';
			$registrationErrorLabels['register_email_label'] = 'error';
		}

		// email valid
		if( ! preg_match( "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})^", $email ) )
		{
			$allClear = false;
			$registrationErrors[] = 'You must enter a valid email address';
			$registrationErrorLabels['register_email_label'] = 'error';

		}

		$valid_email= intval(validate_email( $email ));
		if($valid_email == 0){
			
			$allClear = false;
			$registrationErrors[] = 'Your email is already in use on this site.';
		}



		if( $allClear == true )
		{

			$sanitizedValues['username'] = $username;
			$sanitizedValues['email'] = $email;
			$sanitizedValues['password'] = md5( $password );
			$sanitizedValues['department'] =  $department ;
			$sanitizedValues['entity'] =  $entity ;
			$sanitizedValues['created'] = date("Y-m-d H:i:s");
			return true;
		}
		else
		{
			return $registrationErrors;
		}



	}
	
	function validate_email( $email ){

			$query ="SELECT email FROM users WHERE email = '{$email}'";
			$result = mysql_query($query);
				 if( mysql_num_rows($result) > 0){
					return false;
				 }else{
					return true;
				 }
					
	
	}

	if(isset($_SESSION['error'])){

		print_r($_SESSION['error']);
		unset($_SESSION['error']);
	}
?>