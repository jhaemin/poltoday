<?php

if (session_status() == PHP_SESSION_NONE) {
	ini_set('session.gc_maxlifetime', 36000);
	session_set_cookie_params(36000);
	session_start();
}

$conn = mysqli_connect("localhost", "root", "", "police");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} else {
	$_SESSION['conn'] = $conn;
	setlocale(LC_ALL, "ko_KR.utf-8");
	mysqli_set_charset($conn, "utf-8");
	date_default_timezone_set('Asia/Seoul');
}

// PDO 라이브러리 도입
// $db = new PDO();
// $db->

?>
