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
				Your Projects
			</div>
			<div id="userProjects">
				<?php
				$projectDisplayCounter = 0;
					while($projectDisplayCounter < getUserData('projectsCount')){
						echo '<div class="projectItem" id="projectItem' . $projectDisplayCounter . '">';
						echo customQuery('projects', 'projectName', true, 'projectID', getUserData('projects')[$projectDisplayCounter]);
						echo "
						<script>
						$('#projectItem" . $projectDisplayCounter . "').click(function(){
							window.location = 'home.php?view=project&screen=home&id=" . $projectDisplayCounter . "';
						});
						</script>";
						$projectDisplayCounter ++;
						echo '</div>';
					}
				?>
			</div>
									
		</div>
		<script>
			function init() {

			}
		</script>
	</body>
</html>