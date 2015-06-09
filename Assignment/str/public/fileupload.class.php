<?php

class fileupload {
private $up_flag= 0;

		function __construct()
		{
			require_once('config.php');
			DEFINE("FRAMEWORK_PATH", dirname( __FILE__ ) ."/" );
			//constructor 
		}
		
		public function fileupload($refno)
		{
					$this->up_flag = 0;
					error_reporting(E_ALL);
					if(isset($_SESSION["auth_uid"]))
					{
							$upload_dir = FRAMEWORK_PATH."data/". $_SESSION["auth_uid"]."/".$refno;
							@mkdir($upload_dir);
					}
					
					
					
					$max_file_size = 91200;
					$ini_max = str_replace('M','',ini_get('upload_max_filesize'));
					$upload_max = $ini_max * 1024;
					$msg = 'please select for file uploading';
					$messages = array();
					
			
				if( isset($_FILES[ 'attachment']['tmp_name'])){
				
						
							for($i=0; $i< count($_FILES[ 'attachment']['tmp_name']) ; $i++)
							{
									 ;
								if( !is_uploaded_file($_FILES[ 'attachment']['tmp_name'][$i]))
								{
									
								 $messages[] = ' no file Uploaded';
								 }
								 elseif($_FILES[ 'attachment']['size'][$i] > $upload_max)
								 {
									$this->up_flag = 1;
								  $messages[] = "File size exceeds $upload_max  php.ini limit";
								 }
								 elseif( $_FILES[ 'attachment']['size'][$i] > $max_file_size  )
								  {
									$this->up_flag  = 1;
								  $messages[] = "File size exceeds $max_file_size   limit";
								 }
								 
							}
							// check error found or not
							if( $this->up_flag == 0)
							{
									$file_name = array();
												for($i=0; $i< count($_FILES[ 'attachment']['tmp_name']) ; $i++)
									{
													if(@copy($_FILES[ 'attachment']['tmp_name'][$i], $upload_dir.'/'.$_FILES[ 'attachment']['name'][$i]))
											{
												$file_name[] =  $upload_dir.'/'.$_FILES[ 'attachment']['name'][$i];
											//	$messages[] = $_FILES[ 'attachment']['name'][$i]."uploaded" ;
												
											}else
											{
													$this->up_flag = 1;
												$messages[] = $_FILES[ 'attachment']['name'][$i]."failed" ;
											}
									}
									if(  $this->up_flag == 0){
																			return array( 'success'=> true, 'error' => false,'sc_fname' => $file_name);		
									}else{	return array( 'success'=> false, 'error' => true,   'error_msg' => $messages );	}
							
							}else{	return array( 'success'=> false, 'error' => true,   'error_msg' => $messages );	}
							
				}else
					{
							return array( 'success'=> true, 'error' => false,'sc_fname' => array());		
				}
		}
		
}


?>