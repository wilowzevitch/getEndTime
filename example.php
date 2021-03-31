<?php

include 'define.php';
include 'getEndTime.php';

$start = isset($_POST['start']) ? $_POST['start'] : false;
$timeNeed = isset($_POST['timeNeed']) ? $_POST['timeNeed'] : false;

?>

<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>getEndTime</title>
</head>
<body>
	<br />
	<form method="POST" style="text-align: center;">
		<input type="datetime-local" name="start" value="<?= isset($_POST['start']) ? $_POST['start'] : ''; ?>" />
		<input type="text" name="timeNeed" value="<?= isset($_POST['timeNeed']) ? $_POST['timeNeed'] : ''; ?>" />
		<button type="submit">Valid</button>
	</form>
	<br  />
	<div class="result">
		<?php if($start && $timeNeed) {
			echo getEndTime($start, $timeNeed);
		} else {
			echo 'No data send !';
		} ?>		
	</div>
</body>
</html>