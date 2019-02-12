<?php
 
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
 
$content = $_POST['content'];

$sql = "UPDATE single_text_data SET content = '$content' WHERE id = 'milage_history'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}