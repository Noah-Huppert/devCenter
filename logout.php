<!DOCTYPE html>
<html>
	<head>
		<style>
		</style>
	</head>
	<body>
		<?php
		include "loggedHeader.php";
		$userHTTPIP = getenv('HTTP_X_FORWARDED_FOR');
		$userIP = $_SERVER['REMOTE_ADDR'];
		if ($userHTTPIP == '') {
			$userHTTPIP = $userIP;
		}
		$query = mysqli_query($connect, "SELECT * FROM  `userdata` WHERE  `userHTTPIP` LIKE '" . $userHTTPIP . "' AND `userRemoteIP` LIKE '" . $userIP . "' LIMIT 0 , 30");
		while ($row = mysqli_fetch_array($query)) {
			mysqli_query($connect, "UPDATE userdata SET `userSession`='inActive', `userHTTPIP`='null', `userRemoteIP`='null' WHERE `userHTTPIP`='" . $userHTTPIP . "' AND `userRemoteIP`='" . $userIP . "' AND `userID`='" . getUserData('name') . "';");
			echo "<script>window.location = 'login.php';</script>";
		}
		?>
	</body>
</html>