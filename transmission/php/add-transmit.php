<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$from = $_POST['from'];
$to = $_POST['to'];
$original_content = $_POST['content'];
$content = mysqli_real_escape_string($conn, $original_content);
$type = $_POST['type'];

$return = [
	"err" => false,
	"err_msg" => "",
	"result" => []
];

if ($type == 1 || $type == 3) {

	// 기본 또는 공유 모드

	// 인수인계 만들기
	$sql = "INSERT INTO transmit_item (`from`, content, is_alert) VALUES ('$from', '$content', 0)";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		$return["err"] = true;
		$return['err_msg'] = mysqli_error($conn);
		json_encode($return);
		die();
	}

	$transmit_item_id = mysqli_insert_id($conn);

	// 인수인계에 연결시키기
	// 공유 모드인 경우는 하나의 인수인계 항목에 여러개를 연결
	foreach ($to as $key => $ap_id) {

		$sql = "INSERT INTO ap_transmission (ap_id, transmit_item_id) VALUES ('$ap_id', '$transmit_item_id')";

		$result = mysqli_query($conn, $sql);

		if (!$result) {

			$return["err"] = true;
			$return['err_msg'] = mysqli_error($conn);

		} else {

			$shared = false;
			if (sizeof($to) > 1) {
				$shared = true;
			}

			$return['result'][] = [
				'ap_id' => $ap_id,
				'from' => $from,
				'content' => $original_content,
				'transmit_at' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transmit_item WHERE id='$transmit_item_id'"))['transmit_at'],
				'transmit_item_id' => $transmit_item_id,
				'done_at' => false,
				'shared' => $shared
			];



		}

	}


} else if ($type == 2) {
	// 공지 모드

	foreach ($to as $key => $ap_id) {

		// 인수인계 만들기
		$sql = "INSERT INTO transmit_item (`from`, content, is_alert) VALUES ('$from', '$content', 1)";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			$return["err"] = true;
			$return['err_msg'] = mysqli_error($conn);
			json_encode($return);
			die();
		}

		$transmit_item_id = mysqli_insert_id($conn);

		// 인수인계에 연결시키기
		$sql = "INSERT INTO ap_transmission (ap_id, transmit_item_id) VALUES ('$ap_id', '$transmit_item_id')";

		$result = mysqli_query($conn, $sql);

		if (!$result) {

			$return["err"] = true;
			$return['err_msg'] = mysqli_error($conn);

		} else {

			$return['result'][] = [
				'ap_id' => $ap_id,
				'from' => $from,
				'content' => $original_content,
				'transmit_at' => mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transmit_item WHERE id='$transmit_item_id'"))['transmit_at'],
				'transmit_item_id' => $transmit_item_id,
				'done_at' => false,
				'shared' => false,
				'is_alert' => true
			];

		}


	}

}


echo json_encode($return);