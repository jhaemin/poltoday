<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$sql = "SELECT * FROM moving_game_score ORDER BY score DESC LIMIT 10";

$result = mysqli_query($conn, $sql);

$board = [];

while ($score = mysqli_fetch_assoc($result)) {
	$board[] = $score;
}

echo json_encode($board);