<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$sc = $_POST['sc'];

$sql = "UPDATE schedule SET data = '$sc' WHERE id = 1";
$result = mysqli_query($conn, $sql);