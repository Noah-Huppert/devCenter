<?php
//error_reporting(E_ALL ^ E_NOTICE);//Shut off error reporting
//All php init function below
require "plugins/passwordPHP/password.php";
$connect = mysqli_connect("localhost", "root", "");
mysqli_select_db($connect, "devcenter");
?>
<link rel="stylesheet" href="mainStyle.css" />
<script src="plugins/jquery/jquery-1.10.2.min.js"></script>