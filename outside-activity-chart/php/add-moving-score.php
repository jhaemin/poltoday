<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';


$name = $_POST['name'];
$score = $_POST['score'];

$sql = "INSERT INTO moving_game_score (`name`, `score`) VALUES ('$name', '$score')";

$result = mysqli_query($conn, $sql);