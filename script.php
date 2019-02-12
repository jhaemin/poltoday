<?php

include 'connect.php';

$sql = "DELETE FROM ap_outside_activity WHERE id='662'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo '성공';
}

?>