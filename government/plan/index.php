<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

if (!isset($_SESSION['verified'])) {
	header("Location: /government");
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>근무지정표</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="govern-plan-main">
		<h1 class="typography-header gp-headline">근무지정표</h1>
		<div class="application">

		</div>
	</main>
</body>
</html>
