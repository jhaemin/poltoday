<?php
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$row_count = count($_POST['agent_id']);

if ($row_count == 0) {
    die();
}

for ($i = 0; $i < $row_count; $i += 1) {

    $agent_id = mysqli_real_escape_string($conn, $_POST['agent_id'][$i]);
    $event_type = mysqli_real_escape_string($conn, $_POST['event_type'][$i]);
	$event_at = mysqli_real_escape_string($conn, $_POST['event_at'][$i]);
	$etc_event_name = mysqli_real_escape_string($conn, $_POST['etc_event_name'][$i]);

    // Check the duplication
    $sql = "SELECT * FROM agent_event WHERE agent_id='$agent_id' AND event_at='$event_at'";
    $result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }

    if (mysqli_num_rows($result) > 0) {
        echo '이미 그 날 이벤트가 존재합니다.';
        continue;
    }

    $sql = "INSERT INTO agent_event (agent_id, event_type, event_at, etc_event_name) VALUES ('$agent_id', '$event_type', '$event_at', '$etc_event_name')";
    $result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }
}
