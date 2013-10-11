<!DOCTYPE html>
<html>
	<head>
		<style>
		</style>
	</head>
	<body>
		<?php
		include "header.php";
		if (isset($_GET['loginUsername']) == true && isset($_GET['loginPassword']) == true) {
			$loginUsername = mysqli_real_escape_string($connect, htmlentities($_GET['loginUsername']));
			$loginPassword = mysqli_real_escape_string($connect, htmlentities($_GET['loginPassword']));
			$loginHash = password_hash(mysqli_real_escape_string($connect, htmlentities($_GET['loginPassword'])), PASSWORD_BCRYPT);
			$query = mysqli_query($connect, "SELECT * FROM  `userdata` WHERE  `userName` LIKE  '" . $loginUsername . "'LIMIT 0 , 30");
			while ($row = mysqli_fetch_array($query)) {
				if (strcmp($row['userName'], $loginUsername) == 0) {
					//echo $row['userName'] . "<br>" . $loginHash . "<br>" . $row['userHash'] , "<br>" . password_verify($loginPassword, $row['userHash']);
					if (password_verify($loginPassword, $row['userHash']) == 1) {//Verify Password If Verififed
						$userHTTPIP = getenv('HTTP_X_FORWARDED_FOR');
						$userIP = $_SERVER['REMOTE_ADDR'];
						if ($userHTTPIP == '') {
							$userHTTPIP = $userIP;
						}
						mysqli_query($connect, "UPDATE userdata SET `userHTTPIP`='" . $userHTTPIP . "',
						 `userRemoteIP`='" . $_SERVER['REMOTE_ADDR'] . "',
						  `userSession`='active' WHERE `userName` LIKE '" . $loginUsername . "';");
						echo "<script>window.location = 'home.php';</script>";

					} else {//If invalid password
						mysqli_query($connect, "UPDATE userdata SET `userSession`='inActive' WHERE `userName`='" . $loginUsername . "';");
						echo "<script>window.location = 'login.php?invalid=true';</script>";
					}
				}
			}
			if (mysqli_num_rows($query) == 0) {
				echo "<script>window.location = 'login.php?invalid=true';</script>";
			}
		}
		?>
	</body>
</html>