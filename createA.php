<!DOCTYPE html>
<html>
	<head>
		<style>
		</style>
	</head>
	<body>
		<?php
		include "header.php";

		function customQuery($querryTable, $querryRow, $customQueryID = false, $querryID, $queryIDSet = '') {
			//Getting basic stuff out of the way
			$connect = mysqli_connect("localhost", "root", "");
			mysqli_select_db($connect, "devcenter");
			if ($customQueryID == false) {
				if (strcmp($querryTable, 'issues') == 0) {
					$tableIDRow = 'issueID';
					$queryIDSet = $queryIDSet;
				}
				if (strcmp($querryTable, 'tasks') == 0) {
					$tableIDRow = 'taskID';
					$queryIDSet = $queryIDSet;
				}
				if (strcmp($querryTable, 'userdata') == 0) {
					$tableIDRow = 'userID';
					$queryIDSet = $queryIDSet;
				}
				if (strcmp($querryTable, 'projects') == 0) {
					$tableIDRow = 'projectID';
					$queryIDSet = $queryIDSet;
				}
			} else {
				$tableIDRow = $querryID;
			}

			$sql = "SELECT `" . $querryRow . "` FROM `" . $querryTable . "` WHERE `" . $tableIDRow . "` = '" . $queryIDSet . "'";
			$query = mysqli_query($connect, $sql);
			if (is_bool($query) == true) {
				return 'Invalid';
			}
			while (is_bool($query) == false && $row = mysqli_fetch_array($query)) {
				return $row[$querryRow];
			}
		}

	function countUsers(){
		$connect = mysqli_connect("localhost", "root", "");
		mysqli_select_db($connect, "devcenter");
		$userCounter = 0;
		$sql = "SELECT `userID` FROM `userdata` WHERE `userID` > -1";
		$query = mysqli_query($connect, $sql);
		while (is_bool($query) == false && $row = mysqli_fetch_array($query)) {
			return count($row['userID']);
		}
	}

		$username = mysqli_real_escape_string($connect, htmlentities($_GET['userName']));
		$userEmail = mysqli_real_escape_string($connect, htmlentities($_GET['userEmail']));
		$userPassword = mysqli_real_escape_string($connect, htmlentities($_GET['password']));
		$userPasswordAuth = mysqli_real_escape_string($connect, htmlentities($_GET['passwordAuth']));
		$userHash;
		$userProjects;
		
		if (strcmp($userPassword, $userPasswordAuth) == 0) {
			$userHash = password_hash($userPasswordAuth, PASSWORD_BCRYPT);
			echo "userName: " . $username . "<br>userEmail: " . $userEmail . "<br>userPassword: " . $userPassword . "<br>userAuthPassword: " . $userPasswordAuth . "<br>userPasswordHash: " . $userHash;
			if (count(customQuery('userdata', 'userName', true, 'userName', $username)) == 0 && count(customQuery('userdata', 'userEmail', true, 'userEmail', $userEmail)) == 0) {
				if(strcmp(mysqli_real_escape_string($connect, htmlentities($_GET['rvb'])), 'yes') == 0){
					$userProjects = '0';
				} else{
					$userProjects = '';
				}
				$newUserID = countUsers() + 1;
				$sql = "INSERT INTO `devcenter`.`userdata` (`userEmail`, `userHash`, `userHTTPIP`, `userID`, `userLevel`, `userName`, `userProjects`, `userREMOTEIP`, `userSession`) VALUES ('" . $userEmail . "', '" . $userHash . "', 'null', '" . $newUserID . "', '2', '" . $username . "', '" . $userProjects . "', 'null', 'inactive')";
				mysqli_query($connect, $sql);
			}
		}
		?>
	</body>
</html>