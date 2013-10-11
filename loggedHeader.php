<?php
//All php init function below
require "plugins/passwordPHP/password.php";
$connect = mysqli_connect("localhost", "root", "");
mysqli_select_db($connect, "devcenter");
$userHTTPIP = getenv('HTTP_X_FORWARDED_FOR');
$userIP = $_SERVER['REMOTE_ADDR'];
if ($userHTTPIP == '') {
	$userHTTPIP = $userIP;
}
$query = mysqli_query($connect, "SELECT * FROM `userdata` WHERE `userRemoteIP` LIKE '" . $userIP . "' AND `userHTTPIP` LIKE '" . $userHTTPIP . "'");
while ($row = mysqli_fetch_array($query)) {
	$userName = $row['userName'];
}

//PHP FUNCTIONS
//QuerryFucntion
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

function getUserData($userDataType, $realName = false) {
	$userHTTPIP = getenv('HTTP_X_FORWARDED_FOR');
	$userIP = $_SERVER['REMOTE_ADDR'];
	if ($userHTTPIP == '') {
		$userHTTPIP = $userIP;
	}
	if (strcmp($userDataType, 'name') == 0) {
		if ($realName == true) {
			if(strcmp(customQuery('userdata', 'userSession', true, 'userHTTPIP', $userHTTPIP), 'active') == 0){
				return customQuery('userdata', 'userName', true, 'userHTTPIP', $userHTTPIP);	
			}
		}
		if ($realName == false) {
			if(strcmp(customQuery('userdata', 'userSession', true, 'userHTTPIP', $userHTTPIP), 'active') == 0){
				return customQuery('userdata', 'userID', true, 'userHTTPIP', $userHTTPIP);
			}
		}
	}
	if (strcmp($userDataType, 'projects') == 0) {
		if ($realName == true) {
			if(strcmp(customQuery('userdata', 'userSession', true, 'userHTTPIP', $userHTTPIP), 'active') == 0){
				return explode('|', customQuery('userdata', 'userProjects', true, 'userHTTPIP', $userHTTPIP));
			}
		}
		if ($realName == false) {
			if(strcmp(customQuery('userdata', 'userSession', true, 'userHTTPIP', $userHTTPIP), 'active') == 0){
				return explode('|', customQuery('userdata', 'userProjects', true, 'userHTTPIP', $userHTTPIP));
			}
		}
	}
	if (strcmp($userDataType, 'projectsCount') == 0) {
		if ($realName == true) {
			if(strcmp(customQuery('userdata', 'userSession', true, 'userHTTPIP', $userHTTPIP), 'active') == 0){
				return count(explode('|', customQuery('userdata', 'userProjects', true, 'userHTTPIP', $userHTTPIP)));
			}
		}
		if ($realName == false) {
			if(strcmp(customQuery('userdata', 'userSession', true, 'userHTTPIP', $userHTTPIP), 'active') == 0){	
				return count(explode('|', customQuery('userdata', 'userProjects', true, 'userHTTPIP', $userHTTPIP)));
			}
		}
	}

}
function getProjectData($projectID, $projectDataType, $projectDataRows = 'all'){
	$returnArray = array();
	if(strcmp($projectDataType, 'tasks') == 0){
		$projectDataTable = 'tasks';
		$projectDataPID = 'taskProject';
		$projectDataPrefix = 'task';
	}
	if(strcmp($projectDataType, 'issues') == 0){
		$projectDataTable = 'issues';
		$projectDataPID = 'issueProject';
		$projectDataPrefix = 'issue';
	}
	$connect = mysqli_connect("localhost", "root", "");
	mysqli_select_db($connect, "devcenter");
	$sql = "SELECT * FROM `" . $projectDataTable . "` WHERE `" . $projectDataPID . "` = '" . $projectID . "'";//PUT IN ARRAY
	$query = mysqli_query($connect, $sql);
	if (is_bool($query) == true) {
		return 'Invalid';
	}
	while (is_bool($query) == false && $row = mysqli_fetch_array($query)) {
		if(strpos($projectDataRows, 'name') !== false || strcmp($projectDataRows, 'all') == 0){ $returnArray[$row[$projectDataPrefix . "ID"]]['name'] = $row[$projectDataPrefix . 'Name'];}
		if(strpos($projectDataRows, 'content') !== false || strcmp($projectDataRows, 'all') == 0){$returnArray[$row[$projectDataPrefix . "ID"]]['content'] = $row[$projectDataPrefix . 'Content'];}
		if(strpos($projectDataRows, 'dev') !== false || strcmp($projectDataRows, 'all') == 0){$returnArray[$row[$projectDataPrefix . "ID"]]['dev'] = $row[$projectDataPrefix . 'Dev'];}
		if(strpos($projectDataRows, 'project') !== false || strcmp($projectDataRows, 'all') == 0){$returnArray[$row[$projectDataPrefix . "ID"]]['project'] = $row[$projectDataPrefix . 'Project'];}
		if(strpos($projectDataRows, 'tag') !== false || strcmp($projectDataRows, 'all') == 0){$returnArray[$row[$projectDataPrefix . "ID"]]['tag'] = $row[$projectDataPrefix . 'Tag'];}
		if(strpos($projectDataRows, 'level') !== false || strcmp($projectDataRows, 'all') == 0){$returnArray[$row[$projectDataPrefix . "ID"]]['level'] = $row[$projectDataPrefix . 'Level'];}
		if(strpos($projectDataRows, 'status') !== false || strcmp($projectDataRows, 'all') == 0){$returnArray[$row[$projectDataPrefix . "ID"]]['status'] = $row[$projectDataPrefix . 'Status'];}
		if(strpos($projectDataRows, 'user') !== false || strcmp($projectDataRows, 'all') == 0){$returnArray[$row[$projectDataPrefix . "ID"]]['user'] = $row[$projectDataPrefix . 'User'];}
		if(strpos($projectDataRows, 'id') !== false || strcmp($projectDataRows, 'all') == 0){$returnArray[$row[$projectDataPrefix . "ID"]]['id'] = $row[$projectDataPrefix . 'ID'];}
	}
	return $returnArray;
}
function getRealLevel($level){
	if($level == 0){
		return "Owner";
	}
	if($level == 1){
		return "Admin";
	}
	if($level == 2){
		return "Developer";
	}
	if($level == 3){
		return "User";
	}
}
?>
<link rel="stylesheet" href="mainStyle.css" />
<link rel="stylesheet" href="headerStyle.css" />
<script src="plugins/jquery/jquery-1.10.2.min.js"></script>
<div id="navBar" class="noSelect">
	<div id="menuButton">
		Menu
	</div>
	<div id="menu">
		<div class="menuOption">
			My profile
		</div>
		<div class="menuOption">
			<a href="http://127.0.0.1/HTML/GitHub%20Dev.%20Center/home.php" style="color: #E6E6E6; text-decoration: none;">Projects</a>
		</div>
		<div class="menuOption">
			<a href="http://127.0.0.1/HTML/GitHub%20Dev.%20Center/home.php?view=tasks" style="color: #E6E6E6; text-decoration: none;">Tasks</a>
		</div>
		<div class="menuOption" style="border-style: none;">
			<a href="http://127.0.0.1/HTML/GitHub%20Dev.%20Center/home.php" style="color: #E6E6E6; text-decoration: none;">Issues</a>
		</div>
	</div>
	<div id="quickInfo">
		<div class="quickInfoItem" id="quickProfile">
			<?php echo $userName; ?>
		</div>
		<div class="quickInfoItem" id="notifications">
			0
		</div>
		<div class="quickInfoItem" id="logout">
			<a href="logout.php" style="color: #E6E6E6; text-decoration: none;">Logout</a>
		</div>
	</div>
	<div id="logoutNotice">
		Due to inactivity you will be logged out in <span id="timer">&nbsp;</span> seconds
	</div>
</div>

<script>
	$('#menu').hide();
	$('#logoutNotice').hide();
	$('#menuButton').click(function() {
		$('#menu').toggle();
		if ($('#menu').is(":visible") == true) {
			$('#quickInfo').css({
				'margin-top' : '-202px'
			});
		}
		if ($('#menu').is(":visible") == false) {
			$('#quickInfo').css({
				'margin-top' : '-40px'
			});
		}
	});
	$('#quickInfo').css({
		'margin-left' : $(window).width() - 210
	});
	if ($('#notifications').text() != 0) {
		$('#notifications').css({
			'color' : '#DB4242'
		});
	}
	
	var timeSinceClick = 0;

	window.setInterval(function() {
		timeSinceClick = timeSinceClick + 100;
		if(timeSinceClick >= 300000){
			window.location = 'logout.php';
		}
		if(timeSinceClick >= 240000){
			$('#logoutNotice').show('slow');
			$('#timer').html(Math.round(Math.abs((300000 - timeSinceClick) / 1000)));
		}
		if(timeSinceClick <= 300000){
			$('#logoutNotice').hide();
		}
	}, 100);
	
	$(window).click(function(){
		timeSinceClick = 0;
	});
</script>
