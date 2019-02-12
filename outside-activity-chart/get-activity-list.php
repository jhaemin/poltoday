<?php

// Get activity list of the month

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');

$days_count = date('t');

$year = date('Y');
$month = date('n');

// Set year and month manually
if ($_POST) {
	$year = $_POST['year'];
	$month = $_POST['month'];
}

$sql = "SELECT * FROM ap_outside_activity WHERE
(
	(year(in_at) = '$year' AND month(in_at) = '$month') OR
	(year(out_at) = '$year' AND month(out_at) = '$month') OR
	(
		((year(out_at) < '$year') OR (year(out_at) = '$year' AND month(out_at) < '$month')) AND
		((year(in_at) > '$year') OR (year(in_at) = '$year' AND month(in_at) > '$month'))
	)
) AND
(type=1 OR type=2 OR type=3 OR type=5 OR type=8) ORDER BY out_at";

$get_activity_list_result = mysqli_query($conn, $sql);

if (!$get_activity_list_result) {
	die(mysqli_error($conn));
}

// Create arrays for each platoon
$platoon_0_list = [];
$platoon_1_list = [];
$platoon_2_list = [];
$platoon_3_list = [];
$platoon_g_list = [];

while ($activity = mysqli_fetch_assoc($get_activity_list_result)) {
	$ap_id = $activity['ap_id'];
	$activity_id = $activity['id'];
	$out_at = $activity['out_at'];
	$in_at = $activity['in_at'];
	$type = $activity['type'];
	$display_name = $activity['display_name'];
	$out_time = $activity['out_time'];
	$in_time = $activity['in_time'];

	$ap_info = get_ap_info($ap_id);
	if ($ap_info['moved_out']) {
		continue;
	}
	$platoon = $ap_info['platoon'];
	$name = $ap_info['name'];
	$roll = $ap_info['roll'];

	if ($platoon == 0 && $roll != 2 || $roll == 3) {
		$platoon_0_list[] = array(
			"ap_id" => $ap_id,
			"activity_id" => $activity_id,
			"name" => $name,
			"out_at" => $out_at,
			"in_at" => $in_at,
			"type" => $type,
			"display_name" => $display_name,
			"out_time" => $out_time,
			"in_time" => $in_time
		);
	} else if ($platoon == 1 && $roll == 1) {
		$platoon_1_list[] = array(
			"ap_id" => $ap_id,
			"activity_id" => $activity_id,
			"name" => $name,
			"out_at" => $out_at,
			"in_at" => $in_at,
			"type" => $type,
			"display_name" => $display_name,
			"out_time" => $out_time,
			"in_time" => $in_time
		);
	} else if ($platoon == 2 && $roll == 1) {
		$platoon_2_list[] = array(
			"ap_id" => $ap_id,
			"activity_id" => $activity_id,
			"name" => $name,
			"out_at" => $out_at,
			"in_at" => $in_at,
			"type" => $type,
			"display_name" => $display_name,
			"out_time" => $out_time,
			"in_time" => $in_time
		);
	} else if ($platoon == 3 && $roll == 1) {
		$platoon_3_list[] = array(
			"ap_id" => $ap_id,
			"activity_id" => $activity_id,
			"name" => $name,
			"out_at" => $out_at,
			"in_at" => $in_at,
			"type" => $type,
			"display_name" => $display_name,
			"out_time" => $out_time,
			"in_time" => $in_time
		);
	} else if ($roll == 2) {
		$platoon_g_list[] = array(
			"ap_id" => $ap_id,
			"activity_id" => $activity_id,
			"name" => $name,
			"out_at" => $out_at,
			"in_at" => $in_at,
			"type" => $type,
			"display_name" => $display_name,
			"out_time" => $out_time,
			"in_time" => $in_time
		);
	}
}

if ($_POST) {
	$result = [];
	$result[] = $platoon_0_list;
	$result[] = $platoon_1_list;
	$result[] = $platoon_2_list;
	$result[] = $platoon_3_list;
	$result[] = $platoon_g_list;

	echo json_encode($result);
}

?>
