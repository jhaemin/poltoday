<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
if ($_POST['mode'] == 'set') {
    $_SESSION['jb_mode'] = true;
} else if ($_POST['mode'] == 'unset') {
    unset($_SESSION['jb_mode']);
}

?>
