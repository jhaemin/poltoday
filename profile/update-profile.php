<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

if (isset($_GET['ap_id'])) {
	$ap_id = $_GET['ap_id'];
} else {
	header('Location: /ap-info');
}

$today = date('Y-m-d');

if (strlen($_GET['date']) != 0) {
	$date = $_GET['date'];
	$today = $date;
}
if (isset($_GET['platoon'])) {$to_platoon = $_GET['platoon'];}
if (isset($_GET['roll'])) {$to_roll = $_GET['roll'];}
if (isset($_GET['moved_out'])) {$moved_out = 1;}

// Update platoon
if (isset($to_platoon)) {
	$from_val = get_ap_info($ap_id)['platoon'];

	$sql = "UPDATE ap_info SET platoon='$to_platoon' WHERE id='$ap_id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }

	$sql = "INSERT INTO ap_info_change_event (ap_id, type, from_val, to_val, changed_at) VALUES ('$ap_id', 'platoon', '$from_val', '$to_platoon', '$today')";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }

}

// Update roll
if (isset($to_roll)) {
	// echo 'new roll has been set';

	$from_val = get_ap_info($ap_id)['roll'];

	$sql = "UPDATE ap_info SET roll='$to_roll' WHERE id='$ap_id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }

	$sql = "INSERT INTO ap_info_change_event (ap_id, type, from_val, to_val, changed_at) VALUES ('$ap_id', 'roll', '$from_val', '$to_roll', '$today')";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
}

// Update moveout
if (isset($moved_out)) {

	$from_val = get_ap_info($ap_id)['moved_out'];

	$sql = "UPDATE ap_info SET moved_out='$moved_out' WHERE id='$ap_id'";
	if (!mysqli_query($conn, $sql)) {
		echo mysqli_error($conn);
	}

	$sql = "INSERT INTO ap_info_change_event (ap_id, type, from_val, to_val, changed_at) VALUES ('$ap_id', 'moved_out', '$from_val', '$moved_out', '$today')";
	if (!mysqli_query($conn, $sql)) {
		echo mysqli_error($conn);
	}

	// echo 'success';
}

?>