<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

?>

<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" href="css/ed.css?v=1.000">
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/globalnav.php'; ?>

	<main id="ed-main">

		<h1 class="typography-header">전자기기</h1>

		<div class="radio-container">
			<div class="radio-wrapper">
				<input class="platoon-select" type="radio" name="platoon" checked>
			</div>
			<input class="platoon-select" type="radio" name="platoon">
			<input class="platoon-select" type="radio" name="platoon">
		</div>

	</main>

</body>
</html>