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
			<?php
				if(isset($_GET['screen']) == true){
					switch(mysqli_real_escape_string($connect, htmlentities($_GET['screen']))){
						case 'home':
							include 'projectHome.php';
						break;
						
						case 'tasks':
							include 'projectTasks.php';
						break;
						
						case 'issues':
							include 'projectIssues.php';
						break;
					}
				}
			?>	
		</div>
		<script>
			function init() {

			}
		</script>
	</body>
</html>