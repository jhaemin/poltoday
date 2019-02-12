<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

if (!isset($_GET['ap_id'])) {
	header("Location: /ap-info");
}

$ap_id = $_GET['ap_id'];

$ap = get_ap_info($ap_id);

?>

<!DOCTYPE html>
<html>
<head>
	<title>프로필</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/profile.css" />
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="profile-main">
		<div class="information" data-ap-id="<?php echo $ap_id; ?>">
			<div class="name"><?php echo $ap['name']; ?></div>
			<div class="level"><?php echo $ap['level'] . "기"; ?></div>
			<div class="platoon">
				<input class="date-input" type="text" name="" placeholder="날짜" />
				<ol class="platoon-list">
					<li class="platoon-item click-animation <?php echo $ap['platoon'] == 1 ? 'selected' : ""; ?>" data-platoon-id="1"><?php echo get_platoon_name(1); ?></li>
					<li class="platoon-item click-animation <?php echo $ap['platoon'] == 2 ? 'selected' : ""; ?>" data-platoon-id="2"><?php echo get_platoon_name(2); ?></li>
					<li class="platoon-item click-animation <?php echo $ap['platoon'] == 3 ? 'selected' : ""; ?>" data-platoon-id="3"><?php echo get_platoon_name(3); ?></li>
					<li class="platoon-item click-animation <?php echo $ap['platoon'] == 0 ? 'selected' : ""; ?>" data-platoon-id="0"><?php echo get_platoon_name(0); ?></li>
				</ol>
			</div>
			<div class="roll">
				<input class="date-input" type="text" name="" placeholder="날짜" />
				<ol class="roll-list">
					<li class="roll-item click-animation <?php echo $ap['roll'] == 1 ? 'selected' : ""; ?>" data-roll-id="1"><?php echo get_roll_name(1); ?></li>
					<li class="roll-item click-animation <?php echo $ap['roll'] == 2 ? 'selected' : ""; ?>" data-roll-id="2"><?php echo get_roll_name(2); ?></li>
					<li class="roll-item click-animation <?php echo $ap['roll'] == 3 ? 'selected' : ""; ?>" data-roll-id="3"><?php echo get_roll_name(3); ?></li>
					<li class="roll-item click-animation <?php echo $ap['roll'] == 4 ? 'selected' : ""; ?>" data-roll-id="4"><?php echo get_roll_name(4); ?></li>
				</ol>
				<div class="roll-change-history">
					<ol class="rch-list">
						<?php

						$sql = "SELECT * FROM ap_info_change_event WHERE ap_id='$ap_id' ORDER BY changed_at DESC, id DESC";
						$result = mysqli_query($conn, $sql);
						echo !$result ? mysqli_error($conn) : '';

						while ($row = mysqli_fetch_assoc($result)) {
						?>
						<li class="rch-item"><?php
							echo $row['changed_at'] . " ";
							$text = "";
							if ($row['type'] == 'platoon') {
								$text = get_platoon_name($row['from_val'])."에서 ".get_platoon_name($row['to_val'])."로 이동했습니다.";
							} else if ($row['type'] == 'roll') {
								$text = get_roll_name($row['from_val'])."에서 ".get_roll_name($row['to_val'])."(으)로 바뀌었습니다.";
							} else if ($row['type'] == 'moved_out') {
								$text = "전출나갔습니다.";
							}
							echo $text;
						?></li>
						<?php
						}

						?>
					</ol>
				</div>
				<div class="move-out">
					<?php
					if (get_ap_info($ap_id)['moved_out']) {
					?>
					<span>전출 나간 대원입니다.</span>
					<?php
					} else {
					?>
					<input class="date-input mo-date-input" type="text" name="" placeholder="날짜" />
					<button class="move-out-btn" type="button">전출</button>
					<?php
					}
					?>
				</div>

				<div class="personal-information">
					
				</div>
			</div>
		</div>
	</main>

	<script src="js/profile.js"></script>
</body>
</html>
