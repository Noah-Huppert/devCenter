<!DOCTYPE html>
<html>
	<head>
		<title>Dev. Center</title>
	</head>
	<body onload="init();">
		<?php
		include "loggedHeader.php";
		?>

		<div id="contentArea">
			<div id="homePageTitle">
				Your Tasks
			</div>
			<?php
			$connect = mysqli_connect("localhost", "root", "");
			mysqli_select_db($connect, "devcenter");
			$sql = "SELECT * FROM `tasks` WHERE `taskDev`='" . getUserData('name') . "' OR `taskUser`='" . getUserData('name') . "'";
			$query = mysqli_query($connect, $sql);
			if (is_bool($query) == true) {
				echo 'Invalid';
			}
			echo "<div class='projectTasks'>";
			while (is_bool($query) == false && $row = mysqli_fetch_array($query)) {
				echo "
					<div class='taskListItem' id='taskListItem" . $row['taskID'] ."'>
						<div class='taskListItemTitle'>" . $row['taskName'] . "</div>
						<div class='taskListItemTag'>" . $row['taskTag'] . "</div>
						<div class='taskListItemLevel'>" . getRealLevel($row['taskLevel']) . "</div>
						<div class='taskListItemDev'>" . customQuery('userdata', 'userName', true, 'userID', $row['taskDev']) . "</div>
						<div class='taskListRightContainer'>
						<div class='taskListItemUser'>" . customQuery('userdata', 'userName', true, 'userID', $row['taskUser']) . "</div>
						<div class='taskListItemStatus'>" . $row['taskStatus'] . "</div>
					</div>
					<script>
						$('#taskListItem" . $row['taskID'] ."').click(function(){
							window.location = 'home.php?view=project&screen=tasks&id=" . $row['taskProject'] . "&taskID=" . $row['taskID'] . "';
						});
					</script>
				</div>";
			}
			echo "</div>";
		?>
		</div>
		<script>
			function init() {

			}
		</script>
	</body>
</html>