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

$today_time = strtotime($today);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>음주운전 의무위반 예방 체크리스트</title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
		<link rel="stylesheet" href="css/alcohol.css?v=1.000" />
    </head>
    <body class="page-body">
        <?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
		
        <main id="alcohol-main">
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
			<section class="section-to-print">
				<div class="page-a4">
					<div class="page-contents">
						<h1 class="typography-header main-title">35중대 음주운전 등 의무위반 예방 체크리스트</h1>
						<p class="date">작성일시 : <?php echo date('Y. m. d', $today_time).' ('.echo_day_kr($today).')'; ?></p>
						<table class="real-table">
							<thead>
								<tr style="background-color:#f8f8f8">
									<td rowspan="2">계급</td>
									<td rowspan="2">성명</td>
									<td colspan="2">자가용 이용실태</td>
									<td rowspan="2">전일음주여부</td>
									<td rowspan="2">교양일시 및 장소</td>
									<td rowspan="2">비고</td>
								</tr>
								<tr style="background-color:#f8f8f8">
									<td>출근</td>
									<td>퇴근</td>
								</tr>
							</thead>
							<tbody>
								<?php
								$list = get_agent_working_info($today, "platoon");
								$start_time = "08:00";
								foreach ($list as $key => $agent) {
									if ($agent['working_group'] == 8) {
										if ($agent['sub_working_type'] == 3) {

										} else {
											continue;
										}
									}
									if ($agent['sub_working_type'] == 1 || $agent['sub_working_type'] == 2) {
										continue;
									}
									if ($agent['sub_working_type'] == 9) {
										continue;
									}
								?>
								<tr>
									<td><?php echo $agent['step']; ?></td>
									<td><?php echo $agent['name']; ?></td>
									<td></td>
									<td></td>
									<td></td>
									<td contenteditable="true"><?php echo $start_time; $start_time = "″"; ?></td>
									<td></td>
								</tr>
								<?php
								}
								?>
							</tbody>
						</table>

						<h1 class="typography-header contents-title">교양 내용</h1>
						<div class="contents-box">
							<p>◯ 음주운전 근절 및 음주관련 112운동</p>
							<p>◯ 3권리운동, 음주습관 10계명 지키기</p>
							<p>◯ 음주 후 성범죄 등 금지</p>
							<p>◯ 과도한 음주 후 익일 운전 금지</p>
							<p>◯ 대원들 영외활동 중 의무위반 예방활동 당부</p>
							<p style="text-align:center;margin-top:20px;">교양관 :
							<?php
							$dang_agent = get_today_d_s($today);
							echo $dang_agent['call']." ".$dang_agent['step']." ".$dang_agent['name'];
							?>
							&nbsp;&nbsp;&nbsp;&nbsp;작성자 : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (인)</p>
						</div>
					</div>
				</div>
			</section>



        </main>
    </body>
</html>
