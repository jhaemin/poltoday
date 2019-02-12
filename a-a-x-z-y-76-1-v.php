<?php

session_start();

$_SESSION['govern_verified'] = false;

echo '인증 해제됨';

echo '<br><a href="/">폴투데이로 이동</a>';