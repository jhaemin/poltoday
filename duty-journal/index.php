<?php
$agent_working_info_order = "govern";
include_once "../absent-list/absent-combo.php";

$today_time = strtotime($today);
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
<head>
	<meta charset="utf-8">
	<title>근무일지</title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
	<link rel="stylesheet" href="css/duty-journal.css?v=1.001" />
</head>
<body class="page-body">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main>
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
			<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
				<button class="date-change-button" type="submit">1일 후 ></button>
				<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' + 1 days')); ?>" />
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
		<section class="section-to-print">

			<div class="page-a4">
				<div class="page-contents page-adjustable">
					<div class="title-and-sign-area">
						<div class="title">
							<div style="font-size:.9em;font-weight:700;">제 35중대 근무일지</div>
							<div style="font-size:.7em;margin-top:.3em;"><?php echo '('.date('Y. m. d', $today_time).' '.echo_day_kr($today).'요일)'; ?></div>
						</div>
						<div class="sign-area">
							<table>
								<tr>
									<td rowspan="2">결<br>재</td>
									<td>당번부소대장</td>
									<td>당번소대장</td>
									<td>중대장</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
							</table>
						</div>
					</div>

					<!-- 당번지휘 -->
					<div class="agent">
						<div class="title-wrapper">
							<h1 class="table-title">1. 당번지휘</h1>
							<h1 class="duty" contenteditable="true">경력</h1>
						</div>
						<table class="journal-table">
							<tbody>
								<tr>
									<th>구분</th>
									<th>계급·성명</th>
									<th>근무<br>지정</th>
									<th>휴게(동숙)<br>지정시간</th>
									<th>현업수당<br>인정시간</th>
									<th>본인서명</th>
									<th>당번관서명</th>
									<th>중대장서명</th>
								</tr>
								<?php
								foreach ($agents_working_array as $key => $agent) {
									if (!($agent['roll'] == 7 || $agent['roll'] == 8 || $agent['roll'] == 9 || ($agent['working_group'] == 6 && $agent['sub_working_type'] == "" ) || $agent['sub_working_type'] == 3 || $agent['sub_working_type'] == 4)) {
										// 중대장님, 행소님, 행부관님, 당번 지휘요원 아니면 건너뛰기
										// 당번 & 서브타입 x 또는 (대리당번 또는 직무대리)
										continue;
									}

									// 중대장님 차례에서는 당번관 서명, 중대장님 서명란 rowspan
									if ($agent['roll'] == 7) {
										$rowspan = true;
									} else {
										$rowspan = false;
									}
									?>
									<tr>
										<td><?php echo $agent['call']; ?></td>
										<td style="white-space: nowrap;"><?php echo $agent['step'] . " " . $agent['name']; ?></td>
										<td><?php
										// if ($agent['sub_working_type']) {
										// 	echo get_agent_event_name($agent['sub_working_type']);
										// } else {
										// 	echo get_agent_event_name($agent['working_group']);
										// }
										echo $agent['event_name'];
										?></td>
										<!-- 휴게 동숙 시간 -->
										<td contenteditable="true"></td>
										<td></td>
										<td></td>
										<?php
										if ($rowspan) {
										?>
											<td rowspan="5"></td>
											<td rowspan="5"></td>
										<?php
										}
										?>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>

					<!-- 대원인원현황 -->
					<div class="ap">
						<h1 class="table-title">2. 대원인원현황</h1>
						<table class="journal-table ap">
							<thead>
								<tr>
									<th rowspan="2"></th>
									<th rowspan="2">총원</th>
									<th rowspan="2">사고</th>
									<th rowspan="2">현원</th>
									<th colspan="8">사고내용</th>
									<th colspan="2">출동률: <?php echo $width = round((num_go_out($platoon_0_absent, 0) + num_go_out($platoon_1_absent, 1) + num_go_out($platoon_2_absent, 2) + num_go_out($platoon_3_absent, 3)) / (count(get_currently_serving_member(null, $today))) * 100, 1); ?>%</th>
								</tr>
								<tr>
									<th>휴가</th>
									<th>외박</th>
									<th>특박</th>
									<th>입원</th>
									<th>교육</th>
									<th>보근</th>
									<th>파견</th>
									<th>기타</th>
									<th>잔류</th>
									<th>출동</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php $ap_total_num = count(get_currently_serving_member(null, $today)); ?>
									<td>계</td>
									<!-- 총원 -->
									<td class="crossed">
										<div class="up"><?php echo '9'; ?></div>
										<div class="down"><?php echo $ap_total_num; ?></div>
									</td>
									<!-- 사고 -->
									<td class="crossed">
										<div class="up"><?php echo $agent_total_absent_num; ?></div>
										<div class="down"><?php echo $ap_absent_total; ?></div>
									</td>
									<!-- 현원 -->
									<td class="crossed">
										<div class="up"><?php echo $agent_total_num - $agent_total_absent_num; ?></div>
										<div class="down"><?php echo $ap_total_num - $ap_absent_total; ?></div>
									</td>
									<!-- 휴가 -->
									<td><?php
									echo
									count($platoon_0_absent['vacation']) +
									count($platoon_1_absent['vacation']) +
									count($platoon_2_absent['vacation']) +
									count($platoon_3_absent['vacation']);
									?></td>
									<!-- 외박 -->
									<td><?php
									echo
									count($platoon_0_absent['out_sleep']) +
									count($platoon_1_absent['out_sleep']) +
									count($platoon_2_absent['out_sleep']) +
									count($platoon_3_absent['out_sleep']);
									?></td>
									<!-- 특박 -->
									<td><?php
									echo
									count($platoon_0_absent['special_out_sleep']) +
									count($platoon_1_absent['special_out_sleep']) +
									count($platoon_2_absent['special_out_sleep']) +
									count($platoon_3_absent['special_out_sleep']);
									?></td>
									<!-- 입원 -->
									<td><?php
									echo
									count($platoon_0_absent['sick']) +
									count($platoon_1_absent['sick']) +
									count($platoon_2_absent['sick']) +
									count($platoon_3_absent['sick']);
									?></td>
									<!-- 교육 -->
									<td><?php
									echo
									count($platoon_0_absent['etc']) +
									count($platoon_1_absent['etc']) +
									count($platoon_2_absent['etc']) +
									count($platoon_3_absent['etc']);
									?></td>
									<!-- 보근 -->
									<td></td>
									<!-- 파견 -->
									<td></td>
									<!-- 기타 -->
									<td></td>
									<!-- 잔류 -->
									<td class="crossed">
										<div class="up">
											<?php echo $agent_total_remain_num; ?>
										</div>
										<div class="down">
											<?php echo $ap_total_num - (num_go_out($platoon_0_absent, 0) + num_go_out($platoon_1_absent, 1) + num_go_out($platoon_2_absent, 2) + num_go_out($platoon_3_absent, 3)) - $ap_absent_total; ?>
										</div>
									</td>
									<!-- 출동 -->
									<td class="crossed">
										<div class="up">
											<?php echo 9 - $agent_total_absent_num - $agent_total_remain_num; ?>
										</div>
										<div class="down">
											<?php echo num_go_out($platoon_0_absent, 0) + num_go_out($platoon_1_absent, 1) + num_go_out($platoon_2_absent, 2) + num_go_out($platoon_3_absent, 3); ?>
										</div>
									</td>
								</tr>
								<?php
								for ($i = 0; $i < 4; $i++) {
									?>
									<tr>
										<td><?php if ($i == 0) { echo '행정'; } else { echo $i . '소대'; } ?></td>

										<?php $platoon_ap_total_num[$i] = count(get_currently_serving_member($i, $today, false)); ?>
										<!-- 총원 -->
										<td class="crossed">
											<div class="up">
												<?php echo $platoon_agent_total_num[$i]; ?>
											</div>
											<div class="down">
												<?php echo $platoon_ap_total_num[$i]; ?>
											</div>
										</td>
										<!-- 사고 -->
										<td class="crossed">
											<div class="up">
												<?php echo $platoon_agent_absent_num[$i]; ?>
											</div>
											<div class="down">
												<?php echo
												count(${"platoon_" . $i . "_absent"}['vacation']) +
												count(${"platoon_" . $i . "_absent"}['out_sleep']) +
												count(${"platoon_" . $i . "_absent"}['etc']) +
												count(${"platoon_" . $i . "_absent"}['sick']) +
												count(${"platoon_" . $i . "_absent"}['special_out_sleep']);
												?>
											</div>
										</td>
										<!-- 현원 -->
										<td class="crossed">
											<div class="up">
												<?php echo $platoon_agent_total_num[$i] - $platoon_agent_absent_num[$i]; ?>
											</div>
											<div class="down">
												<?php echo
												$platoon_ap_total_num[$i] - (count(${"platoon_" . $i . "_absent"}['vacation']) +
												count(${"platoon_" . $i . "_absent"}['out_sleep']) +
												count(${"platoon_" . $i . "_absent"}['etc']) +
												count(${"platoon_" . $i . "_absent"}['sick']) +
												count(${"platoon_" . $i . "_absent"}['special_out_sleep']));
												?>
											</div>
										</td>
										<!-- 휴가 -->
										<td><?php echo count(${"platoon_" . $i . "_absent"}['vacation']); ?></td>
										<!-- 외박 -->
										<td><?php echo count(${"platoon_" . $i . "_absent"}['out_sleep']); ?></td>
										<!-- 특박 -->
										<td><?php echo count(${"platoon_" . $i . "_absent"}['special_out_sleep']); ?></td>
										<!-- 입원 -->
										<td><?php echo count(${"platoon_" . $i . "_absent"}['sick']); ?></td>
										<!-- 교육 -->
										<td><?php echo count(${"platoon_" . $i . "_absent"}['etc']); ?></td>
										<!-- 보근 -->
										<td></td>
										<!-- 파견 -->
										<td></td>
										<!-- 기타 -->
										<td></td>
										<!-- 잔류 -->
										<td class="crossed">
											<div class="up">
												<?php echo $platoon_agent_remain_num[$i]; ?>
											</div>
											<div class="down">
												<?php echo $platoon_ap_total_num[$i] - (count(${"platoon_" . $i . "_absent"}['vacation']) +
												count(${"platoon_" . $i . "_absent"}['out_sleep']) +
												count(${"platoon_" . $i . "_absent"}['etc']) +
												count(${"platoon_" . $i . "_absent"}['sick']) +
												count(${"platoon_" . $i . "_absent"}['special_out_sleep'])) - num_go_out(${"platoon_" . $i . "_absent"}, $i); ?>
											</div>
										</td>
										<!-- 출동 -->
										<td class="crossed">
											<div class="up">
												<?php echo $platoon_agent_total_num[$i] - $platoon_agent_absent_num[$i] - $platoon_agent_remain_num[$i]; ?>
											</div>
											<div class="down">
												<?php echo num_go_out(${"platoon_" . $i . "_absent"}, $i); ?>
											</div>
										</td>
									</tr>
									<?php
								}
								?>
							</tbody>
						</table>
					</div>

					<!-- 특별지시사항 -->
					<div class="direction">
						<h1 class="table-title">3. 특별지시사항 【중대장(부재 시 당번소대장)이 기재】</h1>
						<div class="sign-box"></div>
					</div>

					<!-- 감독순시 -->
					<div class="observer">
						<h1 class="table-title">4. 감독순시</h1>
						<div class="sign-box"></div>
					</div>
				</div>
			</div>

			<div class="page-a4">

				<div class="specific">
					<h1 class="table-title">5. 지휘요원 세부 근무내역</h1>

					<table class="journal-table">
						<thead>
							<tr>
								<th class="crossed-reversed" rowspan="2"></th>
								<th rowspan="2">직위</th>
								<th rowspan="2">계급</th>
								<th rowspan="2">성명</th>
								<th rowspan="2">근무지정</th>
								<th colspan="2">근무내역</th>
								<th rowspan="2">근무자<br>확인서명</th>
							</tr>
							<tr>
								<th>주간</th>
								<th>야간</th>
							</tr>
						</thead>

						<tbody>
							<?php
							$agent_list = get_agent_working_info($today, "platoon");
							for ($i = 0; $i < sizeof($agent_list); $i++) {
								$agent = $agent_list[$i];
								$rowspan;
								$is_first_td = true;
								$platoon;
								if ($i == 0) {
									$rowspan = 3;
									$is_first_td = true;
									$platoon = "본부";
								} else if ($i == 3 || $i == 5 || $i == 7) {
									$rowspan = 2;
									$is_first_td = true;
									if ($i == 3) $platoon = "1소대";
									if ($i == 5) $platoon = "2소대";
									if ($i == 7) $platoon = "3소대";
								} else {
									$rowspan = 0;
									$is_first_td = false;
								}
							?>
							<tr>
								<?php if ($is_first_td) { ?>
								<td <?php if ($rowspan) echo 'rowspan="' . $rowspan . '"'; ?>><?php echo $platoon; ?></td>
								<?php } ?>

								<td><?php echo $agent['call']; ?></td>
								<td><?php echo $agent['step']; ?></td>
								<td><?php echo $agent['name']; ?></td>
								<td><?php
								if ($agent['sub_working_type']) {
									if ($agent['sub_working_type'] == 5) {
										echo get_agent_event_name(7) . '<br>' . '('.get_agent_event_name($agent['sub_working_type']).')';
									} else if ($agent['sub_working_type'] == 10) {
										echo get_agent_event_name(7);
									} else {
										echo $agent['event_name'];
									}
									
								} else {
									
									echo $agent['event_name'];
								}
								?></td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
								<td></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<div class="night">
					<h1 class="table-title">6. 대원 야간근무 편성표</h1>

					<table class="journal-table">

						<thead>

							<tr>
								<th rowspan="2">근무시간</th>
								<th colspan="3">불침번</th>
							</tr>
							<tr>
								<th>계급</th>
								<th>성명</th>
								<th>서명</th>
							</tr>

						</thead>

						<tbody>

							<?php for ($i = 0; $i < 8; $i++) { ?>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<?php } ?>

						</tbody>

					</table>
				</div>

				<div class="govern">
					<h1 class="table-title">7. 행정대원 근무일지</h1>

					<table class="journal-table">

						<thead>

							<tr>
								<th colspan="4">행정대원 근무</th>
							</tr>
							<tr>
								<td colspan="4">07:00 ~ 20:00 (일일 8시간 內 근무)</td>
							</tr>

						</thead>

						<tbody>

							<tr>
								<td>근무시간</td>
								<td>계급</td>
								<td>성명</td>
								<td>서명</td>
							</tr>

							<?php
							$govern_ap_list = get_today_govern($today);
							for ($i = 0; $i < sizeof($govern_ap_list['gov']); $i++) {
								$ap = $govern_ap_list['gov'][$i];
							?>

							<tr>
								<td></td>
								<td><?php echo $ap['level']; ?></td>
								<td><?php echo $ap['name']; ?></td>
								<td></td>
							</tr>

							<?php } ?>

						</tbody>

					</table>
				</div>

			</div>

		</section>
	</main>
</body>
</html>
