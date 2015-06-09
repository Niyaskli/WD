<?php 
if( isset( $_SESSION['auth_uid'] ) && intval( $_SESSION['auth_uid'] ) > 0 ){
				return true;
			}else{
				header("location:index.php");
			}

session_start();
require_once('config.php' );
require_once('public/screen.class.php' );
require_once('public/fileupload.class.php' );

$screen = new screen(); 
$fileup = new fileupload();

if(isset($_POST['addnew'])){

		$file_return = $fileup->fileupload($_POST['refno']);
					if( $file_return["success"] == true && $file_return["error"] == false  )
					{
							  $screenarr = $screen->addStr($_POST);
								if(  $screenarr["success"] == true && $screenarr["error"] == false )
								{				if(empty($file_return['sc_fname']))
								{
										$screenarr['sc_msg']['attachment'] =  "";
								}else{
													$screenarr['sc_msg']['attachment'] = json_encode($file_return['sc_fname']);
											}
											savetodb($screenarr['sc_msg']);	
								}else{
											$_SESSION["addscreen_er"]  =$screenarr['error_msg'];
											header("location:addscreen.php");
								}
							  
					}else
					{
						$_SESSION["addscreen_er"]  = $file_return['error_msg'];
						header("location:addscreen.php");
					//echo "error";
					}
	     
				return false;
	}
	function savetodb($screenarr){
				$userid= $_SESSION["auth_uid"];
				//print_r($screenarr);
			 $query=" INSERT INTO `strdb`.`screens` (`userid`, `refno`, `date`, `department`, `entity`, `persons`, `clientac`, `dateact`, `descrtrans`, `descrsuspecion`, `personexpl`, `attachment`) VALUES 
				( '{$userid}', '{$screenarr['refno']}', '{$screenarr['date']}', '{$screenarr['department']}', '{$screenarr['entity']}', '{$screenarr['persons']}', '{$screenarr['clientac']}', '{$screenarr['dateact']}', '{$screenarr['descrtrans']}', '{$screenarr['descrsuspecion']}', '{$screenarr['personexpl']}', '{$screenarr['attachment']}')";
				
					if(mysql_query($query)){
						
						$uid = mysql_insert_id();
						$logQuery = " INSERT INTO `logs` (`userid`, `action`, `time`, `ip`) VALUES ( '{$userid}', 'create', CURRENT_TIMESTAMP, '{$_SERVER["REMOTE_ADDR"]}'); ";
						if(mysql_query($logQuery)){
							createlink($uid );
						}else{ echo "error";}
						
					}else{
					
						echo "error Found ";
					
					}
				
	}
	 function createlink($dataid )
	{
				require_once('public/mailout.class.php' );

				$mail =new mailout();
				$uid= $_SESSION["auth_uid"];
				$activationKey = rand(1000,9999);
				
				$actQuery = " INSERT INTO `strdb`.`activation` ( `userid`,`screenid`, `resetkey`) VALUES ('{$uid}', '{$dataid }', '{$activationKey}'); ";
									
									if(mysql_query($actQuery)){
											$link = SITE_PATH."activate.php?k=".$activationKey."&u=".$uid."&pid=".md5(rand(1000,9999))."&dt=".$dataid;
											$mail->sendMail( DEPARTMENT_EMAIL,'New Str Activation Link',array('link'=>$link),'newstr' );
											echo $link = SITE_PATH."activate.php?k=".$activationKey."&u=".$uid."&pid=".md5(rand(1000,9999))."&dt=".$dataid;
									}else{
									
										echo "error found ";
									}
									
				
			
			
			
	}
					
?>


<!doctype HTML>
<html>
 <meta charset=”utf-8”>
<head>
<title>Str:Add screen</title>
<base href="<?php echo SITE_PATH; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	

<script type="text/javascript" src="./js/jquery-1.7.js"  >	</script>
<script type="text/javascript" src="./js/jquery.datePicker.js"  >	</script>
<script type="text/javascript" src="./js/jquery-ui.js"  >	</script>
<script type="text/javascript" src="./js/register.js"  >	</script>
<link rel="stylesheet" type="text/css" href="css/home.css" />
<script type="text/javascript">

