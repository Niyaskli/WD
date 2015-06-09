<?php

class entity{
	
	private $registry;

	public function __construct( ){
		

		
		}
	public function  getentity()
	{
	
		$entity =array();
			$query ="SELECT entity, id FROM entity";
			$result = mysql_query($query);
				
					while($row = mysql_fetch_array($result)){
					
						 $entity[] = $row;
						}
	return $entity;
	

	}


}
?>
