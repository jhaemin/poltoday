<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$transmit_item_id = $_POST['transmit_item_id'];

$now = date('Y-m-d H:i:s');

$sql = "UPDATE transmit_item SET done_at='$now' WHERE id='$transmit_item_id'";

$result = mysqli_query($conn, $sql);

echo $now;