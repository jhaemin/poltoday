<?php
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$count = $_POST['count'];
$ap_id = $_POST['ap_id'];

$type = $_POST['type'];

if ($type == "go_out") {
	$sql = "UPDATE ap_info SET milage_go_out = '$count' WHERE id = '$ap_id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		echo mysqli_error($conn);
	}
} else if ($type == "out_sleep") {
	$sql = "UPDATE ap_info SET milage_out_sleep = '$count' WHERE id = '$ap_id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		echo mysqli_error($conn);
	}
}


