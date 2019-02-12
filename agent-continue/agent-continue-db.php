<?php

include '../connect.php';

// 당직관 인수인계 db 저장, 삭제, 업데이트

$contents_object = $_POST['contents'];
$contents = json_encode($contents_object, JSON_UNESCAPED_UNICODE);
$handed_at = $_POST['handed_at'];

update_contents($contents, $handed_at);

function update_contents($contents, $handed_at) {

	global $conn, $contents_object;

	$sql = "SELECT * FROM agent_continue WHERE handed_at = '$handed_at'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		echo mysqli_error($conn);
	}

	if (mysqli_num_rows($result) > 0) {
		// 이미 있으면 업데이트
		$sql = "UPDATE agent_continue SET contents = '$contents' WHERE handed_at = '$handed_at'";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			echo mysqli_error($conn);
		}
	} else {
		// 없으면 추가
		$sql = "INSERT INTO agent_continue (contents, handed_at) VALUES ('$contents', '$handed_at')";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			echo mysqli_error($conn);
		}
	}

	if ($contents_object['lightout'] == "" && $contents_object['hand'] == "" &&
		$contents_object['patient'] == "" && $contents_object['catch'] == "") {
		// 빈 데이터면 삭제
		$sql = "DELETE FROM agent_continue WHERE handed_at = '$handed_at'";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			echo mysqli_error($conn);
		}
	}
}


?>
