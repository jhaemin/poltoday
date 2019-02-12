<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$ap_id = $_POST['ap_id'];

$sql = "SELECT * FROM ap_info WHERE id = '$ap_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}

$result = mysqli_fetch_assoc($result);

$milage_data = [
	"milage" => $result['milage'],
	"milage_go_out" => $result['milage_go_out'],
	"milage_out_sleep" => $result['milage_out_sleep']
];

echo json_encode($milage_data);