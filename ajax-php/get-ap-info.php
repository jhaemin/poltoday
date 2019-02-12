<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$ap_id = $_POST['apID'];

$ap = get_ap_info($ap_id);

echo json_encode($ap);

?>