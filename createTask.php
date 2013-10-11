<?php
include "loggedHeader.php";
$taskTitle = mysqli_real_escape_string($connect, htmlentities($_GET['taskTitle']));
$taskContent = mysqli_real_escape_string($connect, htmlentities($_GET['taskContent']));
$taskTag = mysqli_real_escape_string($connect, htmlentities($_GET['taskTag']));
$taskLevel = mysqli_real_escape_string($connect, htmlentities($_GET['taskLevel']));
$taskProject = mysqli_real_escape_string($connect, htmlentities($_GET['taskProject']));
$linkID = count(getProjectData($taskProject , 'tasks', 'id'));
$sql = "INSERT INTO `devcenter`.`tasks` (`taskName`, `taskContent`, `taskDev`, `taskID`, `taskProject`, `taskTag`, `taskLevel`, `taskStatus`, `taskUser`) VALUES ('" . $taskTitle . "', '" . $taskContent . "'	 , '9001', '" . count(getProjectData($taskProject , 'tasks', 'id')) . "','" . $taskProject . "', '" . $taskTag . "', '" . $taskLevel . "', 'Pending', '0')";
mysqli_query($connect, $sql);
echo "
<script>
	window.location = 'home.php?view=project&screen=tasks&id=" . $taskProject . "&taskID=" . $linkID . "';
</script>";

?>