<?php

include '../connect.php';

$result = array("sql_error" => "", "msg" => "", "num_rows" => "");

$row_count = count($_POST['name']);

for ($i = 0; $i < $row_count; $i += 1) {

	$error = false;

	$name = mysqli_real_escape_string($conn, $_POST['name'][$i]);
	if (isset($_POST['phone_number'])) { $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number'][$i]); }
	if (isset($_POST['enroll_at'])) { $enroll_at = mysqli_real_escape_string($conn, $_POST['enroll_at'][$i]); }
	if (isset($_POST['transfer_at'])) { $transfer_at = mysqli_real_escape_string($conn, $_POST['transfer_at'][$i]); }
	if (isset($_POST['discharge_at'])) { $discharge_at = mysqli_real_escape_string($conn, $_POST['discharge_at'][$i]); }
	if (isset($_POST['birthday'])) { $birthday = mysqli_real_escape_string($conn, $_POST['birthday'][$i]); }
	if (isset($_POST['level'])) { $level = mysqli_real_escape_string($conn, $_POST['level'][$i]); }
	if (isset($_POST['platoon'])) {
		$platoon = mysqli_real_escape_string($conn, $_POST['platoon'][$i]);
	} else {
		$error = true;
		$result['msg'] = "소대가 지정되지 않았습니다. 소대는 중요합니다.";
	}

	if (!isset($name)) {
		$result['msg'] = "이름이 없습니다.";
		$error = true;
	}

	$phone_number = preg_replace('/[^0-9]/', '', $phone_number);

	// Check duplication
	$sql = "SELECT * FROM ap_info WHERE name='$name' AND phone_number='$phone_number'";
	$dup_result = mysqli_query($conn, $sql);
	$result['num_rows'] = mysqli_num_rows($dup_result);
	if (mysqli_num_rows($dup_result) > 0) {
		$result['msg'] .= '중복: ' . $name . ", ";
		$error = true;
	}

	if (!$error) {
		$sql = "INSERT INTO ap_info (name, phone_number, enroll_at, transfer_at, discharge_at, birthday, level, platoon, roll, moved_out) VALUES ('$name', '$phone_number', '$enroll_at', '$transfer_at', '$discharge_at', '$birthday', '$level', '$platoon', 1, 0)";

		$ap_add_result = mysqli_query($conn, $sql);

		if (!$ap_add_result) {
			$result['sql_error'] = mysqli_error($conn);
		}
	}

}

echo json_encode($result);

?>