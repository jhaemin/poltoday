<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$notice_id = $_POST['noticeID'];

$sql = "DELETE FROM notice WHERE id = $notice_id";
$result = mysqli_query($conn, $sql);
if (!$result) {
	die(mysqli_error($conn));
}