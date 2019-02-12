<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$report_id = "";
$report_contents = "";
$exact_time = "";
$time_update = "";
$first_set = "";

$report_id = $_POST['report_id'];
if (isset($_POST['report_at'])) {
	$report_at = $_POST['report_at'];	
}

$ap_id = $_POST['ap_id'];
if (isset($_POST['report_contents'])) {
	$report_contents = $_POST['report_contents'];
}

$exact_time = date('H:i');
if (isset($_POST['exact_time'])) {
	$exact_time = $_POST['exact_time'];
}
$time_update = $_POST['time_update'];

// Check if there is already a data for the reportID
$sql = "SELECT * FROM outside_report WHERE id='$report_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
	// Exists
	if ($time_update) {
		if ($report_contents == "") {
			$sql = "UPDATE outside_report SET exact_time='$exact_time' WHERE id='$report_id'";
		} else {
			$sql = "UPDATE outside_report SET report_contents='$report_contents', exact_time='$exact_time' WHERE id='$report_id'";
		}
	} else {
		$sql = "UPDATE outside_report SET report_contents='$report_contents' WHERE id='$report_id'";
	}
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
} else {
	$sql = "INSERT INTO outside_report (ap_id, report_at, exact_time, report_contents) VALUES ('$ap_id', '$report_at', '$exact_time', '$report_contents')";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
	$report_id = mysqli_insert_id($conn);
	$first_set = 1;
}

$result = [
	"exact_time" => $exact_time,
	"report_id" => $report_id,
	"time_update" => $time_update,
	"first_set" => $first_set
];

echo json_encode($result);

?>