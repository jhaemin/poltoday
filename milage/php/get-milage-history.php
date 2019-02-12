<?php
 
include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
 
$sql = "SELECT * FROM single_text_data WHERE id = 'milage_history'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
}
 
$result = mysqli_fetch_assoc($result);

echo $result['content'];
 