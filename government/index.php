<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';



if (isset($_POST['pw'])) {
	if ($_POST['pw'] == "password") {
		$_SESSION['verified'] = true;
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>행정대원</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/government-main.css" />
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="govern-main">
		<?php
		if (!isset($_SESSION['verified'])) {
		?>
		<div class="login-field">
			<form action="" method="post" accept-charset="utf-8">
				<input type="password" name="pw" />
				<button type="submit">로그인</button>
			</form>
		</div>
		<?php
		} else {
		?>



		<?php
		}
		?>
	</main>
</body>
</html>
