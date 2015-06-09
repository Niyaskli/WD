<?php 
if( isset( $_SESSION['auth_uid'] ) && intval( $_SESSION['auth_uid'] ) > 0 ){
				return true;
			}else{
				header("location:index.php");
			}
require_once('config.php');
session_start();
require_once('public/activity.class.php');
$act = new activity();
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
					<li class="active"><a href="activity.php" >Activity</a></li>
				<li><a href="logout.php" >logout</a></li>
			</ul>	
		</nav>
	</header>
</div>
	<div class="container_wrapper " style="height:auto;">
	  <section class="container" style="height:auto; width:100%">
		    <article class="addscreen"  style="padding:0; margin:0; width:100%" >
				<?php 
						$screen_data = $act->getactivity();
						
				?>
		        <h2>Activities</h2>
			<table cellpadding="1" width="94%" class="screen_view_data">
						<?php foreach($screen_data as $key)
						{
								echo  '<tr><td align="left" width="190px"><span class="viewspan">'.$key["time"].'</span></td><td align="left">You have '.$key["action"].'  STR Screen</td></tr>';
						
						} ?>
						
					
				
			

			</table>
		        
		    </article>

		</section>
	</div>

</div>
</body>
</html>
