<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$response = ['success' => 0, 'error_msg' => ''];

// Get POST date from ajax
$date = $_POST['date'];
$ap_id = $_POST['ap_id'];
$platoon = get_ap_info($ap_id)['platoon'];

$sql = "SELECT *
		FROM autonomous
		WHERE ap_id='$ap_id' AND work_at='$date'";
$result = mysqli_query($conn, $sql);

// 중복처리
if (mysqli_num_rows($result) > 0) {
	$response['success'] = 0;
	$response['error_msg'] = "이미 있습니다.";
} else {
	// insert the new item.
	$sql = "INSERT INTO autonomous (ap_id, platoon, work_at)
		VALUES ('$ap_id', '$platoon', '$date')";

	$result = mysqli_query($conn, $sql);

	if ($result) {
		$response['success'] = 1;
	}
}

echo json_encode($response);

?>