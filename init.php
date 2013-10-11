<!DOCTYPE html>
<html>
	<head>
		<title>Developer Center</title>
		<link rel="stylesheet" href="loginStyle.css">
	</head>
	<body onload="init();">
		<?php
		include "header.php";
		?>

		<div id="loginBox" style="height: 400px; width: 325px;">
			<div id="loginBoxHeader" style="width: 325px;">
				Development Center Account Creation
			</div>
			<div id="loginHint">
				&nbsp;
			</div>
			<form id="loginForm" method="get" action="createA.php">
				<div class="loginLabel">
					Username:
				</div>
				<input id="userNameInput" class="loginInput" type="text" name="userName" placeholder=" Username">
				<div class="loginLabel">
					Email:
				</div>
				<input id="userEmailInput" class="loginInput" type="text" name="userEmail" placeholder=" john@gmail.com">
				<div class="loginLabel">
					Password:
				</div>
				<input id="passwordInput2" class="loginInput" type="password" name="password" placeholder=" Password">
				<div class="loginLabel">
					Verify Password:
				</div>
				<input id="passwordInput" class="loginInput" type="password" name="passwordAuth" placeholder=" Password">
				<label class="loginLabel" style="font-size: 12px;">
					I would like to participate in the "Red Vs Blue" project
				</label>
				<input id="rvb" type="checkbox" name="rvb" value="yes">
				<div id="loginSubmitButton">
					Create
				</div>
				<input id="realSubmit" style="display: none;" name="submit" type="submit">
			</form>
		</div>

		<script>
			function init() {
				$('#loginBox').css({
					'margin-top' : ($(window).height() - 350) / 2
				});
				if(<?php if(isset($_GET['invalid'])){echo mysqli_real_escape_string($connect, htmlentities($_GET['invalid']));}else{echo "false";}?>){
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