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
			<div style="margin-top: 40px;" id="homePageTitle">
				New Task
			</div>
			<div class="taskContainer" style="margin-top: 86.5px;">
				<div class="taskContentContainer">
					<div class="taskTitle">
						<input placeholder="Task Title" style="width: 598px; height: 30px; border-style: none; border-top-right-radius: 3px; border-top-left-radius: 3px; font-size: 24px; outline: none;" id="taskTitleInput" type="text"/>
					</div>
					<div class="taskContent">
						<textarea placeholder="Task Content" style="width: 100%; min-height: 300px; border-style: none; border-top-right-radius: 3px; border-top-left-radius: 3px; outline: none;" id="taskContentInput" type="text"/>
						</textarea>
					</div>
				</div>
				<div class="taskMeta">
					<div class="tag">
						<span class="metaTitle">Tag: </span><span id="tagSet" style="color: #FF0000;">SET</span>
						<script>
							$(".tag").click(function() {
								$(".tagOptions").toggle();
							});
							$(".tagOptions").click(function() {
								$(".tagOptions").hide();
							});
						</script>
						<div class="tagOptions" style="height: 100px;">
							<span>Please select a tag</span>
							<div id="tagOptionBackend" class="tagOption" style="margin-top: 10px;">
								Backend
							</div>
							<div id="tagOptionGameplay" class="tagOption">
								Gameplay
							</div>
							<div id="tagOptionUI" class="tagOption">
								UI
							</div>
						</div>
					</div>
					<div class="level">
						<span class="metaTitle">Level: </span><span id="levelSet" style="color: #FF0000;">SET</span>
						<div class="levelOptions" style="height: 120px;">
							<span>Please select a level</span>
							<script>
								$(".level").click(function() {
									$(".levelOptions").toggle();
								});
								$(".levelOption").click(function() {
									$(".levelOptions").hide();
								});
							</script>
							<div id="levelOptionOwner" class="levelOption" style="margin-top: 10px;">
								Owner
							</div>
							<div id="levelOptionAdmin" class="levelOption">
								Admin
							</div>
							<div id="levelOptionDeveloper" class="levelOption">
								Developer
							</div>
							<div id="levelOptionUser" class="levelOption">
								User
							</div>
						</div>
						<script>
							$('#levelOptionOwner').click(function() {
								$('#levelSet').html("Owner")
							});
							$('#levelOptionAdmin').click(function() {
								$('#levelSet').html("Admin")
							});
							$('#levelOptionDeveloper').click(function() {
								$('#levelSet').html("Developer")
							});
							$('#levelOptionUser').click(function() {
								$('#levelSet').html("User")
							});
							$('#tagOptionBackend').click(function() {
								$('#tagSet').html("Backend")
							});
							$('#tagOptionUI').click(function() {
								$('#tagSet').html("UI")
							});
							$('#tagOptionGameplay').click(function() {
								$('#tagSet').html("Gameplay")
							});
						</script>
					</div>
				</div>
				<div id="createTaskButton">
					Create Task
					<script>
						//Create Task
$('#createTaskButton').click(function() {
if ($('#taskTitleInput').val() === '') {
alert('Please fill out the task title');
} if ($('#taskContentInput').val() === '') {
alert('Please fill out the task content');
}
if ($('#tagSet').val() === 'SET') {
alert('Please fill out the task tag');
} if ($('#levelSet').val() === 'SET') {
alert('Please fill out the task level');
}
var taskTitle = $('#taskTitleInput').val();
var taskContent = $('#taskContentInput').val();
var taskTag = $('#tagSet').html();
var taskLevel = $('#levelSet').html();
switch(taskLevel) {
case 'Owner':
taskLevel = 0;
break;
case 'Admin':
taskLevel = 1;
break;
case 'Developer':
taskLevel = 2;
break;
case 'User':
taskLevel = 3;
break;
}
window.location = 'createTask.php?taskTitle=' + taskTitle + '&taskContent=' + taskContent + '&taskTag=' + taskTag + '&taskLevel=' + taskLevel + '&taskProject=' +<?php echo $_GET['projectID']; ?>
	;
	});
					</script>
				</div>
			</div>
		</div>
		<script>
			function init() {
			}
		</script>
	</body>
</html>