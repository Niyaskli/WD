<?php

class department{
	
	private $registry;

	public function __construct(  ){
				

		
		}
	public function  getdepartment()
	{
			
			$departments =array();
			$query ="SELECT id, department FROM department";
			$result = mysql_query($query);
				
					while($row = mysql_fetch_array($result)){
						 $departments[] = $row;
					}
		
		return $departments;
	

	}


}
?>
