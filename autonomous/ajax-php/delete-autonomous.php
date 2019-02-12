<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$autonomous_id = $_POST['id'];

$sql = "DELETE FROM autonomous WHERE id='$autonomous_id'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}

?>