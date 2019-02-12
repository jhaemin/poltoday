<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';

$sql = "SELECT data FROM schedule WHERE id = 1";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result)['data'];

$today = date('Y-m-d');
if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

// if (isset($_SESSION['jb_mode']) && $_SESSION['jb_mode']) {
// 	$hour = date('G');
// 	if ($hour >= 5) {
// 		$today = date('Y-m-d', strtotime($today . '+ 1 days'));
// 	}
// }

$sql = "SELECT * FROM tddj WHERE dj_at='$today'";
$result = mysqli_query($conn, $sql);
$first = "";
$second = "";

$exists = false;

if (mysqli_num_rows($result) > 0) {
	$exists = true;
	$dj = mysqli_fetch_assoc($result);
	$first = $dj['first'];
	$second = $dj['second'];
}


?>

<!DOCTYPE html>
<html date="<?php echo $today; ?>">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Summary</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html';?>
	<link rel="stylesheet" href="summary-set.css">
</head>

<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main style="margin-bottom:0;">

		<div class="date-change">
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">
					< 한 달 전</button> <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 1 months')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">
					< 7일 전</button> <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 7 days')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">
					< 1일 전</button> <input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 1 days')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button">오늘</button>
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">1일 후 ></button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' + 1 days')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">7일 후 ></button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' + 7 days')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">한 달 후 ></button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' + 1 months')); ?>" />
			</form>
			<div class="locate-by-date">
				<form action="" method="get" accept-charset="utf-8">
					<input class="date-input" type="text" name="date" placeholder="날짜로 바로 이동" />
				</form>
			</div>
		</div>

		<div class="main-box">

			<div class="schedule box">
				<h1>주요일정</h1>
				<textarea class="ta" name="" id="" cols="30" rows="10"><?php echo $data; ?></textarea>
			</div>

			<div class="tddj box">
				<h1><?php echo $today; ?></h1>
				<h1>3단 당직근무</h1>
				<div>
					<input class="tddj-input first" type="text" name="first" placeholder="첫번째" value="<?php echo $first; ?>">
					<input class="tddj-input second" type="text" name="second" placeholder="두번째" value="<?php echo $second; ?>">
					<button class="save">저장</button>
				</div>
			</div>

		</div>



	</main>

	<script src="schedule.js"></script>
	<script src="tddj.js"></script>
</body>

</html>