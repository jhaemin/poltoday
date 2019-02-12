<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$event_id = $_POST['event_id'];

$sql = "DELETE FROM agent_event WHERE id='$event_id'";

$result = mysqli_query($conn, $sql);
if (!$result) {
    echo mysqli_error($conn);
}

?>
