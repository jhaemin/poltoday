<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';
session_write_close();

$search_anything = $_POST['search_anything'];

$today_date = date("Y-m-d");

if ($search_anything !== "") {
	$sql = "SELECT * FROM ap_info WHERE (name LIKE '%{$search_anything}%' OR platoon LIKE '%{$search_anything}%' OR level LIKE '%{$search_anything}%' OR phone_number LIKE '%{$search_anything}%' OR enroll_at LIKE '%{$search_anything}%' OR roll LIKE '%{$search_anything}%') AND '$today_date' < discharge_at AND moved_out=0 ORDER BY level, platoon, name";
	$result = mysqli_query($conn, $sql);
} else {
	$result = get_currently_serving_member($today_date);
}

$search_result = array();

while ($row = mysqli_fetch_assoc($result)) {
	$ap = array(
		'id' => $row['id'],
		'name' => $row['name'],
		'level' => $row['level'],
		'platoon' => $row['platoon'],
		'phone_number' => $row['phone_number'],
		'enroll_at' => $row['enroll_at'],
		'discharge_at' => $row['discharge_at']
	);
	$search_result[] = $ap;
}

echo json_encode($search_result);
