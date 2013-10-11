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
	/*echo "
	 Login Data:<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;IP:<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client HTTPIP: " . $userHTTPIP . "<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Database HTTPIP: " .  $row['userHTTPIP'] . "<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Compare: </strong>" . strcmp($row['userHTTPIP'], $userHTTPIP) . "
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Client Remote IP: " . $userIP . "<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Database Remote IP: " .  $row['userRemoteIP'] . "<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Compare: </strong>" . strcmp($row['userRemoteIP'], $userIP) . "<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;Session:<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Session: " . $row['userSession'] . "<br>
	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Compare: </strong>" . strcmp($row['userSession'], 'active') . "<hr>";*/
	if (strcmp($row['userHTTPIP'], $userHTTPIP) == 0 && strcmp($row['userRemoteIP'], $userIP) == 0 && strcmp($row['userSession'], 'active') == 0) {
		/*echo "Live HTTIP: " . $userHTTPIP .
		 "<br>Live Remote IP: " . $userIP .
		 "<br>DB HTTPIP: " . $row['userHTTPIP'] .
		 "<br>DB Remote IP: " . $row['userRemoteIP'] .
		 "<br>DB User Session: " . $row['userSession'] .
		 "<hr>";*/
		$logged = true;
		if (isset($_GET['view']) == true) {
			switch(mysqli_real_escape_string($connect, htmlentities($_GET['view']))) {
				case 'project' :
					include "projectContent.php";
					break;

				case 'tasks' :
					include "userTasks.php";
					break;

				default :
					include "homeContent.php";
					break;
			}
		} else {
			include "homeContent.php";
		}
	}
	//if (strcmp($row['userHTTPIP'], $userHTTPIP) != 0 && strcmp($row['userRemoteIP'], $userIP) != 0 && strcmp($row['userSession'], 'active') != 0) {
	//echo "<script>window.location = 'login.php?invalid=true';</script>";
	/*echo "Live HTTIP: " . $userHTTPIP .
	 "<br>Live Remote IP: " . $userIP .
	 "<br>DB HTTPIP: " . $row['userHTTPIP'] .
	 "<br>DB Remote IP: " . $row['userRemoteIP'] .
	 "<br>DB User Session: " . $row['userSession'] .
	 "<hr>";*/
	//}
}
if ($logged == false) {
	echo "<script>window.location = 'login.php?invalid=true';</script>";
	//echo "Pulled to login[INVALID]<br>";
}
?>
<script>
	window.onbeforeunload = function() {
		window.location = 'logout.php';
	}; 
</script>