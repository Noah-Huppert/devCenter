<?php
	include "loggedHeader.php";
	echo '<iframe id="issuesFrame" style="border: none;" href="' . customQuery('issueLink', 'link', true, 'project', mysqli_real_escape_string($connect, htmlentities($_GET['projectID']))) . '"></iframe>';
?>
<script>
	$('#issuesFrame').css({
		'height' : $(window).height - 40,
		'width' : '100%'
	});
</script>