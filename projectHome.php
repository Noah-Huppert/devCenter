<?php
$projectID = mysqli_real_escape_string($connect, htmlentities($_GET['id']));
echo "<div class='projectTitle'>" . customQuery('projects', 'projectName', false, $projectID) . "</div>
	<div class='projectDescription'>" . customQuery('projects', 'projectDescription', false, $projectID) . "</div>";
?>
<div id="projectObjects">
	<div id="projectObjectTabs">
		<div id="projectTasksTab" class="projectObjectTab">
			Tasks
		</div>
		<?php
		// '<div id="projectIssuesTab" class="projectObjectTab">';
			echo '<a id="projectIssuesTab" class="projectObjectTab" href="projectIssues.php?projectID=' . mysqli_real_escape_string($connect, htmlentities($_GET['id'])) . '" style="text-decoration: none; color: #EB3434">Issues</a>';
		//echo '</div>';
		?>
		<div id="projectTasks">
			<?php
			echo '<div style="height: 45px;">&nbsp;</div>
			<a style="color: #000000; text-decoration: none; width: 70px; height: 25px; line-height: 25px; border-style: solid; border-width: 1px; border-color: #545454; border-radius: 2px; font-style: italic; font-weight: bold;" 
			href="projectNewTask.php?projectID=' . $_GET['id'] . '">&nbsp;&nbsp;+ New task&nbsp;&nbsp;</a>';
			$projectTasksCounter = 0;
			$projectTasksCount = count(getProjectData($projectID, 'tasks', 'id'));
			$tasksData = getProjectData($projectID, 'tasks', 'name content dev id tag level status user');
			while($projectTasksCounter < $projectTasksCount){
				echo "<div class='taskListItem' id='taskListItem" . $tasksData[$projectTasksCounter]['id'] . "'>
					<div class='taskListItemTitle'>" . 
					$tasksData[$projectTasksCounter]['name'] .
					"</div>
					<div class='taskListItemTag'>" . 
					$tasksData[$projectTasksCounter]['tag'] .
					"</div>
					<div class='taskListItemLevel'>" .
					getRealLevel($tasksData[$projectTasksCounter]['level']) . 
					"</div>
					<div class='taskListItemDev'>" .
					customQuery('userdata', 'userName', true, 'userID', $tasksData[$projectTasksCounter]['dev']) . 
					"</div>
					<div class='taskListRightContainer'>
						<div class='taskListItemUser'>" .
					 	customQuery('userdata', 'userName', true, 'userID', $tasksData[$projectTasksCounter]['user']) . 
						"</div>
						<div class='taskListItemStatus'>" .
					 	$tasksData[$projectTasksCounter]['status'] . 
						"</div>
					</div>
					<script>
						$('#taskListItem" . $tasksData[$projectTasksCounter]['id'] . "').click(function(){
							window.location = 'home.php?view=project&screen=tasks&id=" . $projectID . "&taskID=" . $tasksData[$projectTasksCounter]['id'] . "';
						});
					</script>
				</div>";
				$projectTasksCounter = $projectTasksCounter + 1;
			}
				
			?>
		</div>
		
		<div id="projectIssues">
			<!--<?php
			echo '<div style="height: 45px;">&nbsp;</div>';
			$projectTasksCounter = 0;
			$projectTasksCount = count(getProjectData($projectID, 'issues', 'id'));
			$tasksData = getProjectData($projectID, 'issues', 'name content dev id tag level status user');
			while($projectTasksCounter < $projectTasksCount){
				echo "<div class='taskListItem' id='issueListItem" . $tasksData[$projectTasksCounter]['id'] . "'>
					<div class='taskListItemTitle'>" . 
					$tasksData[$projectTasksCounter]['name'] .
					"</div>
					<div class='taskListItemTag'>" . 
					$tasksData[$projectTasksCounter]['tag'] .
					"</div>
					<div class='taskListItemLevel'>" .
					getRealLevel($tasksData[$projectTasksCounter]['level']) . 
					"</div>
					<div class='taskListItemDev'>" .
					customQuery('userdata', 'userName', true, 'userID', $tasksData[$projectTasksCounter]['dev']) . 
					"</div>
					<div class='taskListRightContainer'>
						<div class='taskListItemUser'>" .
					 	customQuery('userdata', 'userName', true, 'userID', $tasksData[$projectTasksCounter]['user']) . 
						"</div>
						<div class='taskListItemStatus'>" .
					 	$tasksData[$projectTasksCounter]['status'] . 
						"</div>
					</div>
					<script>
						$('#issueListItem" . $tasksData[$projectTasksCounter]['id'] . "').click(function(){
							window.location = 'projectIssues.php?issueID=" . $tasksData[$projectTasksCounter]['id'] . "';
						});
					</script>
				</div>";
					$projectTasksCounter = $projectTasksCounter + 1;
			}
				
			?>-->
		</div>
	</div>

	<script>
		$('#projectIssues').hide();
		$('#projectTasksTab').click(function() {
			$('#projectTasksTab').css({
				'box-shadow' : '3px 0px 10px #B0B0B0'
			});
			$('#projectIssuesTab').css({
				'box-shadow' : 'none'
			});
			$('#projectTasks').show();
			$('#projectIssues').hide();
		});

		$('#projectIssuesTab').click(function() {
			$('#projectTasksTab').css({
				'box-shadow' : 'none'
			});
			$('#projectIssuesTab').css({
				'box-shadow' : '-3px 0px 10px #B0B0B0'
			});
			$('#projectIssues').show();
			$('#projectTasks').hide();
		});
	</script>
</div>
