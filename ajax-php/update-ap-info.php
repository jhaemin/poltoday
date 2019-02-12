<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$ap_id = $_POST['ap_id'];
$column_name = $_POST['column_name'];
$new_data = $_POST['new_data'];

$sql = "UPDATE ap_info SET ".$column_name."='$new_data' WHERE id='$ap_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}
