<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$content = $_POST["content"];
$noticer_id = $_POST["noticerID"];
$is_agent = $_POST["isAgent"];
if ($is_agent) {
	$is_agent = 1;
} else {
	$is_agent = 0;
}

// echo $content." ".$noticer_id." ".$is_agent;

$sql = "INSERT INTO notice (content, noticer_id, is_agent)
VALUES ('$content', $noticer_id, $is_agent)";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}