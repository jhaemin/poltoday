<?php
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');

if (isset($_SESSION['jb_mode']) && $_SESSION['jb_mode']) {
	$hour = date('G');
	if ($hour >= 5) {
		$today = date('Y-m-d', strtotime($today.'+ 1 days'));
	}
}

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}
?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>외출 현황</title>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
		<link rel="stylesheet" href="css/leave-day.css" />
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
		<main id="leave-day-main">
			<div class="date-change">
				<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
					<button class="date-change-button" type="submit">< 한 달 전</button>
					<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 1 months')); ?>" />
				</form>
				<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
					<button class="date-change-button" type="submit">< 7일 전</button>
					<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 7 days')); ?>" />
				</form>
				<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
					<button class="date-change-button" type="submit">< 1일 전</button>
					<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 1 days')); ?>" />
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
			<div class="section-to-print">
				<h1 class="typography-header" style="text-align:center;">금일 외출 현황</h1>
				<h2 class="today-date" style="text-align:right;margin-bottom:10px;font-size:18px;"><?php echo $today; ?></h2>
					<table>
						<tr>
							<th>연번</th>
							<th>이름</th>
							<th>사유</th>
							<th>시간</th>
							<th>병원</th>
						</tr>

						<?php
						$sql = "SELECT * FROM ap_outside_activity WHERE (type = 4 OR type = 11) AND out_at = '$today' ORDER BY out_time ASC, in_time ASC";
						$result = mysqli_query($conn, $sql);
						if (!$result) { echo mysqli_error($result); }

						$index = 1;

						// color list
						$color = ['red', 'green', 'blue', 'orange', 'black', 'skyblue'];

						$current_color_index = 0;
						$max_color_index = 6;

						while ($leave_item = mysqli_fetch_assoc($result)) {
							$ap = get_ap_info($leave_item['ap_id'], $today);
						?>
						<tr class="leave-item" data-leave-id="<?php echo $leave_item['id']; ?>">
							<td><?php echo $index++; ?></td>
							<td><?php echo $ap['name']; ?></td>
							<td><?php echo $leave_item['display_name']; ?></td>
							<td><?php echo $leave_item['out_time'].' - '.$leave_item['in_time']; ?></td>
							<td><?php echo $leave_item['note']; ?></td>
						</tr>
						<?php
						}
						?>
					</table>
			</div>
		</main>
	</body>
</html>
