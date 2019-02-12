<?php
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/php-module/database-api.php';

$today = date('Y-m-d');
if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>경력일보 출력</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/daily-working-info.css?v=1.000" />
</head>
<body id="dwi">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/globalnav.php'; ?>
	<main id="dwi-main">
		<div id="drop-zone">
			<div class="drop-indicator"></div>
			<div style="text-align: center;">
				<div class="icon">
					<div class="line"></div>
					<div class="line"></div>
					<div class="line"></div>
					<div class="line"></div>
				</div>
				<span class="manifesto">경력일보 파일<br>드래그 앤 드롭</span>
				<div class="option-container">
					<div class="option">
						<span class="title">두 쪽</span>
						<input type="radio" name="page-count" value="2">
					</div>
					<div class="option">
						<span class="title">네 쪽</span>
						<input type="radio" name="page-count" value="4" checked>
					</div>
				</div>
			</div>
		</div>
		<div class="page-container section-to-print" style="display:none;"></div>
	</main>
	<script src="js/daily-working-info.js"></script>
</body>