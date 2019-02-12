<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$mode = $_POST['mode'];

$id = $_POST['id'];


if ($mode == "new") {
	$sql = "SELECT * FROM notice WHERE id > $id ORDER BY id DESC";
} else if ($mode == "old") {
	$sql = "SELECT * FROM notice WHERE id < $id ORDER BY id DESC LIMIT 10";
}


$result = mysqli_query($conn, $sql);
if (!$result) {
	die(mysqli_error($conn));
}

$arr = [];
while ($n = mysqli_fetch_assoc($result)) {
	$a_notice = $n;
	if ($n["is_agent"] === "1") {
		$a_notice["name"] = get_agent_info_by_id($n["noticer_id"])["call"];
	} else {
		$a_notice["name"] = get_ap_info($n["noticer_id"])["name"];
	}
	$arr[] = $a_notice;
}


echo json_encode($arr);