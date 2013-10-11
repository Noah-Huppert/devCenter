<?php
if (isset($_GET['taskID'])) {
	$taskID = mysqli_real_escape_string($connect, htmlentities($_GET['taskID']));
}
if (isset($_GET['id'])) {
	$projectID = mysqli_real_escape_string($connect, htmlentities($_GET['id']));
}
?>
<div class="taskContainer">
	<div class="taskContentContainer" style="margin-top: 80px;">
		<div class="taskTitle">
			<?php
			echo customQuery('tasks', 'taskName', true, 'taskID', $taskID);
			?>
		</div>
			<?php
			echo '<TEXTAREA class="taskContent" readonly outline>' . customQuery('tasks', 'taskContent', true, 'taskID', $taskID) . "</TEXTAREA>";
			?>
	</div>
	<div class="taskMeta">
		<div class="status">
			<?php
			$statusChanger;
			$statusOptions = '';
			if(customQuery('tasks', 'taskUser', true, 'taskID', $taskID) == getUserData('name') || 
			customQuery('tasks', 'taskDev', true, 'taskID', $taskID) == getUserData('name') || 
			customQuery('userdata', 'userLevel', true, 'userID', getUserData('name')) >= 2){
				$statusChanger = '
				window.onload = function(){
					$(".statusOptions").hide();
					$(".tagOptions").hide();
					$(".levelOptions").hide();
				};
				$(".status").click(function(){
					$(".statusOptions").toggle();
					$(".status").css({
						"margin-bottom" : "2px"
					});
				});
				$(".statusOptions").click(function(){
					$(".statusOptions").hide();
					$(".status").css({
						"margin-bottom" : "10px"
					});
				});
				';
				switch(customQuery('tasks', 'taskStatus', true, 'taskID', $taskID)){
					case 'Complete':
						$statusOptions = '<div id="statusOptionPending" class="statusOption" style="margin-top: 10px;">Pending</div><div id="statusOptionClosed" class="statusOption">Closed</div>';
					break;
					
					case 'Pending':
						$statusOptions = '<div id="statusOptionComplete" class="statusOption" style="margin-top: 10px;">Complete</div><div id="statusOptionClosed" class="statusOption">Closed</div>';
					break;
					
					case 'Closed':
						$statusOptions = '<div id="statusOptionPending" class="statusOption" style="margin-top: 10px;">Pending</div><div id="statusOptionComplete" class="statusOption">Complete</div>';
					break;
				}
				$statusOptions = $statusOptions . '
				<script>
				$("#statusOptionComplete").click(function(){
					$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskStatus`=' . "'Complete'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           				location.reload();
          			}).error(function(){
            			alert("Action failed. Please Reload page and try again");
          			});
				});
				$("#statusOptionPending").click(function(){
					$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskStatus`=' . "'Pending'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           				location.reload();
          			}).error(function(){
            			alert("Action failed. Please Reload page and try again");
          			});
				});
				$("#statusOptionClosed").click(function(){
					$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskStatus`=' . "'Closed'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           				location.reload();
          			}).error(function(){
            			alert("Action failed. Please Reload page and try again");
          			});
				});
          		</script>';
			}
			echo "<span id='staskStatus'>" . customQuery('tasks', 'taskStatus', true, 'taskID', $taskID) . 
			"</span><script>
			switch($('#staskStatus').html()){
				case 'Complete':
					statusColor = '#00FF00';
				break;
				
				case 'Pending':
					statusColor = '#FFDE24';
				break;
				
				case 'Closed':
					statusColor = '#FF0000';
				break;
			}
			$('.status').css({
				'background' : statusColor
			});
			$('.taskContainer').css({
				'margin-top' : (($(window).height() / 2) - ($('.taskContainer').height() / 2)) - 100
			});" . $statusChanger . "
			</script>";
			?>
		</div>
		<div class="statusOptions">
			<?php
				if(strcmp($statusOptions, '') != 0){
					echo "
					<span>Please select new status</span>";
				}
				echo $statusOptions;
			?>
		</div>
		<div class="tag">
			<?php
			if(customQuery('tasks', 'taskUser', true, 'taskID', $taskID) == getUserData('name') || 
			customQuery('tasks', 'taskDev', true, 'taskID', $taskID) == getUserData('name') || 
			customQuery('userdata', 'userLevel', true, 'userID', getUserData('name')) >= 2){
				switch(customQuery('tasks', 'taskTag', true, 'taskID', $taskID)){
					case 'UI':
						$tagOptions = '<div id="tagOptionGameplay" class="tagOption" style="margin-top: 10px;">Gameplay</div><div id="tagOptionBackend" class="tagOption">Backend</div>';
					break;
						
					case 'Gameplay':
						$tagOptions = '<div id="tagOptionUI" class="tagOption" style="margin-top: 10px;">UI</div><div id="tagOptionBackend" class="tagOption">Backend</div>';
					break;
					
					case 'Backend':
						$tagOptions = '<div id="tagOptionGameplay" class="tagOption" style="margin-top: 10px;">Gameplay</div><div id="tagOptionUI" class="tagOption">UI</div>';
					break;
				}
					
				$tagOptions = $tagOptions . '
				<script>
					$("#tagOptionGameplay").click(function(){
						$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskTag`=' . "'Gameplay'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          				}).error(function(){
            				alert("Action failed. Please Reload page and try again");
          				});
					});
					$("#tagOptionBackend").click(function(){
						$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskTag`=' . "'Backend'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          				}).error(function(){
            				alert("Action failed. Please Reload page and try again");
          				});
					});
					$("#tagOptionUI").click(function(){
						$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskTag`=' . "'UI'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          				}).error(function(){
            				alert("Action failed. Please Reload page and try again");
          				});
					});
				</script>';
				$tagOptionsScript = '
				<script>
					$(".tag").click(function(){
						$(".tagOptions").toggle();
					});
					$(".tagOptions").click(function(){
						$(".tagOptions").hide();
					});
				</script>';
			}
			echo "<span class='metaTitle'>Tag: </span>" . customQuery('tasks', 'taskTag', true, 'taskID', $taskID);
			echo $tagOptionsScript;
			?>
			<div class="tagOptions">
				<?php
					if(strcmp($tagOptions, '') != 0){
					echo "
						<span>Please select new tag</span>";
					}
					echo $tagOptions;
				?>
			</div>
		</div>
		<div class="level">
			<?php
			if(customQuery('tasks', 'taskUser', true, 'taskID', $taskID) == getUserData('name') || 
			customQuery('tasks', 'taskDev', true, 'taskID', $taskID) == getUserData('name') || 
			customQuery('userdata', 'userLevel', true, 'userID', getUserData('name')) >= 2){
				$levelOptions = '';
				switch(customQuery('tasks', 'taskLevel', true, 'taskID', $taskID)){
					case 0://Owner
						$levelOptions = '
						<div id="levelOptionAdmin" class="levelOption" style="margin-top: 10px;">Admin</div>
						<div id="levelOptionDeveloper" class="levelOption">Developer</div>
						<div id="levelOptionUser" class="levelOption">User</div>';
					break;
						
					case 1://Admin
						$levelOptions = '
						<div id="levelOptionOwner" class="levelOption" style="margin-top: 10px;">Owner</div>
						<div id="levelOptionDeveloper" class="levelOption">Developer</div>
						<div id="levelOptionUser" class="levelOption">User</div>';
					break;
					
					case 2://Developer
						$levelOptions = '
						<div id="levelOptionOwner" class="levelOption" style="margin-top: 10px;">Owner</div>
						<div id="levelOptionAdmin" class="levelOption">Admin</div>
						<div id="levelOptionUser" class="levelOption">User</div>';
					break;
					case 3://User
						$levelOptions = '
						<div id="levelOptionOwner" class="levelOption" style="margin-top: 10px;">Owner</div>
						<div id="levelOptionAdmin" class="levelOption">Admin</div>
						<div id="levelOptionDeveloper" class="levelOption">Developer</div>';
					break;
				}
				
				$levelOptions = $levelOptions . '
				<script>
					$("#levelOptionOwner").click(function(){
						$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskLevel`=' . "'0'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          				}).error(function(){
            				alert("Action failed. Please Reload page and try again");
          				});
					});
					$("#levelOptionAdmin").click(function(){
						$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskLevel`=' . "'1'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          				}).error(function(){
            				alert("Action failed. Please Reload page and try again");
          				});
					});
					$("#levelOptionDeveloper").click(function(){
						$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskLevel`=' . "'2'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          				}).error(function(){
            				alert("Action failed. Please Reload page and try again");
          				});
					});
					$("#levelOptionUser").click(function(){
						$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskLevel`=' . "'3'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          				}).error(function(){
            				alert("Action failed. Please Reload page and try again");
          				});
					});
				</script>';
				$levelOptionsScript = '
				<script>
					$(".level").click(function(){
						$(".levelOptions").toggle();
					});
					$(".levelOptions").click(function(){
						$(".levelOptions").hide();
					});
				</script>';
			}
			echo "<span class='metaTitle'>Level: </span>" . getRealLevel(customQuery('tasks', 'taskLevel', true, 'taskID', $taskID));
			?>
			<div class="levelOptions">
				<?php
					if(strcmp($levelOptions, '') != 0){
					echo "
						<span>Please select new level</span>";
					}
					echo $levelOptionsScript;
					echo $levelOptions;
				?>
			</div>
		</div>
		<div class="dev">
			<?php
				echo "<span class='metaTitle'>Dev: </span><span id='devValue'>" . customQuery('userdata', 'userName', true, 'userID', customQuery('tasks', 'taskDev', true, 'taskID', $taskID)) . "</span>";
			?>
			<div class="devOptions">
				<?php
					echo "<div id='changeDevButton'>Unable to Claim</div>
					<script>" . '
					if($("#devValue").html() == "' . getUserData('name', true) . '"){
						$("#changeDevButton").html("Dump Task");
						var dumpTask = true;
					}
					if(dumpTask != true && $("#devValue").html() == "null"){
							$("#changeDevButton").html("Claim Task");
						}
					$("#changeDevButton").click(function(){
						if(dumpTask != true && $("#devValue").html() == "null"){
							$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskDev`=' . getUserData('name') . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          					}).error(function(){
            					alert("Action failed. Please Reload page and try again");
          					});
						}
						if(dumpTask == true){
							alert("UPDATE `tasks` SET `taskDev`=' . "'9001'" . ' WHERE `taskID`=' . "'" . $taskID . "'" . '");
							$.post("jsQuery.php", {sql: "UPDATE `tasks` SET `taskDev`=' . "'9001'" . ' WHERE `taskID`=' . $taskID . '"}, function(){
           					location.reload();
          					}).error(function(){
            					alert("Action failed. Please Reload page and try again");
          					});
						}
					});
					' . "</script>";
				?>
			</div>
		</div>
	</div>
</div>
