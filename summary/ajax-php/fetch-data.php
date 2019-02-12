<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php-module/database-api.php';

$today = date('Y-m-d');
// $today = "2018-10-30";

$kind = $_POST["kind"];

// 의무경찰 현황
if ($kind == "ap-status") {

	include $_SERVER['DOCUMENT_ROOT'] . '/absent-list/absent-combo.php';
	
	$result = [
		"all" => count(get_currently_serving_member()),
		"platoon_all" => [],
		"platoon_work" => [],
		"platoon_real_work" => []
	];
	$result["platoon_all"][] = count(get_currently_serving_member(0));
	$result["platoon_all"][] = count(get_currently_serving_member(1));
	$result["platoon_all"][] = count(get_currently_serving_member(2));
	$result["platoon_all"][] = count(get_currently_serving_member(3));

	$result["platoon_work"][] = num_go_out($platoon_0_absent, 0);
	$result["platoon_work"][] = num_go_out($platoon_1_absent, 1);
	$result["platoon_work"][] = num_go_out($platoon_2_absent, 2);
	$result["platoon_work"][] = num_go_out($platoon_3_absent, 3);

	echo json_encode($result);

} else if ($kind == "duty") {

	$agents = get_agent_working_info($today, "govern");

	echo json_encode($agents);

} else if ($kind == "absent") {

	$sql = "SELECT * FROM
	        ap_outside_activity JOIN
					ap_info ON
					ap_outside_activity.ap_id = ap_info.id
	        WHERE out_at <= '$today'
					AND in_at >= '$today'
					AND (type = 1 OR type = 2 OR type = 3 OR type = 5 OR type = 6 OR type = 8)
					ORDER BY ap_info.platoon, ap_info.name";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		die(mysqli_error($conn));
	}
	$return = [
		'absent' => [],
		'remain' => []
	];
	while ($row = mysqli_fetch_assoc($result)) {
		$return['absent'][] = $row;
	}


	$sql = "SELECT * FROM
	        ap_outside_activity JOIN
	        ap_info ON
	        ap_outside_activity.ap_id = ap_info.id
	        WHERE out_at <= '$today'
	        AND in_at >= '$today'
	        AND (type = 9 OR type = 10)
					ORDER BY ap_info.platoon, ap_info.name";
	
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		die(mysqli_error($conn));
	}
	while ($row = mysqli_fetch_assoc($result)) {
		$return['remain'][] = $row;
	}

	echo json_encode($return);

} else if ($kind == "remain") {

	$autonomous = get_today_autonomous($today);

} else if ($kind == "serverTime") {
	echo $today;
} else if ($kind == "schedule") {
	$sql = "SELECT * FROM schedule WHERE id = 1";
	$result = mysqli_query($conn, $sql);
	$data = mysqli_fetch_assoc($result)['data'];
	echo $data;
} else if ($kind == "tddj") {

	$sql = "SELECT * FROM tddj WHERE dj_at='$today'";
	$result = mysqli_query($conn, $sql);
	$dj = mysqli_fetch_assoc($result);
	$first = $dj['first'];
	$second = $dj['second'];

	$return = [
		'first' => $first,
		'second' => $second
	];

	echo json_encode($return);

} else if ($kind == "autonomous") {
	$autonomous = get_today_autonomous($today);
	$return = [];
	$return[] = get_ap_info($autonomous[0]["ap_id"])["name"];
	$return[] = get_ap_info($autonomous[1]["ap_id"])["name"];
	$return[] = get_ap_info($autonomous[2]["ap_id"])["name"];

	echo json_encode($return);
}