$(document).ready(function() {

//Add click button
			$("form#addscreenform").submit(function()
					{	
						/*alert($("form#addscreenform").serialize());
						$.ajax({ url:"mindex.php",
								type:"post",
								data:{ "model":'screen', "handler" : "addstr", "data":$("form#addscreenform").serialize()},
								normalizeJSON: true,
								success: function( response ){
									alert("true");
								},
								error:function(){	}

						});*/
						if(	$("#strdepartment").val() == "" )
						{
								$("#error_display").html("Department is Missing, Please refresh");
								$("#strdepartment").addClass('error_sty');
								return false;
						}
						
						if(	$("#strentity").val() == "" )
						{
								$("#error_display").html("Entity is Missing, Please refresh");
								$("#strentity").addClass('error_sty');
								return false;
						}
						if(	$("#dateactivity").val() == "" )
						{
								$("#error_display").html("Please enter date of activity");
								$("#dateactivity").addClass('error_sty');
								return false;
						}
						if(	$("#descactivity").val() == "" )
						{
								$("#error_display").html("Please enter Description of activity");
								$("#descactivity").addClass('error_sty');
								return false;
						}
						if(	$("#descsuspecion").val() == "" )
						{
								$("#error_display").html("Please enter Description of suspecion");
								$("#descsuspecion").addClass('error_sty');
								return false;
						}
						if(	$("#explperson").val() == "" )
						{
								$("#error_display").html("Please enter Explanation name");
									$("#explperson").addClass('error_sty');
								return false;
						}
						
					return true;
						
						
					});


		$.ajax({ url:"mindex.php",
			type:"post",
			data:{ "model":'users', "handler" : "getuserdet"},
			normalizeJSON: true,
			success: function( response ){
				var json = $.parseJSON(response);
				//alert(json.data[1].["username"]);
				if (json.success){
							if ($.isArray( json.data )){

						  		var departments = [];

								$.each(
									json.data,
								function( index, uData ){
							
									$("#strentity").val(uData.entity);
									$("#strdepartment").val(uData.department);
								});
								return false
						}
				} else {
					alert("Error: Found ");
				}
			},
			error:function(){	}
						
			});

			acounter =1;
				bcounter =1;
					ccounter =1;
			$("#addnameperson").click(function () {
			if(acounter>10){
			    alert("Only 10 textboxes allow");
			    return false;
			}   
		 
			var newTextBoxDiv = $(document.createElement('li'))
			     .attr("id", 'TextBoxDiv' + acounter);
		 
			newTextBoxDiv.html(  '<input type="text" name="nameperson[]" id="nameperson' + acounter + '" class="input_scrn" value="" >'+'<span class="removethis">remove</span>');
		 
			newTextBoxDiv.appendTo("#addname_ul");
		 
		 
			acounter++;
		     });
		/*add new client */

		$("#addnewclient").click(function () {
			if(bcounter>10){
			    alert("Only 10 textboxes allow");
			    return false;
			} 
		 
			var newTextBoxDiv = $(document.createElement('li'))
			     .attr("id", 'TextBoxDiv' + bcounter);
		 
			newTextBoxDiv.html(  '<input type="text" name="client[]" id="client' + bcounter + '" class="input_scrn" value="" >'+'<span class="removethis">remove</span>');
		 
			newTextBoxDiv.appendTo("#addclient_ul");
		 
		 
			bcounter++;
		     }); 

		/**add attachment */
		
			$("#addnewattachment").click(function () {
			if(ccounter>10){
			    alert("Only 10 textboxes allow");
			    return false;
			} 
		 
			var newTextBoxDiv = $(document.createElement('li'))
			     .attr("id", 'TextBoxDiv' + ccounter);
		 
			newTextBoxDiv.html(  '<input type="file" name="attachment[]" id="file' + ccounter + '" class="input_scrn" value=""  multiple>'+'<span class="removethis">remove</span>');
		 
			newTextBoxDiv.appendTo("#addattachment_ul");
		 
		 
			ccounter++;
		     }); 
	
			/**add button click **/
				$("table").delegate(".removethis","click",function(e)
				{		
					$(this).parent("li").remove();
				
				});
				
				
				
				
		});

		$(function() {
				$( "#dateactivity" ).datepicker({
					showButtonPanel: true,
					changeMonth: true,
					changeYear: true
				});
		});


