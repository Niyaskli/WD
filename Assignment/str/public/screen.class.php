<?php

class screen
{
	public $registry;
	private $errors = array();
	private $errorflag = 0;

	public function __construct()
	{
	 
		require_once('config.php');
		
	}
	

	public function addStr($datas)
	{
	
		
		if(!empty($datas)){
			$result = $this->validation($datas);
				if( $result[ 'success'] == true &&  $result[ 'error'] == false)
				{
							return array( 'success'=> true, 'error' => false,  'sc_msg' => $result[ 'sc_msg']);
				}else{
							return array( 'success'=> false, 'error' => true,  'error_msg' =>$result[ 'error_msg'] );
				}
			
		}
	}

	public function validation($data)
	{
	//print_r($data);
$this->errorflag = 0;
$this->inputvalildation($data['refno'],"reference number");
$this->inputvalildation($data['strdepartment'],"str department");
$this->inputvalildation($data['strentity'],"str entity");
$this->inputvalildation($data['dateactivity'],"date of activity");
$this->inputvalildation($data['descactivity'],"description activity");
$this->inputvalildation($data['descsuspecion'],"description of suspecion");
$this->inputvalildation($data['explperson'],"explanation of  person");

		if($this->errorflag == 0)
		{ 		
				$client =array();
				$persons = array();
				if(!empty($data["client"]) && sizeof( $data["client"]) >0)
				{
						if(sizeof( $data["client"]) ==1){
								if( $data["client"]!= ""){
									$client = array($data["client"]);
								}else{
									$this->errorflag = 1;
									$this->errors[] ="Please enter atleast one client";						
								}	
						}else{
							foreach( $data["client"] as $index => $value )
							{
								if( $value != ""){
										$client[] = $value;
									}else{
									   $this->errorflag = 1;
										$this->errors[] ="Please enter client";						
									}
							} 
						}	
				}
				//persons valildation
				if(!empty($data["nameperson"]) && sizeof( $data["nameperson"]) >0)
				{
						if(sizeof( $data["nameperson"]) ==1){
								if( $data["nameperson"] != ""){
									$persons = array($data["nameperson"]);
								}else{
								    $this->errorflag = 1;
									$this->errors[] ="Please enter atleast one client";						
								}	
						}else{
							foreach( $data["nameperson"] as $index => $value )
							{
								if( $value != ""){
										$persons[] = $value;
									}else{
											$this->errorflag = 1;
										$this->errors[] ="Please enter client";						
									}
							} 
						}	
				}
				if( $this->errorflag == 0)
				{
				
				
				$screenarr = array(
												"refno" => $data['refno'],
												"userid" => $_SESSION["auth_uid"],
												"date" => $data['repdate'],
												"department" => $data['strdepartment'],
												"entity" => $data['strentity'],
												"persons" => json_encode($persons[0]),
												"clientac" => json_encode($client[0]),
												"dateact" => $data['dateactivity'],
												"descrtrans" => $data['descactivity'],
												"descrsuspecion" => $data['descsuspecion'],
												"personexpl" => $data['explperson']
												
				);
				
				
			return array( 'success'=> true, 'error' => false,  'sc_msg' => $screenarr );
			
			}else{ 			return array( 'success'=> false, 'error' => true,  'error_msg' =>$this->errors);}
				
		}else{	return array( 'success'=> false, 'error' => true,  'error_msg' =>$this->errors);	}
	}
	
	public function inputvalildation($value, $text)
		{
				if($value== "" && strlen($value) < 3 )
				{
					$this->errors[]= "plaese re enter ".$text."value  ";
					$this->errorflag = 1;
				}
		}
		
		public function getall_screen($id= NULL)
		{
				
			$data1 =array();
				$userid = $_SESSION["auth_uid"];
						if( $id == NULL)
						{
							$query= "SELECT * FROM screens WHERE userid = '{$userid}'" ;
						}else{
								$query= "SELECT * FROM screens WHERE userid = '{$userid}' AND id = '{$id}'" ;
						}
						
				$result = mysql_query($query);
				
					while($row = mysql_fetch_array($result)){
						$data1[]  = $row;
					}
					
			return $data1;
		}
		
		public function removestr($id = NULL)
		{		$userid = $_SESSION["auth_uid"];
				$query="DELETE  FROM screens WHERE id = '{$id}' AND userid = '{$userid }'";
					
					if(mysql_query($query)){
						
							$logQuery = " INSERT INTO `strdb`.`logs` (`userid`, `action`, `time`, `ip`) VALUES ( '{$userid}', 'remove', CURRENT_TIMESTAMP, '{$_SERVER["REMOTE_ADDR"]}'); ";
									if (mysql_query($logQuery) ){
						
										header("location:main.php");
										}else{
										echo "error found";
										}
					}else{
							echo "Error found " ;
					}
				
		}
	
	
	
	

}




?>
