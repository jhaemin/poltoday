<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$last_id = $_POST['last_id'];

$sql = "SELECT * FROM changelog_comments WHERE id > '$last_id'";

$result = mysqli_query($conn, $sql);

$new_comments = [];

while ($comment = mysqli_fetch_assoc($result)) {
	$new_comments[] = $comment;
}

echo json_encode($new_comments);