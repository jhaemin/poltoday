<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';
session_write_close();

$search_name = $_POST['ap_name_search'];

$today_date = date("Y-m-d");

$sql = "SELECT * FROM ap_info WHERE name LIKE '%{$search_name}%' AND '$today_date' < discharge_at AND moved_out=0 ORDER BY level, platoon, name";
$result = mysqli_query($conn, $sql);

// $search_result = array(
// 	array(
// 		'index' => '',
// 		'name' => ''
// 	),
// );

$search_result = array();

while ($row = mysqli_fetch_assoc($result)) {
	$ap = array(
		'id' => $row['id'],
		'name' => $row['name'],
		'platoon' => $row['platoon'],
		'level' => $row['level']
	);
	$search_result[] = $ap;
}

echo json_encode($search_result);
?>
