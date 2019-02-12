<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');
$platoon = 1;

if (isset($_SESSION['jb_mode']) && $_SESSION['jb_mode']) {
	$hour = date('G');
	if ($hour >= 5) {
		$today = date('Y-m-d', strtotime($today.'+ 1 days'));
	}
}

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

if (isset($_GET['platoon'])) {
	$platoon = $_GET['platoon'];
}

$vacation_num = 0;
$out_sleep_num = 0;
$patient_etc_num = 0;
$patient_etc_am_num = 0;
$patient_etc_pm_num = 0;
$autonomous_govern_num = 0;

$hospital_am_num = 0;
$hospital_pm_num = 0;

?>

<!DOCTYPE html>
<html>
<head>
	<title>소대 인원 점검부</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/new-member-report.css" />
</head>
<body class="page-body">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="main">
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
		<div class="platoon-change">
			<form class="platoon-change-button-wrapper<?php if ($platoon == 1) { echo ' selected'; } ?>" action="" method="get" accept-charset="utf-8">
				<button type="submit">1소대</button type="submit">
				<input type="hidden" name="platoon" value="1" />
				<input type="hidden" name="date" value="<?php echo $today; ?>" />
			</form>
			<form class="platoon-change-button-wrapper<?php if ($platoon == 2) { echo ' selected'; } ?>" action="" method="get" accept-charset="utf-8">
				<button type="submit">2소대</button type="submit">
				<input type="hidden" name="platoon" value="2" />
				<input type="hidden" name="date" value="<?php echo $today; ?>" />
			</form>
			<form class="platoon-change-button-wrapper<?php if ($platoon == 3) { echo ' selected'; } ?>" action="" method="get" accept-charset="utf-8">
				<button type="submit">3소대</button type="submit">
				<input type="hidden" name="platoon" value="3" />
				<input type="hidden" name="date" value="<?php echo $today; ?>" />
			</form>
		</div>
		<section class="section-to-print">

			<div class="page-a4-landscape">
				<div class="page-contents page-adjustable">

					<div class="platoon-and-date">
						<?php echo $platoon.'소대 '.$today." (".$day_name_kr[date('w', strtotime($today))].")"; ?>
					</div>
					<div class="whole-table">

						<table class="members-table">
							<thead>
								<tr>
									<th>연번</th>
									<th>기수</th>
									<th>이름</th>
									<th>사고내용</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$members = get_currently_serving_member($platoon, $today);
								for ($i = 0; $i < count($members); $i++) {
								?>
								<tr>
									<td><?php echo $i + 1; ?></td>
									<td><?php echo $members[$i]['level']; ?></td>
									<td><?php echo $members[$i]['name']; ?></td>
									<td contenteditable="true">
									<?php
									$ap_id = $members[$i]['id'];

									$content = "";
									$is_govern = false;
									$is_driver = false;

									$leap = false;

									// Check if this AP is govern
									if ($members[$i]['roll'] == 2) {
										$content = '행정지원';
										$is_govern = true;
										$autonomous_govern_num++;
									} else if ($members[$i]['roll'] == 3) {
										$content = '항해사';
										$hospital_pm_num++;
									}

									// Check autonomous
									$sql = "SELECT * FROM autonomous WHERE work_at='$today' AND ap_id='$ap_id'";
									$result = mysqli_query($conn, $sql);
									if (!$result) { echo mysqli_error($conn); }
									if (mysqli_num_rows($result) > 0) {
										$content = '무기고 / 식기';
										$autonomous_govern_num++;
									}

									// Check if there is an event for this AP
									$sql = "SELECT * FROM ap_outside_activity WHERE ap_id='$ap_id' AND out_at <= '$today' AND in_at >= '$today'";
									$result = mysqli_query($conn, $sql);
									if (!$result) { echo mysqli_error($conn); }

									if (mysqli_num_rows($result) > 0) {
										$event = mysqli_fetch_assoc($result);
										$out_at_formatted = date('m. d',strtotime($event['out_at']));
										$in_at_formatted = date('m. d',strtotime($event['in_at']));

										$content = $event['display_name'];
										if ($event['type'] == 1 || $event['type'] == 2 || $event['type'] == 3 || $event['type'] == 5 || $event['type'] == 8) {

											$content = $content . ' ('.$out_at_formatted.' - '.$in_at_formatted.')';

											if ($is_govern) {
												$autonomous_govern_num--;
											} else if ($is_driver) {
												$hospital_pm_num--;
											}
										} else if ($event['type'] == 9) {
											// 환자
											$content = '환자';
											$patient_etc_num++;
											$patient_etc_am_num++;
											$patient_etc_pm_num++;
										} else if ($event['type'] == 4) {
											// 특별외출
											$content = '특별외출 ('.$event['display_name'].')'.' ('.$event['out_time'].' - '.$event['in_time'].')';
											
											if ($event['out_time'] >= "12:00") {
												$patient_etc_pm_num++;
											} else {
												$patient_etc_am_num++;
											}
										} else if ($event['type'] == 11) {
											// 병원외출
											$content = '병원외출 ' . '(' . $event['out_time'] . ' - ' . $event['in_time'] . ')';
											if ($event['out_time'] >= "12:00") {
												$hospital_pm_num++;
											} else {
												$hospital_am_num++;
											}
										} else if ($event['type'] == 6) {
											// 병가
											$patient_etc_num++;
										}

										// Add total number
										if ($event['type'] == 1 || $event['type'] == 5) {
											// 휴가 청원휴가
											$vacation_num++;
										} else if ($event['type'] == 2 || $event['type'] == 3) {
											// 정기외박, 특별외박
											// 명수 추가
											$out_sleep_num++;
										} else if ($event['type'] == 10) {
											// 기타 잔류
											$patient_etc_num++;
										} else if ($event['type'] == 8) {
											// 교육
											$patient_etc_num++;
										}
									}

									// Echo content
									echo $content;

									?>
									</td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>
						<div class="right-side-table-container">
							<table class="total-table">
								<tbody>
									<tr class="total-row">
										<td colspan="9">총원</td>
										<td><?php echo count($members); ?></td>
									</tr>
									<tr>
										<td>휴가</td>
										<td><?php echo $vacation_num; ?></td>
										<td>외박</td>
										<td><?php echo $out_sleep_num; ?></td>
										<td>환자 및 기타</td>
										<td><?php echo $patient_etc_num; ?></td>
										<td>자경,행정</td>
										<td><?php echo $autonomous_govern_num; ?></td>
										<td>사고자합계</td>
										<td><?php echo $absent_total = $vacation_num + $out_sleep_num + $patient_etc_num + $autonomous_govern_num; ?></td>
									</tr>
									<tr class="total-go-row">
										<td colspan="9">총 출동 인원</td>
										<td><?php echo count($members) - $absent_total; ?></td>
									</tr>
									<tr>
										<td colspan="9">실 근무 인원</td>
										<td><?php echo count($members) - $absent_total - 2; ?></td>
									</tr>
								</tbody>
							</table>
							<table class="training-table">
							<table class="total-table">
								<tbody>
									<tr class="am-training-row">
										<td colspan="10">오전 훈련 인원</td>
										<td><?php echo count($members) - $vacation_num - $out_sleep_num - $patient_etc_num - $autonomous_govern_num - $hospital_am_num; ?></td>
									</tr>
									<tr>
										<td>휴가</td>
										<td><?php echo $vacation_num; ?></td>
										<td>외박</td>
										<td><?php echo $out_sleep_num; ?></td>
										<td>환자 및 기타</td>
										<td><?php echo $patient_etc_am_num; ?></td>
										<td>자경,행정</td>
										<td><?php echo $autonomous_govern_num; ?></td>
										<td>병원외출, 항해사</td>
										<td><?php echo $hospital_am_num; ?></td>
										<td></td>
									</tr>
									<tr class="pm-training-row">
										<td colspan="10">오후 훈련 인원</td>
										<td><?php echo count($members) - $vacation_num - $out_sleep_num - $patient_etc_num - $autonomous_govern_num - $hospital_pm_num; ?></td>
									</tr>
									<tr>
										<td>휴가</td>
										<td><?php echo $vacation_num; ?></td>
										<td>외박</td>
										<td><?php echo $out_sleep_num; ?></td>
										<td>환자 및 기타</td>
										<td><?php echo $patient_etc_pm_num; ?></td>
										<td>자경,행정</td>
										<td><?php echo $autonomous_govern_num; ?></td>
										<td>병원외출, 항해사</td>
										<td><?php echo $hospital_pm_num; ?></td>
										<td></td>
									</tr>
								</tbody>
							</table>
						</table>
						</div>

					</div>
				</div>
			</div>

		</section>

	</main>
	<?php include_once $_SERVER['DOCUMENT_ROOT'].'/modules/page-size-controller/ui.php'; ?>
</body>
</html>
