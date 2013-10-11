<!DOCTYPE html>
<html>
	<head>
		<title>Developer Center</title>
		<link rel="stylesheet" href="loginStyle.css">
	</head>
	<body onload="init();">
		<?php
		include "header.php";
		$connect = mysqli_connect("localhost", "root", "");
		mysqli_select_db($connect, "devcenter");
		//SELECT `userName`, `userLevel`, `userSession`, `userHTTPIP`, `userRemoteIP` FROM `userdata` WHERE 1
		$query = mysqli_query($connect, "SELECT `userName`, `userLevel`, `userSession`, `userHTTPIP`, `userRemoteIP` FROM `userdata` WHERE 1");
		$userHTTPIP = getenv('HTTP_X_FORWARDED_FOR');
		$userIP = $_SERVER['REMOTE_ADDR'];
		if ($userHTTPIP == '') {
			$userHTTPIP = $userIP;
		}
		$logged = false;
		while ($row = mysqli_fetch_array($query)) {
			if (strcmp($row['userHTTPIP'], $userHTTPIP) == 0 && strcmp($row['userRemoteIP'], $userIP) == 0 && strcmp($row['userSession'], 'active') == 0) {
				echo "<script>window.location = 'home.php';</script>";
			}
		}
		?>

		<div id="loginBox">
			<div id="loginBoxHeader">
				Development Center Login
			</div>
			<div id="loginHint">
				&nbsp;
			</div>
			<form id="loginForm" method="get" action="auth.php">
				<div class="loginLabel">
					Username:
				</div>
				<input id="userNameInput" class="loginInput" type="text" name="loginUsername" placeholder=" Username">
				<div class="loginLabel">
					Password:
				</div>
				<input id="passwordInput" class="loginInput" type="password" name="loginPassword" placeholder=" Password">
				<div id="loginSubmitButton">
					Login
				</div>
				<input id="realSubmit" style="display: none;" name="submit" type="submit">
			</form>
		</div>

		<script>
			function init() {
$('#loginBox').css({
'margin-top' : ($(window).height() - 250) / 2
});
if(<?php
	if (isset($_GET['invalid'])) {echo mysqli_real_escape_string($connect, htmlentities($_GET['invalid']));
	} else {echo "false";
	}
?>
	) {
		$('#loginHint').html('Invalid Username or Password');
	}
	$('#loginSubmitButton').click(function() {
		if ($('#passwordInput').val() == '' || $('#userNameInput').val() == '') {
			$('#loginHint').html('Please fill in your username and password.');
		}
		if ($('#passwordInput').val() != '' && $('#userNameInput').val() != '') {
			document.getElementById('realSubmit').click();
		}
	});
	}
		</script>
	</body>
</html>