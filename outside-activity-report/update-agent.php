<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$agent_id = $_POST['agent_id'];
$agent_at = $_POST['agent_at'];

$sql = "SELECT * FROM outside_report_agent WHERE agent_at='$agent_at'";
$result = mysqli_query($conn, $sql);
if (!$result) echo mysqli_error($conn);

if (mysqli_num_rows($result) > 0) {
	$sql = "UPDATE outside_report_agent SET agent_id='$agent_id'";
} else {
	$sql = "INSERT INTO outside_report_agent (agent_id, agent_at) VALUES ('$agent_id', '$agent_at')";
}
$result = mysqli_query($conn, $sql);
if (!$result) echo mysqli_error($conn);


?>