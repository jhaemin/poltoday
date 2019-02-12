<?php

session_start();

$valid = 0;

if (isset($_SESSION['valid']) && $_SESSION['valid'] == 1) {
	$valid = 1;
} else {
	$valid = 0;
}

if (isset($_POST['pass']) && ($_POST['pass'] == 'rnldyal' || $_POST['pass'] == 'godth1035')) {
	$valid = 1;
}

echo $valid;
