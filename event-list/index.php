<?php
include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

function format_event($ap, $event) {
	echo '<span class="name">' . $ap['name'] . '</span>' . '<br>';
	echo $event['display_name'] . '<br>';
	$in_at = $event['in_at'];
	$in_date = new DateTime($event['in_at']);
	if ($in_date->format('Y') == "9999") {
		$in_at = '별명시';
	}
	if ($event['in_at'] == $event['out_at']) {
		echo date('Y. m. d', strtotime($event['out_at']));
		return;
	}
	echo '<span class="start-date">' . date('Y. m. d', strtotime($event['out_at'])) . '</span>'
			//  . "<br>"
			 . " ~ "
			//  . "<br>"
			 . '<span class="end-date">' . date('Y. m. d', strtotime($event['in_at'])) . '</span>';
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>이벤트 목록</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/event-list.css?v=1.003" />
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="event-list-main">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/edit-event-module/edit-event-ui.php'; ?>

		<h1 class="typography-header event-list-headline">의무경찰 이벤트 목록</h1>
		<h3 style="text-align:center;padding-top:10px;font-size:16px;color:#999;">각 항목에서 최근 추가된 100개의 이벤트 목록입니다.</h3>

		<div class="event-container">

			<div class="go-out specific-event-category">
				<h1 class="title">잔류</h1>
			<?php
			$sql = "SELECT * FROM ap_outside_activity WHERE type = 9 OR type = 10 ORDER BY id DESC LIMIT 100";
			$result = mysqli_query($conn, $sql);
			if (!$result) { echo mysqli_error($conn); }
			while ($row = mysqli_fetch_assoc($result)) {
				$ap = get_ap_info($row['ap_id']);
			?>
				<li class="event-item" data-event-id="<?php echo $row['id']; ?>" data-out-at="<?php echo $row['out_at']; ?>" data-in-at="<?php echo $row['in_at']; ?>" data-type="<?php echo $row['type']; ?>" data-display-name="<?php echo $row['display_name']; ?>" data-out-time="<?php echo $row['out_time']; ?>" data-in-time="<?php echo $row['in_time']; ?>" data-note="<?php echo $row['note']; ?>">
					<div class="event-name"><?php format_event($ap, $row); ?></div>
					<div class="event-edit">
						<button class="event-modify event-mod-btn" type="button">수정</button>
						<button class="event-delete event-mod-btn" type="button">삭제</button>
					</div>
				</li>
			<?php
			}
			?>
			</div>

			<div class="go-out specific-event-category">
				<h1 class="title">특별외출 | 병원외출</h1>
			<?php
			$sql = "SELECT * FROM ap_outside_activity WHERE type = 4 OR type = 11 ORDER BY id DESC LIMIT 100";
			$result = mysqli_query($conn, $sql);
			if (!$result) { echo mysqli_error($conn); }
			while ($row = mysqli_fetch_assoc($result)) {
				$ap = get_ap_info($row['ap_id']);
			?>
				<li class="event-item" data-event-id="<?php echo $row['id']; ?>" data-out-at="<?php echo $row['out_at']; ?>" data-in-at="<?php echo $row['in_at']; ?>" data-type="<?php echo $row['type']; ?>" data-display-name="<?php echo $row['display_name']; ?>" data-out-time="<?php echo $row['out_time']; ?>" data-in-time="<?php echo $row['in_time']; ?>" data-note="<?php echo $row['note']; ?>">
					<div class="event-name"><?php format_event($ap, $row); ?></div>
					<div class="event-edit">
						<button class="event-modify event-mod-btn" type="button">수정</button>
						<button class="event-delete event-mod-btn" type="button">삭제</button>
					</div>
				</li>
			<?php
			}
			?>
			</div>

			<div class="out-sleep specific-event-category">
				<h1 class="title">외박 | 특박 | 교육</h1>
			<?php
			$sql = "SELECT * FROM ap_outside_activity WHERE type = 2 OR type = 3 OR type = 8 ORDER BY id DESC LIMIT 100";
			$result = mysqli_query($conn, $sql);
			if (!$result) { echo mysqli_error($conn); }
			while ($row = mysqli_fetch_assoc($result)) {
				$ap = get_ap_info($row['ap_id']);
			?>
				<li class="event-item" data-event-id="<?php echo $row['id']; ?>" data-out-at="<?php echo $row['out_at']; ?>" data-in-at="<?php echo $row['in_at']; ?>" data-type="<?php echo $row['type']; ?>" data-display-name="<?php echo $row['display_name']; ?>" data-out-time="<?php echo $row['out_time']; ?>" data-in-time="<?php echo $row['in_time']; ?>" data-note="<?php echo $row['note']; ?>">
					<div class="event-name"><?php format_event($ap, $row); ?></div>
					<div class="event-edit">
						<button class="event-modify event-mod-btn" type="button">수정</button>
						<button class="event-delete event-mod-btn" type="button">삭제</button>
					</div>
				</li>
			<?php
			}
			?>
			</div>
			<div class="vacation specific-event-category">
				<h1 class="title">휴가 | 병가</h1>
			<?php
			$sql = "SELECT * FROM ap_outside_activity WHERE type = 1 OR type = 5 OR type = 6 ORDER BY id DESC LIMIT 100";
			$result = mysqli_query($conn, $sql);
			if (!$result) { echo mysqli_error($conn); }
			while ($row = mysqli_fetch_assoc($result)) {
				$ap = get_ap_info($row['ap_id']);
			?>
				<li class="event-item" data-event-id="<?php echo $row['id']; ?>" data-out-at="<?php echo $row['out_at']; ?>" data-in-at="<?php echo $row['in_at']; ?>" data-type="<?php echo $row['type']; ?>" data-display-name="<?php echo $row['display_name']; ?>" data-out-time="<?php echo $row['out_time']; ?> " data-in-time="<?php echo $row['in_time']; ?>" data-note="<?php echo $row['note']; ?>">
					<div class="event-name"><?php format_event($ap, $row); ?></div>
					<div class="event-edit">
						<button class="event-modify event-mod-btn" type="button">수정</button>
						<button class="event-delete event-mod-btn" type="button">삭제</button>
					</div>
				</li>
			<?php
			}
			?>
			</div>
			<div class="remain">

			</div>
			<div class="hospital">

			</div>
		</div>


		<!-- <div>
		<?php

		$sql = "SELECT * FROM ap_outside_activity WHERE type=4 OR type=6 OR type=7 OR type=8 OR type=9 OR type=10 OR type=11 ORDER BY id DESC LIMIT 100";
		$result = mysqli_query($conn, $sql);
		if (!$result) { echo mysqli_error($conn); }
		while ($row = mysqli_fetch_assoc($result)) {
			$ap = get_ap_info($row['ap_id']);
		?>
		<ol class="event-container">
			<li class="event-item" data-event-id="<?php echo $row['id']; ?>" data-out-at="<?php echo $row['out_at']; ?>" data-in-at="<?php echo $row['in_at']; ?>" data-type="<?php echo $row['type']; ?>" data-display-name="<?php echo $row['display_name']; ?>" data-out-time="<?php echo $row['out_time']; ?>" data-in-time="<?php echo $row['in_time']; ?>">
				<div class="event-name">
					<?php
					$interval = $row['out_at'] . ' ~ ' . $row['in_at'];
					if ($row['out_at'] == $row['in_at']) {
						$interval = $row['out_at'];
					}
					?>
					<?php echo $ap['name'].' '.$row['display_name'].' '.$interval; ?>
				</div>
				<div class="event-edit">
					<button class="event-modify" type="button">수정</button>
					<button class="event-delete" type="button">삭제</button>
				</div>
			</li>
		</ol>
		<?php
		}
		?>
		</div> -->
	</main>
	<script src="js/event-list.js?v=1.000"></script>
</body>
</html>
