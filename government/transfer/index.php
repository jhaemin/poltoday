<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>인수인계장</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
		<link rel="stylesheet" href="css/transfer.css" />
    </head>
    <body id="transfer-body">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
        <main id="transfer-main">
			<div class="">
				<h1 class="typography-header">인수인계장</h1>
			</div>
			<div class="diary-container">
				<div class="diary-wrapper">
					<h2 class="part-header">서무</h2>
					<div class="diary-contents document" contenteditable="true"></div>
				</div>
				<div class="diary-wrapper">
					<h2 class="part-header">장비</h2>
					<div class="diary-contents armor" contenteditable="true"></div>
				</div>
				<div class="diary-wrapper">
					<h2 class="part-header">경리</h2>
					<div class="diary-contents finance" contenteditable="true"></div>
				</div>
			</div>
        </main>
		<script src="js/transfer.js"></script>
    </body>
</html>
