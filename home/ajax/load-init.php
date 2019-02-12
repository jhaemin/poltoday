<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$limit = $_POST["limit"];

$sql = "SELECT * FROM notice ORDER BY noticed_at DESC LIMIT $limit";
$result = mysqli_query($conn, $sql);
if (!$result) { die(mysqli_error($conn)); }

$notices = [];
while ($n = mysqli_fetch_assoc($result)) {
	$a_notice = $n;
	if ($n["is_agent"] === "1") {
		$a_notice["name"] = get_agent_info_by_id($n["noticer_id"])["call"];
	} else {
		$a_notice["name"] = get_ap_info($n["noticer_id"])["name"];
	}
	
	$notices[] = $a_notice;
}

echo json_encode($notices);