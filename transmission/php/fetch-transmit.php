<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$return = [
	"err" => false,
	"err_msg" => "",
	"result" => []
];

$ap_id           = $_POST['ap_id'];
$last_fetched_id = $_POST['last_fetched_id'];
$count           = $_POST['count'];

$sql = "(SELECT * FROM transmit_item join ap_transmission on transmit_item.id = ap_transmission.transmit_item_id WHERE ap_transmission.ap_id='$ap_id' AND transmit_item.id > '$last_fetched_id' AND done_at='' ORDER BY transmit_item.id DESC LIMIT 1000) UNION (SELECT * FROM transmit_item join ap_transmission on transmit_item.id = ap_transmission.transmit_item_id WHERE ap_transmission.ap_id='$ap_id' AND done_at!='' ORDER BY done_at DESC LIMIT 10)";

$result = mysqli_query($conn, $sql);
if (!$result) {
	$return["err"] = true;
	$return["err_msg"] = mysqli_error($conn);
} else {
	while ($item = mysqli_fetch_assoc($result)) {
		$transmit_item_id = $item['transmit_item_id'];
		$sql = "SELECT * FROM ap_transmission WHERE transmit_item_id = $transmit_item_id";
		$result2 = mysqli_query($conn, $sql);
		$item['shared'] = false;
		if (mysqli_num_rows($result2) > 1) {
			$item['shared'] = true;
		}
		$return["result"][] = $item;
	}
}

echo json_encode($return);