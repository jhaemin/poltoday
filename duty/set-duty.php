<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$duty_at = $_POST['duty_at'];
$duty = $_POST['duty'];
$platoon = $_POST['platoon'];

$sql = "SELECT * FROM duty_stack WHERE duty='$duty' AND duty_at='$duty_at'";
$result = mysqli_query($conn, $sql);
if (!$result) { echo mysqli_error($conn); }
if (mysqli_num_rows($result) > 0) {
	$id = mysqli_fetch_assoc($result)['id'];
	$sql = "UPDATE duty_stack SET platoon='$platoon' WHERE id='$id'";
} else {
	$sql = "INSERT INTO duty_stack (duty, platoon, duty_at) VALUES ('$duty', '$platoon', '$duty_at')";
}

$result = mysqli_query($conn, $sql);
if (!$result) { echo mysqli_error($conn); }

$sql = "DELETE FROM duty_stack WHERE duty_at > '$duty_at'";
$result = mysqli_query($conn, $sql);
if (!$result) { echo mysqli_error($conn); }

?>