<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$sql = "SELECT * FROM changelog_comments ORDER BY id DESC LIMIT 100";

$result = mysqli_query($conn, $sql);

if (!$result) {
	die(mysqli_error($conn));
}

$comments = [];

while ($comment = mysqli_fetch_assoc($result)) {
	$comments[] = $comment;
}

echo json_encode($comments);