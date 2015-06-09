<?php

$configs = array();
$configs['db_host_sn'] = 'localhost';
$configs['db_user_sn'] = 'root';
$configs['db_pass_sn'] = '';
$configs['db_name_sn'] = 'strdb';
mysql_pconnect("localhost", "root", "") or die(mysql_error);
mysql_select_db("strdb")or die(mysql_error);
/* list of active Controllers Step to remove active controllers from database */
$controllers = array();
$controllers[0] = 'noauth';

//Set the default path to server name
DEFINE( "SITE_PATH", "http://".$_SERVER['SERVER_NAME']."/str/" );
DEFINE("DEPARTMENT_EMAIL", "admin@123.com");
?>
