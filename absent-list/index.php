<?php
include_once "absent-combo.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>사고자리스트</title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/absent-list.css?v=1.002"/>
</head>
<body class="page-body">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main>
		<div class="ap-info-bubble">
			<div class="level section">
				<div class="title">기수</div>
				<div class="contents"></div>
			</div>
			<div class="military-num section">
				<div class="title">군번</div>
				<div class="contents"></div>
			</div>
			<div class="phone-num section">
				<div class="title">휴대폰 번호</div>
				<div class="contents"></div>
			</div>
			<div class="dad-phone-num section">
				<div class="title">아버지 휴대폰 번호</div>
				<div class="contents"></div>
			</div>
			<div class="mom-phone-num section">
				<div class="title">어머니 휴대폰 번호</div>
				<div class="contents"></div>
			</div>
			<!-- <div class="birthday section">
				<div class="title">생일</div>
				<div class="contents"></div>
			</div> -->
			
		</div>
		<div id="absent-list-main">
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
			<div class="whole-contents">
				<section class="section-to-print absent-list-page">
					<div class="absent-list-wrapper page-a4 page">
						<div class="page-contents page-adjustable">
							<h1 class="typography-header absent-list-header">사고자리스트</h1>
							<p class="today-date"><?php echo $today." (".echo_day_kr($today).")"; ?></p>
							<table class="ap-table">
							<thead>
								<tr class="input-kind-container input-row input-kind-row row-0">
									<th class="col kind-col kind-col-0 kind-col-division">
										<span class="kind-display">구 분</span>
									</th>
									<th class="col kind-col kind-col-platoon-0">
										<span class="kind-display">HQ (<?php echo count(get_currently_serving_member(0, $today)); ?>)</span>
									</th>
									<th class="col kind-col kind-col-platoon-1">
										<span class="kind-display">1소대 (<?php echo count(get_currently_serving_member(1, $today)); ?>)</span>
									</th>
									<th class="col kind-col kind-col-platoon-2">
										<span class="kind-display">2소대 (<?php echo count(get_currently_serving_member(2, $today)); ?>)</span>
									</th>
									<th class="col kind-col kind-col-platoon-2">
										<span class="kind-display">3소대 (<?php echo count(get_currently_serving_member(3, $today)); ?>)</span>
									</th>
								</tr>
							</thead>

							<tbody class="input-data-table">

								<!-- 휴가 -->
								<tr class="input-data-container input-row input-data-row">
									<th class="col item-col item-col-0 item-col-division">
										<span>휴가<br>(<?php echo sizeof($platoon_0_absent['vacation']) + sizeof($platoon_1_absent['vacation']) + sizeof($platoon_2_absent['vacation']) + sizeof($platoon_3_absent['vacation']); ?>)</span>
									</th>
									<td class="col item-col item-col-platoon-0">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_0_absent['vacation']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-1">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_1_absent['vacation']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-2">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_2_absent['vacation']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-3">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_3_absent['vacation']);
											?>
										</div>
									</td>
								</tr>

								<!-- 외박 -->
								<tr class="input-data-container input-row input-data-row">
									<th class="col item-col item-col-0 item-col-division">
										<span>정기외박<br>(<?php echo sizeof($platoon_0_absent['out_sleep']) + sizeof($platoon_1_absent['out_sleep']) + sizeof($platoon_2_absent['out_sleep']) + sizeof($platoon_3_absent['out_sleep']); ?>)</span>
									</th>
									<td class="col item-col item-col-platoon-0">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_0_absent['out_sleep']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-1">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_1_absent['out_sleep']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-2">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_2_absent['out_sleep']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-3">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_3_absent['out_sleep']);
											?>
										</div>
									</td>
								</tr>

								<!-- 특별외박 -->
								<tr class="input-data-container input-row input-data-row">
									<th class="col item-col item-col-0 item-col-division">
										<span>특별외박<br>(<?php echo sizeof($platoon_0_absent['special_out_sleep']) + sizeof($platoon_1_absent['special_out_sleep']) + sizeof($platoon_2_absent['special_out_sleep']) + sizeof($platoon_3_absent['special_out_sleep']); ?>)</span>
									</th>
									<td class="col item-col item-col-platoon-0">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_0_absent['special_out_sleep']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-1">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_1_absent['special_out_sleep']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-2">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_2_absent['special_out_sleep']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-3">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_3_absent['special_out_sleep']);
											?>
										</div>
									</td>
								</tr>

								<!-- 병가 -->
								<tr class="input-data-container input-row input-data-row">
									<th class="col item-col item-col-0 item-col-division">
										<span>병가 및 공가</span>
									</th>
									<td class="col item-col item-col-platoon-0">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_0_absent['sick']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-1">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_1_absent['sick']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-2">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_2_absent['sick']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-3">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_3_absent['sick']);
											?>
										</div>
									</td>
								</tr>

								<!-- 기타 -->
								<tr class="input-data-container input-row input-data-row">
									<th class="col item-col item-col-0 item-col-division">
										<span>기타<br />(교육 및 보근)</span>
									</th>
									<td class="col item-col item-col-platoon-0">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_0_absent['etc']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-1">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_1_absent['etc']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-2">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_2_absent['etc']);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-3">
										<div class="absent-list-container">
											<?php
											echo_absent_item($platoon_3_absent['etc']);
											?>
										</div>
									</td>
								</tr>

								<!-- 자경/식기 -->
								<tr class="input-data-container input-row input-data-row">
									<th class="col item-col item-col-0 item-col-division">
										<span>무기고/식기</span>
									</th>
									<td class="col item-col item-col-platoon-0">
										<div class="absent-list-container">

										</div>
									</td>
									<td class="col item-col item-col-platoon-1">
										<div class="absent-list-container">
											<?php
											if ($autonomous[0]) {
												echo '<div>'.get_ap_info($autonomous[0]['ap_id'])['name'].'<br />(무기고/식기)</div>';
											}
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-2">
										<div class="absent-list-container">
											<?php
											if ($autonomous[1]) {
												echo '<div>'.get_ap_info($autonomous[1]['ap_id'])['name'].'<br />(무기고/식기)</div>';
											}
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-3">
										<div class="absent-list-container">
											<?php
											if ($autonomous[2]) {
												echo '<div>'.get_ap_info($autonomous[2]['ap_id'])['name'].'<br />(무기고/식기)</div>';
											}
											?>
										</div>
									</td>
								</tr>

								<!-- 잔류 -->
								<tr class="input-data-container input-row input-data-row">
									<th class="col item-col item-col-0 item-col-division">
										<span>잔류</span>
									</th>
									<td class="col item-col item-col-platoon-0">
										<div class="absent-list-container">
											<?php

											echo_remain(0);

											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-1">
										<div class="absent-list-container">
											<?php

											echo_remain(1);

											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-2">
										<div class="absent-list-container">
											<?php

											echo_remain(2);

											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-3">
										<div class="absent-list-container">
											<?php

											echo_remain(3);

											?>
										</div>
									</td>
								</tr>

								<!-- 출동인원 -->
								<tr class="input-data-container input-row input-data-row num-go-out">
									<th class="col item-col item-col-0 item-col-division">
										<span>출동인원</span>
									</th>
									<td class="col item-col item-col-platoon-0">
										<div class="absent-list-container">
											<?php
											echo num_go_out($platoon_0_absent, 0);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-1">
										<div class="absent-list-container">
											<?php
											echo num_go_out($platoon_1_absent, 1);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-2">
										<div class="absent-list-container">
											<?php
											echo num_go_out($platoon_2_absent, 2);
											?>
										</div>
									</td>
									<td class="col item-col item-col-platoon-3">
										<div class="absent-list-container">
											<?php
											echo num_go_out($platoon_3_absent, 3);
											?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						</div>
					</div>
				</section>

				<?php include_once $_SERVER['DOCUMENT_ROOT'].'/modules/page-size-controller/ui.php'; ?>


				<!-- <div class="direct-add-event">
					<div class="add-event">

					</div>
					<div class="list-event">
						<?php
						$sql = "SELECT * FROM ap_outside_activity WHERE"
						?>
					</div>
				</div> -->
			</div>

		</div>
	</main>
	<script src="js/absent-list.js?v=1.001"></script>
</body>
</html>
