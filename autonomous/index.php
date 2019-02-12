<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';


$today = date('Y-m-d');

if (isset($_SESSION['jb_mode']) && $_SESSION['jb_mode']) {
	$hour = date('G');
	if ($hour >= 5) {
		$today = date('Y-m-d', strtotime($today . '+ 1 days'));
	}
}

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

$tomorrow = date('Y-m-d', strtotime($today . ' + 1 days'));



// echo $today;
$today_autonomous = get_today_autonomous($today);
$platoon_1_name = get_ap_info($today_autonomous[0]['ap_id'])['name'];
$platoon_2_name = get_ap_info($today_autonomous[1]['ap_id'])['name'];
$platoon_3_name = get_ap_info($today_autonomous[2]['ap_id'])['name'];

$platoon_1_data = json_encode($today_autonomous[0]);
$platoon_2_data = json_encode($today_autonomous[1]);
$platoon_3_data = json_encode($today_autonomous[2]);

// Fetch tomorrow's autonomous
$tomorrow_autonomous = get_today_autonomous($tomorrow);
$platoon_1_name_tmr = get_ap_info($tomorrow_autonomous[0]['ap_id'])['name'];
$platoon_2_name_tmr = get_ap_info($tomorrow_autonomous[1]['ap_id'])['name'];
$platoon_3_name_tmr = get_ap_info($tomorrow_autonomous[2]['ap_id'])['name'];

$platoon_1_data_tmr = json_encode($tomorrow_autonomous[0]);
$platoon_2_data_tmr = json_encode($tomorrow_autonomous[1]);
$platoon_3_data_tmr = json_encode($tomorrow_autonomous[2]);

?>

<!DOCTYPE html>
<html data-date="<?php echo $today; ?>">
<head>
	<title>무기고/식기</title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/autonomous.css?v=1.001" />
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/search-ap-module/search-ap-ui.html'; ?>
	
	<main id="autonomous-main">

		<div class="date-change">
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">< 한 달 전</button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' - 1 months')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">< 7일 전</button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' - 7 days')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">< 1일 전</button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' - 1 days')); ?>" />
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
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' + 1 months')); ?>" />
			</form>
			<div class="locate-by-date">
				<form action="" method="get" accept-charset="utf-8">
					<input class="date-input" type="text" name="date" placeholder="날짜로 바로 이동" />
				</form>
			</div>
		</div>

		<h1 class="typography-header autonomous-header"><?php echo $today; ?> 무기고/식기</h1>
		<div class="autonomous-container">
			<?php

			$sql = "SELECT autonomous.id, autonomous.ap_id, autonomous.work_at, ap_info.name, ap_info.platoon
					FROM autonomous
					INNER JOIN ap_info
					ON autonomous.ap_id=ap_info.id
					WHERE work_at = '$today'
					ORDER BY ap_info.platoon ASC";

			$result = mysqli_query($conn, $sql);
			if (!$result) {
				print mysqli_error($conn);
			}
			while ($row = mysqli_fetch_assoc($result)) {
			?>
			<div class="autonomous-item" data-autonomous='<?php echo json_encode($row); ?>'>
				<div class="name"><?php echo $row['name']; ?></div>
				<div class="platoon"><?php echo get_platoon_name($row['platoon']); ?></div>
				<div class="delete-cl"></div>
				<div class="delete-cr"></div>
			</div>
			<?php
			}
			?>
			<div class="new-autonomous autonomous-item">
				<div class="cross-x"></div>
				<div class="cross-y"></div>
			</div>
		</div>
	</main>
	<script src="js/autonomous.js?v=1.0"></script>
</body>
</html>