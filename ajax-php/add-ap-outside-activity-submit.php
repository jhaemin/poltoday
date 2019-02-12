<?php

include '../connect.php';

$result = array("sql_error" => "", "msg" => "");

$row_count = count($_POST['ap_id']);

for ($i = 0; $i < $row_count; $i += 1) {

	$dup_exist = false;

	$ap_id = mysqli_real_escape_string($conn, $_POST['ap_id'][$i]);
	$out_at = mysqli_real_escape_string($conn, $_POST['out_at'][$i]);
	$in_at = mysqli_real_escape_string($conn, $_POST['in_at'][$i]);
	if (isset($_POST['type'][$i])) {
		$type = mysqli_real_escape_string($conn, $_POST['type'][$i]);
	} else {
		$result['msg'] = '분류를 설정하지 않았습니다.';
		break;
	}
	$display_name = mysqli_real_escape_string($conn, $_POST['display_name'][$i]);
	$out_time = "";
	if (isset($_POST['out_time'][$i])) {
		$out_time = mysqli_real_escape_string($conn, $_POST['out_time'][$i]);
	}
	$in_time = "";
	if (isset($_POST['in_time'][$i])) {
		$in_time = mysqli_real_escape_string($conn, $_POST['in_time'][$i]);
	}
	$note = "";
	if (isset($_POST['note'][$i])) {
		$note = mysqli_real_escape_string($conn, $_POST['note'][$i]);
	}

	// Check duplication
	// 중복 알고리즘 업데이트
	// 업데이트 전: 완전히 같은 기간의 이벤트만 중복 처리
	// 업데이트 후 -> 같은 기간 내에 다른 이벤트가 있으면 중복 처리
	// $sql = "SELECT * FROM ap_outside_activity WHERE ap_id='$ap_id' AND out_at='$out_at' AND in_at='$in_at'";
	$sql = "SELECT * FROM ap_outside_activity WHERE ap_id = '$ap_id' AND (('$out_at' >= out_at AND '$out_at' <= in_at) OR ('$in_at' >= out_at AND '$in_at' <= in_at))";
	$dup_result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($dup_result) > 0) {
		$dup_event = mysqli_fetch_assoc($dup_result);
		$sql = "SELECT * FROM ap_info WHERE id='$ap_id'";
		$name = mysqli_fetch_assoc(mysqli_query($conn, $sql))['name'];
		$result['msg'] .= '중복: ' . $name . ' ' . $dup_event['display_name']. ", ";
		$dup_exist = true;
	}

	if (!$dup_exist) {
		$sql = "INSERT INTO ap_outside_activity (ap_id, out_at, in_at, out_time, in_time, type, display_name, note) VALUES ('$ap_id', '$out_at', '$in_at', '$out_time', '$in_time', '$type', '$display_name', '$note')";

		$ap_add_outside_activity_result = mysqli_query($conn, $sql);

		if (!$ap_add_outside_activity_result) {
			$result['sql_error'] = mysqli_error($conn);
		}
	}

}

echo json_encode($result);

?>
