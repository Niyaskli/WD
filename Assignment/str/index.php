<?php 


require_once('config.php' );
mysql_pconnect("localhost", "root", "") or die(mysql_error);
mysql_select_db("strdb")or die(mysql_error);
require_once('public/department.class.php' );
require_once('public/entity.class.php' );

$dept = new department();
$ent = new entity(); 
?>
<!doctype HTML>
<html>
<meta charset=”utf-8”>
<head>
<title>Str Home</title>
<base href="<?php echo SITE_PATH;?>" />
<script type="text/javascript" src="./js/jquery-1.7.js"  >	</script>
<script type="text/javascript" src="./js/register.js"  >	</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link rel="stylesheet" type="text/css" href="css/home.css" />
	


</head>

<body>
<div id="wrapper" >
<div class="header_wrapper">
	<header class="header_cl">
 
	 <h1>STR SCREEN</h1>
		<nav>
				
		</nav>
	</header>
</div>
	<div class="container_wrapper ">
	  <section class="container">
		    <article >
		        <h2>Create Account !</h2>
			<?php 
				$departments = $dept->getdepartment();
				$entitys = $ent->getentity();
			?>
<form action="register.php" method="post" >
			<table cellpadding="10">
				<tr>
					<td align="left"><label for="username" >Name</label></td><td align="left"><input type="text" value="" name="username" id="username" /></td>
				</tr>
				<tr>
					<td align="left"><label for="email" >Email</label></td><td align="left"><input type="text" value="" name="email" id="email" /></td>
				</tr>
				<tr>
					<td align="left"><label for="password" >Password</label></td><td align="left"><input type="password" value="" name="password" id="password" /></td></tr>
				<tr>
					<td align="left"><label for="cpassword" >Confirm Password</label></td><td align="left"><input type="password" value="" name="cpassword" id="cpassword" /></td></tr>
				<tr>
					<td align="left"><label for="department" >Department</label></td><td align="left"><select  name="department" id="department" >
<option value="0">---select department---</option>
	<?php 
	if(!empty($departments))
	{
	foreach($departments as $index)
		{
			echo "<option value='".$index['id']."'>".$index['department']."</option>";
		}
	}
	?>
 </select></td>
				</tr>
				<tr>
					<td align="left"><label for="entity" >Entity</label></td><td align="left"><select name="entity" id="entity"> <option value="0">---select entity---</option>

			<?php 
	if(!empty($entitys))
	{
	foreach($entitys as $index)
		{
			echo "<option value='".$index['id']."'>".$index['entity']."</option>";
		}
	}
	?>
 </select></td>
				</tr>
				<tr>
					<td align="left"></td><td align="left"><input type="submit" name="ruser" value="Create account" id="reg_user"> </td>
				</tr>
			</table>

	</form>
		        
		    </article>
<article >
		        <h2>Sign in !</h2>
<form action="login.php" method="post" >
			<table cellpadding="10">
				<tr>
					<td align="left"><label for="authemail" >Name</label></td><td align="left"><input type="text" value="" name="authemail" id="authemail"/></td></tr>
				<tr>
					<td align="left"><label for="authpassword" >password</label></td><td align="left"><input type="password" value="" name="authpassword" id="authpassword" /></td>
				</tr>
				
				<tr>
					<td align="left"></td><td align="left"><button id="us_login" name="luser"> Signin</button></td>
				</tr>
			</table>
</form>
		        
		    </article>
		</section>
	</div>

</div>
</body>
</html>
