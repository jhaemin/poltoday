<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if (isset($_SESSION['jb_mode']) && $_SESSION['jb_mode']) {
    echo 'true';
} else {
    echo 'false';
}

?>
