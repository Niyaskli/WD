<?php

class activity{
	
	

	public function __construct(  ){
				
		
		}
	public function  getactivity()
	{
			$uid= $_SESSION["auth_uid"];
			$query = "SELECT * FROM logs WHERE userid=".$uid ;
			if($results = mysql_query($query)){
						if(mysql_num_rows($results) > 0){
									while($result = mysql_fetch_array($results)){
							 $activity[] = $result;
							 }
						}else{
							echo "no data found";
						}
					
			}else{ echo  "error"; }
			
		
		return $activity;
	

	}


}
?>
