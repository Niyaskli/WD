<?php 
if( isset( $_SESSION['auth_uid'] ) && intval( $_SESSION['auth_uid'] ) > 0 ){
				return true;
			}else{
				header("location:index.php");
			}
require_once('config.php');
session_start();
	require_once('public/screen.class.php' );


$screen = new screen(); 
?>
<!doctype HTML>
<html>
 <meta charset=”utf-8”>
<head>
<title>Str:home</title>
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
			<ul class="hd_menu"> <li><a href="main.php" >HOME</a></li>
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
						$screen_data = $screen->getall_screen($_GET["strno"]);
						//print_r($screen_data);
				?>
		        <h2>View STR's</h2>
			<table cellpadding="1" width="94%" class="screen_view_data">
						<tr>
					<td align="left"><label for="refno" >Ref: no</label></td><td align="left"><span class="viewspan"><?php echo $screen_data[0]['refno'] ;?></span></td>
					<td align="left"><label for="repdate" >Date of Reporting</label></td><td align="left"><span class="viewspan"><?php echo $screen_data[0]['date'] ;?></span></td>
				</tr>
				<tr>
					<td align="left"><label for="strdepartment" >Department</label></td><td align="left"><span class="viewspan"><?php echo $screen_data[0]['department'] ;?></span></td>
				
					<td align="left"><label for="strentity" >Entity</label></td><td align="left"><span class="viewspan"><?php echo $screen_data[0]['entity'] ;?></span></td>
				</tr>
				<tr>
					<td align="left" colspan="2"> <h3>About Connected Person(S):</h3></td>
				</tr>
				<tr>
					<td align="left"><label for="nameperson" >Name of Person under suspecion (+)</label></td><td align="left">

	<ul  > <?php  $persons = json_decode($screen_data[0]['persons'] );  

				foreach( $persons as $index){ echo ' <li><span class="viewspan">'.$index.'</span></li>';   }
	?>
	</ul>
</td>
					<td align="left"><label for="entity" >Account Number if existing client (+)</label></td><td align="left">
					<ul >
							<?php  $clientac = json_decode($screen_data[0]['clientac'] );  
				foreach( $clientac as $index){ echo ' <li><span class="viewspan">'.$index.'</span></li>';   }
	?>
						</ul>
 				
</td>
				</tr>
				<tr>
					<td align="left" colspan="2"> <h3>About Your Suspecion:</h3></td>
				</tr>
				<tr>
					<td align="left"><label for="dateactivity" >Date of activity occurance</label></td> <td align="left"><span class="viewspan"><?php echo $screen_data[0]['dateact'] ;?></span></td>
					<td align="left"><label for="descactivity" > relevent Transaction/ Activity</label></td><td align="left"><span class="viewspan"><?php echo $screen_data[0]['descrtrans'] ;?></span></td>
				</tr>
				<tr>
					<td align="left"><label for="descsuspecion" >Nature of your suspecion</label></td><td align="left"><span class="viewspan"><?php echo $screen_data[0]['descrsuspecion'] ;?></span></td>
					<td align="left"><label for="explperson" > Explanation of the connected person transaction or activity?</label></td><td align="left"><span class="viewspan"><?php echo $screen_data[0]['personexpl'] ;?></span></td>
				</tr>
				<tr>
				<td align="left" colspan="2"> <h3>Attachments</h3></td>
<td align="left" colspan="2"><ul>
<?php  $attachment = json_decode($screen_data[0]['attachment'] );  
if(!empty($attachment))
			{
				foreach( $attachment as $index){ echo ' <li><a href= "'.$index.'" class="viewspan">Download</a></li>';   }
				}else{ echo "No attachment";}
	?>
						</ul>
 					</td>
					
				</tr>
				
				


			</table>
		        
		    </article>

		</section>
	</div>

</div>
</body>
</html>
