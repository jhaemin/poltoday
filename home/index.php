<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

$govern_aps = get_today_govern_fair($today);

?>

<!DOCTYPE html>
<html>
<head>
	<title>PolToday</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="/css/home.css?v=1.000" />
	<link rel="stylesheet" href="/home/css/notice.css?v=1.000">
</head>
<body id="today-body">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>

	<main id="today-main">

		<?php
		if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
		?>
		<div id="notice">
			<div class="new-notice-modal">
				<div class="writer-box">
					<h1 class="title">새 공지사항</h1>

					<div class="noticer">
						<?php
						$hs = get_agent_info_by_roll(8);
						var_dump($hs);
						?>
						<div class="member hs" data-type="agent" data-agent-id="<?php echo $hs["id"]; ?>">
							<?php echo $hs["call"]; ?>
						</div>
						<?php foreach ($govern_aps as $key => $ap) { ?>
							<div class="member" data-type="ap" data-ap-id="<?php echo $ap["id"]; ?>"><?php echo $ap['name']; ?></div>
						<?php } ?>
					</div>
					<textarea class="textarea" placeholder="내용을 입력하세요."></textarea>
					
					<div class="btn-container">
						<button class="upload">업로드</button>
					</div>
				</div>
			</div>
			<h1 class="notice-title">공지사항
				<div class="add-new-notice cross-button add">
					<div class="cross left-down"></div>
					<div class="cross right-down"></div>
				</div>
			</h1>
			<div class="notice-item-container"></div>
			<div class="loading-bar-wrapper"></div>
		</div>
		<?php
		}
		?>

		<div id="today">
			<a href="/changelog/index.php">
				<div id="updates" class="banner">
					<h1>1.6.3(18-12-20) 업데이트 내역 보기</h1>
				</div>
			</a>
		
			<?php
			if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
			?>
		
			<a href="/transmission/">
				<div class="transmission-alert banner">
					<?php
					
					$total = 0;
					foreach ($govern_aps as $key => $ap) {
						$ap_id = $ap['id'];
						$total += mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transmit_item join ap_transmission on transmit_item.id = ap_transmission.transmit_item_id WHERE ap_transmission.ap_id='$ap_id' AND done_at=''"));
					}
					?>
					<h1>완료되지 않은 총 <?php echo $total; ?>개의 인수인계 또는 할 일이 있습니다.</h1>
					<h2>
					<?php
					foreach ($govern_aps as $key => $ap) {
						$ap_id = $ap['id'];
						echo "<span class='member'>" . $ap['name']. " : " . mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transmit_item join ap_transmission on transmit_item.id = ap_transmission.transmit_item_id WHERE ap_transmission.ap_id='$ap_id' AND done_at=''")) . "</span>";
					}
					?>
					</h2>
				</div>
			</a>
		
			<?php
			}
			?>
		
			<div class="today-header-container">
				<h1 class="typography-header today-header"><span style="font-family: 'SF Neo Text', sans-serif; font-weight: 700;">PolToday</span><span style="font-family: 'SF Neo Text', sans-serif; font-size: .5em; font-weight: 700; color: #aaaaaa; display: block; margin-top: 10px;"><?php echo date('Y. m. d'); ?></span></h1>
			</div>
		
			<div class="today-section-container">
				<div class="today-section today-total-member-number">
		
					<?php
					$total_member_count = count(get_currently_serving_member());
					$platoon0_member = count(get_currently_serving_member(0));
					$platoon1_member = count(get_currently_serving_member(1));
					$platoon2_member = count(get_currently_serving_member(2));
					$platoon3_member = count(get_currently_serving_member(3));
					?>
		
					<div class="today-section-title-wrapper">
						<h2 class="today-section-title">오늘 총 인원</h2>
						<?php
						if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
						?>
						<a class="today-link" href="/ap-info" title="">대원 정보 ></a>
						<?php
						}
						?>
					</div>
					<div class="wrapper">
						<div class="today-section-contents">
							<h3 class="typography-header"><?php echo $total_member_count; ?>명</h3>
							<span>본부: <?php echo $platoon0_member; ?>명, 1소대: <?php echo $platoon1_member; ?>명, 2소대: <?php echo $platoon2_member; ?>명, 3소대: <?php echo $platoon3_member; ?>명</span>
						</div>
					</div>
				</div>
		
				<div class="today-section today-work">
					<div class="today-section-title-wrapper">
						<h2 class="today-section-title">오늘 경력</h2>
					</div>
					<!-- <p class=""></p> -->
					<div class="add-work">경력 입력하기</div>
				</div>
		
				<div class="today-section today-duty">
					<div class="today-section-title-wrapper">
						<h2 class="today-section-title">오늘 일당비</h2>
						<a class="today-link" href="/duty" title="">당직근무 편성표 ></a>
					</div>
					<div class="wrapper">
						<div class="today-section-contents">
							<?php
							$duty_list = get_today_duty($today);
							?>
							<div class="duty-container">
								<div class="duty-type">당직</div>
								<div class="duty-team"><?php echo $duty_list['d'], '팀'; ?></div>
							</div>
							<div class="duty-container">
								<div class="duty-type">일근</div>
								<div class="duty-team"><?php echo $duty_list['i'], '팀'; ?></div>
							</div>
							<div class="duty-container">
								<div class="duty-type">휴무</div>
								<div class="duty-team"><?php echo $duty_list['b'], '팀'; ?></div>
							</div>
						</div>
					</div>
				</div>
		
				<div class="today-section today-autonomous">
					<?php
					$p_array = get_today_autonomous($today);
					$p1 = get_ap_info($p_array[0]['ap_id'])['name'];
					$p2 = get_ap_info($p_array[1]['ap_id'])['name'];
					$p3 = get_ap_info($p_array[2]['ap_id'])['name'];
					?>
					<div class="today-section-title-wrapper">
						<h2 class="today-section-title">오늘 자경/식기</h2>
						<?php
						if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
						?>
						<a class="today-link" href="/autonomous" title="">자경/식기 업데이트 ></a>
						<?php
						}
						?>
					</div>
					<div class="wrapper">
						<div class="today-section-contents">
							<div class="autonomous-wrapper">
								<div class="platoon-number">1소대</div>
								<div class="name"><?php echo $p1; ?></div>
							</div>
							<div class="autonomous-wrapper">
								<div class="platoon-number">2소대</div>
								<div class="name"><?php echo $p2; ?></div>
							</div>
							<div class="autonomous-wrapper">
								<div class="platoon-number">3소대</div>
								<div class="name"><?php echo $p3; ?></div>
							</div>
						</div>
					</div>
				</div>
		
				<div class="today-section today-go-out">
					<div class="today-section-title-wrapper">
						<h2 class="today-section-title">오늘 나가는 대원</h2>
					</div>
					<div class="wrapper">
						<div class="today-section-contents">
							<?php
							$sql = "SELECT * FROM ap_outside_activity WHERE out_at='$today' AND (type=1 OR type=2 OR type=3 OR type=5 OR type=6 OR type=8)";
							$result = mysqli_query($conn, $sql);
							$count = 0;
							if (!$result) echo mysqli_error($conn);
							while ($row = mysqli_fetch_assoc($result)) {
								$ap = get_ap_info($row['ap_id']);
								if ($ap['moved_out']) {
									continue;
								}
								echo $ap['name'] . ' (' . $row['display_name'] . ', '.
								date('m.d',strtotime($row['out_at'])) .
								' - ' . date('m.d', strtotime($row['in_at'])) . ')' . '<br />';
		
								$count++;
							}
							if ($count == 0) {
								echo '오늘 나가는 대원이 없습니다.';
							}
							?>
						</div>
					</div>
				</div>
		
				<div class="today-section today-get-in">
					<div class="today-section-title-wrapper">
						<h2 class="today-section-title">오늘 들어오는 대원</h2>
					</div>
					<div class="wrapper">
						<div class="today-section-contents">
							<?php
							$sql = "SELECT * FROM ap_outside_activity WHERE in_at='$today' AND (type=1 OR type=2 OR type=3 OR type=5 OR type=6 OR type=8)";
							$result = mysqli_query($conn, $sql);
							$count = 0;
							if (!$result) echo mysqli_error($conn);
							while ($row = mysqli_fetch_assoc($result)) {
								$ap = get_ap_info($row['ap_id']);
								if ($ap['moved_out']) {
									continue;
								}
								echo $ap['name'] . ' (' . $row['display_name'] . ', '.
								date('m.d',strtotime($row['out_at'])) .
								' - ' . date('m.d', strtotime($row['in_at'])) . ')' . '<br />';
		
								$count++;
							}
							if ($count == 0) {
								echo '오늘 들어오는 대원이 없습니다.';
							}
							?>
						</div>
					</div>
				</div>
		
				<div class="today-section today-out">
					<div class="today-section-title-wrapper">
						<h2 class="today-section-title">오늘 나가있는 대원</h2>
					</div>
					<div class="wrapper">
						<div class="today-section-contents">
							<?php
							$sql = "SELECT * FROM ap_outside_activity WHERE out_at<='$today' AND in_at>='$today' AND (type=1 OR type=2 OR type=3 OR type=5 OR type=6 OR type=8)";
							$result = mysqli_query($conn, $sql);
							$count = 0;
							if (!$result) echo mysqli_error($conn);
							while ($row = mysqli_fetch_assoc($result)) {
								$ap = get_ap_info($row['ap_id']);
								if ($ap['moved_out']) {
									continue;
								}
								echo $ap['name'] . ' (' . $row['display_name'] . ', '.
								date('m.d',strtotime($row['out_at'])) .
								' - ' . date('m.d', strtotime($row['in_at'])) . ')' . '<br />';
		
								$count++;
							}
							if ($count == 0) {
								echo '오늘 나가있는 대원이 없습니다.';
							}
							?>
						</div>
					</div>
				</div>
		
				 
		
			</div>
		
			<!-- <div class="image-placeholder">
				<a href="/profile/?ap_id=87">
					<img class="doraemong-img" src="/images/스폰지밥과 친구들.png" />
				</a>
			</div> -->
		
		</div>
	</main>

	<script src="/home/notice.js?v=1.000"></script>
</body>
</html>
