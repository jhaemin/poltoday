<?php

session_start();

$_SESSION['govern_verified'] = true;

echo '인증완료';

echo '<br><a href="/">홈으로 이동합니다</a>';

// header("Location: " . "/");

?>

<script>

	setTimeout(() => {
		window.location.replace("/")
	}, 0);

</script>