<?php

class Users
{
	Public $registry;



	public function __construct()
	{

		require_once('config.php');
		//$this->registry->createAndStoreObject('mailout', 'mail');

		/*switch ($handler)
		{

		case "register":
				
				$this->registerUser($data);
			
			break;
				
		case "activatescreen":
		
			$this->activatescreen($data);
			break;
		case "getuserdet":
			
			$this->getuserdet();
			break;
		
		}*/


	}
	public function registerUser($data)
	{
			$query ="INSERT INTO `users` (`username`, `email`, `password`, `department`, `entity`, `block`) VALUES
				('{$data['username']}', '{$data['email']}', '{$data['password']}', '{$data['department']}', '{$data['entity']}', '0');";
			if(mysql_query($query)){
				 $uid = mysql_insert_id();
				mkdir( FRAMEWORK_PATH.'data/'.$uid);
				echo "success";
			}else{
			echo "faild Try again";
			}
				
	}

	
	public function activatescreen($data){

		
		if (isset($data["key"])){
			
			 $query = "SELECT * FROM `activation` WHERE `userid` ='".$data["userid"]."'  AND resetkey = '".$data["key"]."' AND screenid = '".$data["screen"]."'" ;
			
			if( $result = mysql_query($query)){
				if(mysql_num_rows($result) == 1){
					
							$uquery = "UPDATE `strdb`.`screens` SET `active` = '1' WHERE `screens`.`id` = ".$data["screen"] ; 
								if(mysql_query($query)){
										echo "success fully activated";
								}else{
								echo "Error I activation";
								}
				}else{
					echo "Error Found";
				}
			}else{
					echo "Error Found";
				}
			
			
			
		}else{
			$array = array('success'=>false,'error'=>true,'errors' => array('Invalid Information, Contact System administrator.'));
			echo json_encode($array);
		}
		
	}

	public function getuserdet()
	{
		if(isset($_SESSION["auth_uid"]))
		{
				$userid = $_SESSION["auth_uid"];
		}else{ echo "not "; }
		$query= "SELECT us.*, dp.*, dp.id as depid, et.id AS entid,et.* FROM users AS  us JOIN department AS dp ON us.department = dp.id JOIN entity AS et ON us.entity = et.id WHERE us.id = '{$userid}'" ;

				$result = mysql_query($query);
				
					while($row = mysql_fetch_array($result)){
						 $array = array('success' => true,'error' => false,'data' => array($row));
						 echo json_encode($array);
					}
		
		
		
	
	}


}


?>
