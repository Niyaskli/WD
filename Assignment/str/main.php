<?php 

if( isset( $_SESSION['auth_uid'] ) && intval( $_SESSION['auth_uid'] ) > 0 ){
				return true;
			}else{
				header("location:index.php");
			}
session_start();
require_once('config.php' );
require_once('public/screen.class.php' );

$screen = new screen(); 

?>

<!doctype HTML>
<html>
 <meta charset=”utf-8”>
<head>
<title>Str:#main</title>
<base href="<?php echo SITE_PATH; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	

<script type="text/javascript" src="js/jquery.js"  >	</script>
<link rel="stylesheet" type="text/css" href="css/home.css" />

</head>

<body>
<div id="wrapper" >
<div class="header_wrapper">
	<header class="header_cl">
 
	 <h1>STR SCREEN</h1>
		<nav>
			<ul class="hd_menu"> 
				<li class="active"><a href="main.php" >HOME</a></li>
				<li><a href="addscreen.php" >ADD Screen</a></li>
					<li><a href="activity.php" >Activity</a></li>
				<li><a href="logout.php" >logout</a></li>
			</ul>	
		</nav>
	</header>
</div>
	<div class="container_wrapper " style="height:auto;">
	  <section class="container" style="height:auto; width:100%">
		    <article class="addscreen"  style="padding:0; margin:0; width:100%" >
				<?php 
						$screen_data = $screen->getall_screen();
						//print_r($screen_data);
				?>
		        <h2>ALL STR's</h2>
			<table cellpadding="1" width="94%" class="screen_data">
				<tr>
					<td align="left"></td><td align="left"></td>
				</tr>
				<tr>
					<th align="left"><label>Ref number</label></th>
					<th align="left"><label >Date</label></th>
					<th align="left"><label >Department</label></th>
					<th align="left"><label >Entity</label></th>
					<th align="left"><label >Activity date</label></th>
					<th align="left"><label >View</label></th>
					<th align="left"><label >Download</label></th>
					<th align="left"><label >Remove</label></th>
				
				</tr>
					<?php   foreach($screen_data as $data){
							echo '<tr>
								<td align="left"><label>'.$data["refno"].'</label></td>
									<td align="left"><label>'.$data["date"].'</label></td>
									<td align="left"><label>'.$data["department"].'</label></td>
									<td align="left"><label>'.$data["entity"].'</label></td>
									<td align="left"><label>'.$data["dateact"].'</label></td>
									<td align="left"><label><a href="viewstr.php?strno='.$data["id"].'">View</a></label></td>
									<td align="left"><label><a href="download.php?strno='.$data["id"].'">Download PDF</a></label></td>
									<td align="left"><label><a href="remove.php?strno='.$data["id"].'">Remove</a></label></td>
									
							

								</tr>';
							}
							?>
				
				


			</table>
		        
		    </article>

		</section>
	</div>

</div>
</body>
</html>
