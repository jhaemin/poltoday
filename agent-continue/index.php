<?php
include_once "../daily-information/daily-combo.php";

// 인수인계 데이터 가져오기
$sql = "SELECT * FROM agent_continue WHERE handed_at = '$today'";
$result = mysqli_query($conn, $sql);
if (!$result) {
	echo mysqli_error($conn);
} else {
	$result = mysqli_fetch_assoc($result);
	$contents = $result['contents'];
	$contents = json_decode($contents, true);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>일일업무보고</title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/agent-continue.css?v=1.001"/>
</head>
<body class="page-body" data-today="<?php echo $today; ?>">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main>
		<div id="absent-list-main">
			<div class="date-change">
				<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
					<button class="date-change-button" type="submit">< 한 달 전</button>
					<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today. ' - 1 months')); ?>" />
				</form>
				<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
					<button class="date-change-button" type="submit">< 7일 전</button>
					<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' - 7 days')); ?>" />
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
		</div>
		<div class="known-issue">
			<!-- <div class="ki-contents">
				<h1>알려진 문제점</h1>
				<p>없음</p>
			</div> -->
		</div>
		<section class="section-to-print">
			<div class="daily-information page-a4">
				<div class="page-contents page-adjustable">
					<h1 style="position:absolute;left:0;top:0;font-family:'SF Neo text';font-size:.7em;font-weight: 400;color:#fff;background: #04b54e;border-radius:5px;padding: .3em .3em .17em;">1035</h1>
					<?php
					$today_duty = get_today_duty($today);
					?>
					<h1 class="typography-header daily-information-title">당직관 인수인계</h1>
					<p class="today-date"><?php echo $today." (".$day_name_kr[date('w', strtotime($today))].")"; ?></p>
					<div class="top-table-container">
						<div class="counting-table-wrapper">
							<h1 class="table-title">인원현황</h1>
							<table class="counting">
								<tr>
									<td colspan="5" style="font-weight: 700; position: relative;">
										<p style="color: red;">출동률: <?php echo $width = round((num_go_out($platoon_0_absent, 0) + num_go_out($platoon_1_absent, 1) + num_go_out($platoon_2_absent, 2) + num_go_out($platoon_3_absent, 3)) / (count(get_currently_serving_member(null, $today)) - $ap_absent_total) * 100, 1); ?>%</p>
										<!-- <div style="position: absolute; height: 100%; width: <?php echo (int)$width.'%'; ?>; top: 0; left: 0; background-color: black;"></div> -->
									</td>

								</tr>
								<tr>
									<th>소대</th>
									<th>총원</th>
									<th>사고자</th>
									<th>현원</th>
									<th>출동</th>
								</tr>
								<tr class="total-row">
									<th>총계</th>
									<?php $ap_total_num = count(get_currently_serving_member(null, $today)); ?>
									<td><?php echo '9 / '.$ap_total_num; ?></td>
									<!-- <td></td> -->
									<td><?php echo $agent_total_absent_num.' / '.$ap_absent_total; ?></td>
									<td style="background-color:#e8deff;"><?php echo ($agent_total_num - $agent_total_absent_num).' / '.($ap_total_num - $ap_absent_total); ?></td>
									<td><?php echo (9 - $agent_total_absent_num - $agent_total_remain_num).' / '.(num_go_out($platoon_0_absent, 0) + num_go_out($platoon_1_absent, 1) + num_go_out($platoon_2_absent, 2) + num_go_out($platoon_3_absent, 3));  ?></td>
								</tr>
								<?php
								for ($i = 0; $i < 4; $i++) {
								?>
								<tr>
									<!-- 소대별 대원 총원 -->
									<th><?php if ($i == 0) {echo 'HQ';} else {echo $i.'소대';} ?></th>

									<!-- 소대별 지휘요원/대원 총원 -->
									<?php $platoon_ap_total_num[$i] = count(get_currently_serving_member($i, $today, true)); ?>
									<td><?php echo $platoon_agent_total_num[$i].' / '.$platoon_ap_total_num[$i]; ?></td>

									<!-- 소대별 지휘요원 사고자 -->
									<td><?php
										echo $platoon_agent_absent_num[$i].' / '.
										(count(${"platoon_".$i."_absent"}['vacation']) +
										count(${"platoon_".$i."_absent"}['out_sleep']) +
										count(${"platoon_".$i."_absent"}['etc']) +
										count(${"platoon_".$i."_absent"}['sick']) +
										count(${"platoon_".$i."_absent"}['special_out_sleep']));
									?></td>

									<td class="current current-agent"><?php
										echo ($platoon_agent_total_num[$i] - $platoon_agent_absent_num[$i]).' / '.
										($platoon_ap_total_num[$i] -
										(
										count(${"platoon_".$i."_absent"}['vacation']) +
										count(${"platoon_".$i."_absent"}['out_sleep']) +
										count(${"platoon_".$i."_absent"}['etc']) +
										count(${"platoon_".$i."_absent"}['sick']) +
										count(${"platoon_".$i."_absent"}['special_out_sleep'])
										));
									?></td>

									<td><?php echo ($platoon_agent_total_num[$i] - $platoon_agent_absent_num[$i] - $platoon_agent_remain_num[$i]).' / '.num_go_out(${"platoon_".$i."_absent"}, $i); ?></td>
								</tr>
								<?php
								}
								?>
							</table>
						</div>
						<div class="agent-wrapper">
							<h1 class="table-title">근무현황</h1>
							<table class="agent">
								<tr>
									<th>중대장님</th>
									<th>당직</th>
									<th>일근</th>
									<th>휴무</th>
								</tr>
								<tr>
									<td><?php
									foreach ($agents_working_array as $key => $agent) {
										if ($agent['roll'] == 7) {
											if ($agent['sub_working_type']) {
												echo get_agent_event_name($agent['sub_working_type']);
											} else {
												echo get_agent_event_name($agent['working_group']);
											}
										} else {
											continue;
										}
									}

									?></td>
									<td><?php
									foreach ($agents_working_array as $key => $agent) {
										if ($agent['working_group'] == 6) {
											print '<div class="agent-call-name">'.$agent['call'];
											if ($agent['sub_working_type']) {
												print '<br />('. get_agent_event_name($agent['sub_working_type']).')</div>';
											} else {
												print '</div>';
											}
										}
									}
									?></td>
									<td><?php
									foreach ($agents_working_array as $key => $agent) {
										if ($agent['working_group'] == 7 && $agent['roll'] != 7) {
											print '<div class="agent-call-name">'.$agent['call'];
											if ($agent['sub_working_type']) {
												print '<br />('. get_agent_event_name($agent['sub_working_type']).')</div>';
											} else {
												print '</div>';
											}
										}
									}
									?></td>
									<td rowspan="2"><?php
									foreach ($agents_working_array as $key => $agent) {
										if ($agent['working_group'] == 8) {
											print '<div class="agent-call-name">'.$agent['call'];
											if ($agent['sub_working_type']) {
												print '<br />('. get_agent_event_name($agent['sub_working_type']).')</div>';
											} else {
												print '</div>';
											}
										}
									}
									?></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="alh-wrapper">
						<h1 class="table-title">사고자 현황</h1>
						<table class="abesnt-list-horizontal">
							<thead>
								<tr>
									<th>소대</th>
									<th>휴가 (<?php
										echo
										count($platoon_0_absent['vacation']) +
										count($platoon_1_absent['vacation']) +
										count($platoon_2_absent['vacation']) +
										count($platoon_3_absent['vacation']);
										?>)</th>
									<th>정기 외박 (<?php
										echo
										count($platoon_0_absent['out_sleep']) +
										count($platoon_1_absent['out_sleep']) +
										count($platoon_2_absent['out_sleep']) +
										count($platoon_3_absent['out_sleep']);
										?>)</th>
									<th>병가 (<?php
										echo
										count($platoon_0_absent['sick']) +
										count($platoon_1_absent['sick']) +
										count($platoon_2_absent['sick']) +
										count($platoon_3_absent['sick']);
										?>)</th>
									<th>교육 (<?php
										echo
										count($platoon_0_absent['etc']) +
										count($platoon_1_absent['etc']) +
										count($platoon_2_absent['etc']) +
										count($platoon_3_absent['etc']);
										?>)</th>
									<th>특별 외박 (<?php
										echo
										count($platoon_0_absent['special_out_sleep']) +
										count($platoon_1_absent['special_out_sleep']) +
										count($platoon_2_absent['special_out_sleep']) +
										count($platoon_3_absent['special_out_sleep']);
										?>)</th>
									<th>잔류 (<?php
										echo
										count($platoon_0_absent['autonomous']) +
										count($platoon_1_absent['autonomous']) +
										count($platoon_2_absent['autonomous']) +
										count($platoon_3_absent['autonomous']) +
										count($platoon_0_absent['patient']) +
										count($platoon_1_absent['patient']) +
										count($platoon_2_absent['patient']) +
										count($platoon_3_absent['patient']) +
										count($platoon_0_absent['etc_remain']) +
										count($platoon_1_absent['etc_remain']) +
										count($platoon_2_absent['etc_remain']) +
										count($platoon_3_absent['etc_remain']) +
										count($platoon_0_absent['govern']) +
										count($platoon_1_absent['govern']) +
										count($platoon_2_absent['govern']) +
										count($platoon_3_absent['govern']);
										?>)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<th>HQ</th>
									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item($platoon_0_absent['vacation'], true);
										?>
									</td>
									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item($platoon_0_absent['out_sleep'], true);
										?>
									</td>


									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item($platoon_0_absent['sick'], true);
										?>
									</td>
									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item($platoon_0_absent['etc'], true);
										?>
									</td>
									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item($platoon_0_absent['special_out_sleep'], true);
										?>
									</td>
									<td contenteditable="true">
										<?php
										echo_remain(0);
										?>
									</td>
								</tr>
								<?php
								for ($i = 1; $i <= 3; $i++) {
								?>
								<tr>
									<th><?php echo $i; ?>소대</th>
									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item(${"platoon_".$i."_absent"}['vacation'], true);
										?>
									</td>
									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item(${"platoon_".$i."_absent"}['out_sleep'], true);
										?>
									</td>


									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item(${"platoon_".$i."_absent"}['sick'], true);
										?>
									</td>
									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item(${"platoon_".$i."_absent"}['etc'], true);
										?>
									</td>
									<td contenteditable="true" class="fixed-td">
										<?php
										echo_absent_item(${"platoon_".$i."_absent"}['special_out_sleep'], true);
										?>
									</td>
									<td contenteditable="true">
										<?php
										echo_remain($i);
										if (${"p".$i."_autonomous_info"}) {
											echo '<div class="activity-item">'.${"p".$i."_autonomous_info"}.'<br />(자경/식기)</div>';
										}

										?>
									</td>
								</tr>
								<?php
								}
								?>


							</tbody>
						</table>
					</div>

					<!-- 주요업무사항 -->
					<!-- <div class="event-to-text">
						<h1 class="table-title">주요 업무 사항</h1>
						<table>
							<tbody>
								<tr>
									<th>어제 한 일 (<?php echo date('m. d', strtotime($today.'-1 day')); ?>)</th>
									<th>오늘 할 일 (<?php echo date('m. d', strtotime($today)); ?>)</th>
								</tr>
								<tr>
									<td contenteditable="true"><?php what_to_do_today(date('Y-m-d', strtotime($today.'-1  day'))); ?></td>
									<td contenteditable="true"><?php what_to_do_today($today); ?></td>
								</tr>
							</tbody>
						</table>
					</div> -->

					<!-- 특이대원 -->
					<div class="section unique-ap">
						<h1 class="table-title">특이대원</h1>
						<div class="container">
							<!-- 환자 -->
							<div class="area patient">
								<h2>환자</h2>
								<textarea class="box"><?php
									if ($contents) {
										// echo $contents['lightout'];
										echo preg_replace('/<br>/', '&#013;&#010;', $contents['patient']);
									}
								?></textarea>
							</div>
							<!-- 적발사항 -->
							<div class="area catch">
								<h2>적발사항</h2>
								<textarea class="box"><?php
									if ($contents) {
										// echo $contents['lightout'];
										echo preg_replace('/<br>/', '&#013;&#010;', $contents['catch']);
									}
								?></textarea>
							</div>
						</div>
					</div>

					<!-- 점호 시 교양해야 할 사항 -->
					<div class="section light-out">
						<h1 class="table-title">점호 시 교양해야 할 사항</h1>
						<textarea class="box" name="name"><?php
							if ($contents) {
								// echo $contents['lightout'];
								echo preg_replace('/<br>/', '&#013;&#010;', $contents['lightout']);
							}
						?></textarea>

					</div>

					<!-- 익일 당직관에게 인계할 사항 -->
					<div class="section hand">
						<h1 class="table-title">익일 당직관에게 인계할 사항</h1>
						<textarea class="box" name="name"><?php
							if ($contents) {
								// echo $contents['hand'];
								echo preg_replace('/<br>/', '&#013;&#010;', $contents['hand']);
							}
						?></textarea>
					</div>

				</div>
		</div>
		</section>
		<?php include_once $_SERVER['DOCUMENT_ROOT'].'/modules/page-size-controller/ui.php'; ?>
	</main>
	<script src="js/agent-continue.js?v=1.001"></script>
</body>
</html>