</script>
</head>
<?php $t =strtotime(date('d-m-y h:i:s')); ?>
<body>
<div id="wrapper" >
<div class="header_wrapper">
	<header class="header_cl">
 
	 <h1>STR SCREEN</h1>
		<nav>
			<ul class="hd_menu"> <li><a href="main.php" >HOME</a></li>
				<li class="active"><a href="addscreen.php" >ADD Screen</a></li>
					<li><a href="activity.php" >Activity</a></li>
				<li><a href="logout.php" >logout</a></li>
			</ul>	
		</nav>
	</header>
</div>
	<div class="container_wrapper " style="height:auto;">
	  <section class="container" style="height:auto;">
		    <article style="width:90%"  >
		        <h2>Add Screen!</h2>
		<form method="POST" id="addscreenform" action="" enctype="multipart/form-data">

			<table cellpadding="3" width="100%">
				<tr>
					<td align="left" colspan="4"><span id="error_display"> <?php if(isset($_SESSION["addscreen_er"])) {
						foreach($_SESSION["addscreen_er"]  as $value)
							{  echo $value."<br />";  	}
								unset($_SESSION["addscreen_er"] );
					} 
					
					 ?>
					</span></td>
					<td align="left"></td>
				</tr>
			
				<tr>
					<td align="left"><label for="refno" >Ref: no</label></td><td align="left"><input type="text" value="<?php echo strtotime(date('d-m-y h:i:s')) ?>" name="refno" /></td>
					<td align="left"><label for="repdate" >Date of Reporting</label></td><td align="left"><input type="text"  value="<?php echo date('m-d-y'); ?>" name="repdate" READONLY /></td>
				</tr>
				<tr>
					<td align="left"><label for="strdepartment" >Department</label></td><td align="left"><input type="text" value="" id="strdepartment" name="strdepartment" READONLY /></td>
				
					<td align="left"><label for="strentity" >Entity</label></td><td align="left"><input type="text" value="" id="strentity" name="strentity" READONLY /></td>
				</tr>
				<tr>
					<td align="left" colspan="2"> <h3>About Connected Person(S):</h3></td>
				</tr>
				<tr>
					<td align="left"><label for="nameperson" >Name of Person under suspecion (+)</label></td><td align="left">

	<ul id="addname_ul" > <li><input type="text" value="" name="nameperson[]"  class="input_scrn"  /></li>
	</ul>
 <span id="addnameperson">Add new</span></td>
					<td align="left"><label for="entity" >Account Number if existing client (+)</label></td><td align="left">
					<ul id="addclient_ul" >
							 <li><input type="text" value="" name="client[]" class="input_scrn"  /></li>
						</ul>
 					<span id="addnewclient">Add new</span>
</td>
				</tr>
				<tr>
					<td align="left" colspan="2"> <h3>About Your Suspecion:</h3></td>
				</tr>
				<tr>
					<td align="left"><label for="dateactivity" >Date of activity occurance</label></td><td align="left"><input type="text" value="" name="dateactivity" id="dateactivity"  /></td>
					<td align="left"><label for="descactivity" >Describe the relevent Transaction/ Activity</label></td><td align="left"><input type="text" value="" name="descactivity" id="descactivity"  /></td>
				</tr>
				<tr>
					<td align="left"><label for="descsuspecion" >Describe the nature of your suspecion</label></td><td align="left"><input type="text" value="asd" name="descsuspecion" id="descsuspecion"  /></td>
					<td align="left"><label for="explperson" >Explain if the connected person provided any explanation of the transaction or activity?</label></td><td align="left"><input type="text" value="" name="explperson" id="explperson" /></td>
				</tr>
				<tr>
					<td align="left"><label for="attachment" >Attach any supporting evidences you have on the connected person(s)</label></td>
<td align="left" colspan="2"><ul id="addattachment_ul" >
						</ul>
 					<span id="addnewattachment">Add attachment</span></td>
					<td valign="top" align="left"><p style="color: #C05353;font-size:10px;">(Note: tipping off client about your suspecion is a criminal offence under the law)</p></td>
				</tr>
				<tr>
					<td align="left"></td><td align="left" colspan="2"><input type="submit"  id="add_nscr" name="addnew" value="Add New" onclick="javascript:void(0)" > </td>
					
				</tr>


			</table>
</form>
		        
		    </article>

		</section>
	</div>

</div>
</body>
</html>
