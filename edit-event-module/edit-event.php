<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$event_id = $_POST['event_id'];
$out_at = $_POST['out_at'];
$in_at = $_POST['in_at'];
$type = $_POST['type'];
$display_name = $_POST['display_name'];
$note = $_POST['note'];

$out_time = $_POST['out_time'];
$in_time = $_POST['in_time'];

$sql = "UPDATE ap_outside_activity SET out_at='$out_at', in_at='$in_at', type='$type', display_name='$display_name', out_time='$out_time', in_time='$in_time', note='$note' WHERE id='$event_id'";
$result = mysqli_query($conn, $sql);
if (!$result) { echo mysqli_error($conn); }

?>
