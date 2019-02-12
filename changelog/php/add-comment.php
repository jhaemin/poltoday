<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$name    = $_POST['name'];
$comment = $_POST['comment'];
$commented_at = $today = date('Y-m-d H:i:s');

$sql = "INSERT INTO changelog_comments (`name`, comment, commented_at) VALUES ('$name', '$comment', '$commented_at')";

$result = mysqli_query($conn, $sql);

$insert_id = mysqli_insert_id($conn);

if (!$result) {
	die(mysqli_error($conn));
}

echo $insert_id;