<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$today = date('Y-m-d');
if (isset($_POST['date'])) {
	$today = $_POST['date'];
}

$sql = "SELECT * FROM tddj WHERE dj_at='$today'";
$result = mysqli_query($conn, $sql);

$exists = false;

if (mysqli_num_rows($result) > 0) {
	$exists = true;
}

if (isset($_POST['first']) || isset($_POST['second'])) {
	$new_first = "";
	$new_second = "";
	if (isset($_POST['first'])) {
		$new_first = $_POST['first'];
	}
	if (isset($_POST['second'])) {
		$new_second = $_POST['second'];
	}
	if ($exists) {
		$sql = "UPDATE tddj SET `first`='$new_first', `second`='$new_second' WHERE `dj_at`='$today'";
	} else {
		$sql = "INSERT INTO tddj (`first`, `second`, `dj_at`) VALUES ('$new_first', '$new_second', '$today')";
	}
	$result = mysqli_query($conn, $sql);

}