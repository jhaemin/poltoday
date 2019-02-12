<?php
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');
if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

// Get the number of days in this month
$today_time = strtotime($today);

$days_in_month = cal_days_in_month(CAL_GREGORIAN, date('m', $today_time), date('Y', $today_time));
?>

<!DOCTYPE html>
<html data-today="<?php echo $today; ?>" data-year="<?php echo date('Y', $today_time); ?>" data-month="<?php echo date('m', $today_time); ?>" data-days-in-month="<?php echo $days_in_month; ?>">
<head>
	<title>일당비</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/duty.css?v=1.000" />
</head>
<body id="duty-body">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/show-ajax-status-module/show-ajax-status-module.php'; ?>
	<main id="duty-main">
		<div class="date-change">
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">< 이전 달</button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 1 months')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button">오늘</button>
			</form>
			<?php
			if ($today != date('Y-m-d', strtotime(date('Y-m-d') . ' + 1 days'))) {
			?>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">다음 달 ></button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' + 1 months')); ?>" />
			</form>
			<?php
			}
			?>
		</div>
		<?php
		if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
		?>
		<div class="set-this-month-duty">
			<div class="setting-container sequence-setting">
				<h2 class="setting-title">근무 순환 방향</h2>
				<div class="ss-item setting-option" data-seq="1">1팀 → 2팀 → 3팀</div>
				<div class="ss-item setting-option" data-seq="2">3팀 → 2팀 → 1팀</div>
			</div>
			<div class="setting-container dang-before-setting">
				<h2 class="setting-title"><?php echo date('n', $today_time); ?>월 1일 당직 팀 선택</h2>
				<div class="dbs-item setting-option" data-d="1">1팀</div>
				<div class="dbs-item setting-option" data-d="2">2팀</div>
				<div class="dbs-item setting-option" data-d="3">3팀</div>
			</div>
			<div class="setting-container il-st-setting">
				<h2 class="setting-title"><?php echo date('n', $today_time); ?>월 1일 일근 팀 선택</h2>
				<div class="ist-item setting-option" data-i="1">1팀</div>
				<div class="ist-item setting-option" data-i="2">2팀</div>
				<div class="ist-item setting-option" data-i="3">3팀</div>
			</div>
			<button class="set-btn"><?php echo date('n', $today_time); ?>월 당직근무 편성 만들기</button>
		</div>
		<?php
		}
		?>
		<div class="duty-table-wrapper section-to-print">
			<h1 class="table-header">당직근무 편성 (<?php echo date('Y. m', $today_time); ?>)</h1>
			<table class="duty-table">
				<tr>
					<th rowspan="2">날짜</th>
					<th colspan="2">근무시간</th>
					<th rowspan="2">선탑 일근</th>
				</tr>
				<tr>
					<th>전반</th>
					<th>후반</th>
				</tr>
				<?php

				$temp_date = date('Y-m-01', $today_time);

				for ($i = 0; $i < $days_in_month; $i++) {
					$sql = "SELECT * FROM duty_stack WHERE duty_at = '$temp_date'";
					$result = mysqli_query($conn, $sql);
					if (!$result) { echo mysqli_error($conn); }
					$duty = mysqli_fetch_assoc($result);
				?>
				<tr>
					<td><?php echo date('n. j', strtotime($temp_date)).' ('.echo_day_kr($temp_date).')'; ?></td>
					<td><?php echo get_agent_call($duty['dang_before']); ?></td>
					<td><?php echo get_agent_call($duty['dang_after']); ?></td>
					<td><?php echo get_agent_call($duty['il_st']); ?></td>
				</tr>
				<?php
					$temp_date = date('Y-m-d', strtotime($temp_date.'+ 1 days'));
				}
				?>
			</table>
		</div>
	</main>
	<script src="js/duty.js?v=1"></script>
</body>
</html>
