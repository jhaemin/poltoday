<?php
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$milage_point = $_POST['milage_point'];
$ap_id = $_POST['ap_id'];

$sql = "UPDATE ap_info SET milage = '$milage_point' WHERE id = '$ap_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}

