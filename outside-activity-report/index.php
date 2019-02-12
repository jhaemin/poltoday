<?php
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';
$today = date('Y-m-d');
if (isset($_GET['date'])) {
	$today = $_GET['date'];
}
$day_name_kr = array("일", "월", "화", "수", "목", "금", "토");
?>

<!DOCTYPE html>
<html data-today="<?php echo $today; ?>">
<head>
	<title>영외활동보고</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/report.css?v=1.000" />
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="outside-activity-report-main">
		<div class="date-change">
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">< 한 달 전</button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 1 months')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">< 1일 전</button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 1 days')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button">오늘</button>
			</form>
			<?php
			if ($today != date('Y-m-d')) {
			?>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">1일 후 ></button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' + 1 days')); ?>" />
			</form>
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">한 달 후 ></button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' + 1 months')); ?>" />
			</form>
			<?php
			}
			?>
		</div>

		<!-- 옵션박스 -->
		<div class="option-box" style="display:none;">
			<div class="item">전화보고 없음</div>
			<div class="item">귀가 중</div>
			<div class="item">집에서 휴식 중</div>
			<div class="item">식사 중</div>
			<div class="item">친구와 노는 중</div>
			<div class="item">밖에서 노는 중</div>
			<div class="item">피시방에서 게임 중</div>
			<div class="item">카페에서 커피 마시는 중</div>
			<div class="item">영화 보는 중</div>
			<div class="item">데이트 중</div>
		</div>

		<div class="contents section-to-print">
			<div class="page-adjustable">
				<h1 class="typography-header">영외활동보고</h1>
				<p class="today-date"><?php echo $today." (".$day_name_kr[date('w', strtotime($today))].")"; ?></p>
				<table>
					<thead>
						<tr>
							<th>연번</th>
							<th>이름</th>
							<th>연락처</th>
							<th>영외활동 종류</th>
							<th colspan="2">보고내용</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$sql = "SELECT * FROM ap_outside_activity WHERE out_at<='$today' AND in_at>'$today' AND (type=1 OR type=2 OR type=3 OR type=5 OR type=6) ORDER BY out_at ASC";
						$result = mysqli_query($conn, $sql);
						$count = 1;
						if (!$result) echo mysqli_error($conn);

						while ($row = mysqli_fetch_assoc($result)) {
							$ap_id = $row['ap_id'];
							$ap = get_ap_info($ap_id);
							if ($ap['moved_out']) {
								continue;
							}
						?>
						<tr>
							<td rowspan="1" class="counting"><?php echo $count++; ?></td>
							<td rowspan="1" class="name"><?php echo get_ap_info($row['ap_id'])['name']; ?></td>
							<td rowspan="1" class="contact">
								<?php
								echo
									"본인:".preg_replace('/(\d\d\d)(\d\d\d\d?)(\d\d\d\d)/', '$1-$2-$3', $ap['phone_number'])."<br />".
									"부:".preg_replace('/(\d\d\d)(\d\d\d\d?)(\d\d\d\d)/', '$1-$2-$3', $ap['father_pn'])."<br />".
									"모:".preg_replace('/(\d\d\d)(\d\d\d\d?)(\d\d\d\d)/', '$1-$2-$3', $ap['mother_pn'])."<br />";
								?>
							</td>
							<td rowspan="1" class="type"><?php echo get_event_name($row['type']).'<br />'.date('Y.m.d', strtotime($row['out_at'])).' - '.date('Y.m.d', strtotime($row['in_at'])); ?></td>
							<?php
							$sql = "SELECT * FROM outside_report WHERE ap_id='$ap_id' AND report_at='$today' ORDER BY exact_time DESC";
							$result2 = mysqli_query($conn, $sql);
							if (!$result2) echo mysqli_error($conn);

							$report = mysqli_fetch_assoc($result2);
							?>
							<td class="td-report-time time-input"<?php if ($report) echo 'contenteditable="true"'; ?>><?php
							if ($report) {
								echo $report['exact_time'];
							} else {
								// echo '&nbsp;';
							}
							?></td>
							<td class="td-report-contents" contenteditable="true" data-ap-id="<?php echo $ap_id; ?>" data-report-id="<?php echo $report['id']; ?>" data-report-at="<?php echo $today; ?>"><?php
							if ($report) {
								echo $report['report_contents'];
							} else {
								// echo '&nbsp;';
							}
							?></td>
						</tr>
						<!-- <tr>
							<?php $report = mysqli_fetch_assoc($result2); ?>
							<td class="td-report-time time-input"<?php if ($report) echo 'contenteditable="true"'; ?>><?php
							if ($report) {
								echo $report['exact_time'];
							} else {
								// echo '&nbsp;';
							}
							?></td>
							<td class="td-report-contents" contenteditable="true" data-ap-id="<?php echo $ap_id; ?>" data-report-id="<?php echo $report['id']; ?>" data-report-at="<?php echo $today; ?>"><?php
							if ($report) {
								echo $report['report_contents'];
							} else {
								// echo '&nbsp;';
							}
							?></td>
						</tr>
						<tr>
							<?php $report = mysqli_fetch_assoc($result2); ?>
							<td class="td-report-time time-input"<?php if ($report) echo 'contenteditable="true"'; ?>><?php
							if ($report) {
								echo $report['exact_time'];
							} else {
								// echo '&nbsp;';
							}
							?></td>
							<td class="td-report-contents" contenteditable="true" data-ap-id="<?php echo $ap_id; ?>" data-report-id="<?php echo $report['id']; ?>" data-report-at="<?php echo $today; ?>"><?php
							if ($report) {
								echo $report['report_contents'];
							} else {
								// echo '&nbsp;';
							}
							?></td>
						</tr> -->
						<?php
						}
						?>
					</tbody>
				</table>
				<?php
				$agent = get_today_d_s($today);
				?>
				<div class="duty-agent" contenteditable="true">당직관: <?php echo $agent['step']." ".$agent['name']; ?> (인)</div>
			</div>
		</div>

		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/modules/page-size-controller/ui.php'; ?>

	</main>
	<script src="js/report.js?v=1.000"></script>
</body>
</html>
