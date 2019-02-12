<?php


include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

switch ($_POST['mode']) {
	case 'add':
		add_outside_activity($_POST['activity_id'], $_POST['data']);
		break;

	case 'remove':
		remove_outside_activity($_POST['activity_id']);
		break;

	case 'update':
		update_outside_activity($_POST['activity_id'], $_POST['data']);
		break;
	
	default:
		# code...
		break;
}

function add_outside_activity($activity_id, $data) {
	
}

function remove_outside_activity($activity_id) {
	global $conn;

	$activity_id = mysqli_real_escape_string($conn, $activity_id);

	$sql = "DELETE FROM ap_outside_activity WHERE id='$activity_id'";
	$result = mysqli_query($conn, $sql);

	if ($result) {
		echo 'success';
	} else {
		echo 'fail';
	}
}

function update_outside_activity($activity_id, $data) {

}



?>