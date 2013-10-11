<?php
	$connect = mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "devcenter");
	$sql = htmlentities($_POST['sql']);
	mysqli_query($connect, $sql);
?>