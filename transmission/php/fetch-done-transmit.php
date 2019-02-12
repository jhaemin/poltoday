<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$return = [
	"err" => false,
	"err_msg" => "",
	"result" => []
];

$ap_id = $_POST['ap_id'];
$last_done_date = $_POST['last_done_date'];

// 완료한 작업 10개 더 가져오기
$sql = "SELECT * FROM transmit_item join ap_transmission on transmit_item.id = ap_transmission.transmit_item_id WHERE ap_transmission.ap_id='$ap_id' AND done_at!='' AND transmit_item.done_at < '$last_done_date' ORDER BY done_at DESC LIMIT 10";

$result = mysqli_query($conn, $sql);
if (!$result) {
	$return['err'] = true;
	$return['err_msg'] = mysqli_error($conn);
} else {
	while ($item = mysqli_fetch_assoc($result)) {
		$return['result'][] = $item;
	}
}

echo json_encode($return);