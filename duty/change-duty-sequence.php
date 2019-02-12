<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$sequence = $_POST['sequence'];

$sql = "UPDATE duty_settings SET sequence='$sequence'";

$result = mysqli_query($conn, $sql);

if (!$result) {
	echo mysqli_error($conn);
}

?>