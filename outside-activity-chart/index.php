<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');
// $today = "2018-03-01";

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}



?>

<!DOCTYPE html>
<html>
<head>
	<title>영외활동계획표</title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="/css/table.css" />
	<link rel="stylesheet" type="text/css" href="css/outside-activity-chart.css?v=1.001" />
	<link rel="stylesheet" type="text/css" href="css/minigame.css?v=1.001" />
	<script src="/js/jquery.min.js"></script>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="outside-activity-chart-main">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/search-ap-module/search-ap-ui.html'; ?>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/edit-event-module/edit-event-ui.php'; ?>

		<div class="action-bubble">
			<div class="ab-background">
				<button type="button" class="ab-delete">삭제</button>
				<button type="button" class="ab-edit">수정</button>
			</div>
			<div class="ab-arrow">

			</div>
		</div>

		<div class="add-activity-wrapper hidden">
			<div class="add-activity">
				<form class="add-activity-form">

					<div class="header-wrapper">
						<h3>새 영외활동 등록</h3>
						<h2 class="interval-display"></h2>
					</div>

					<div class="ap-input ap-input-placeholder"></div>

					<input class="out-at" type="hidden" name="out_at[]" />
					<input class="in-at" type="hidden" name="in_at[]">

					<input class="ap-id ap-input" type="hidden" name="ap_id[]" required />

					<select class="type ap-input" name="type[]" required>
						<option selected disabled hidden>분류</option>
						<option value="1">정기휴가</option>
						<option value="2">정기외박</option>
						<option value="3">특별외박</option>
						<option value="4">특별외출</option>
						<option value="5">청원휴가</option>
						<option value="6">병가</option>
						<option value="7">입원</option>
						<option value="8">교육</option>
						<option value="9">병원외출</option>
					</select>
					<input class="display-name ap-input" type="text" name="display_name[]" placeholder="표시명" required />
					<div class="button-container">
						<button type="submit" class="done">완료</button>
						<button type="button" class="cancel">취소</button>
					</div>
				</form>
			</div>
			<div class="add-activity-background">

			</div>
		</div>

		<!--  -->
		<div class="chart-wrapper">
			<div class="date-change">
				<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
					<button class="date-change-button" type="submit">< 이전 달</button>
					<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' - 1 month')); ?>" />
				</form>
				<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
					<button class="date-change-button" type="submit">오늘</button>
				</form>
				<form class="date-change-button-wrapper" action="" method="get" accept-charset="utf-8">
					<button class="date-change-button" type="submit">다음 달 ></button>
					<input type="hidden" name="date" value="<?php echo date('Y-m-d', strtotime($today . ' + 1 month')); ?>" />
				</form>
			</div>
			<!-- <input id="chart-width-controller" type="range" min="50" max="100" value="100" step="1" /> -->

			
			<div class="section-to-print">
				<h1 class="typography-header"><?php echo date('Y', strtotime($today))."년 " . date('n', strtotime($today))."월"; ?> 영외활동계획표</h1>
				<div class="whole-table" data-date="<?php echo $today; ?>">

				</div>
			</div>

			

			<!-- <?php
			if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
			?>
			<div class="password-window">
				<input class="password-input" type="password" name="password" />
			</div>
			<?php
			}
			?> -->
		</div>

		<!-- <div id="leaderboard-wrapper">
			<div id="leaderboard">
				<h1>Top 10</h1>
				<div id="score-container"></div>
			</div>
		</div> -->

	</main>
	<script src="js/outside-activity-chart-view.js?v=1.003"></script>
	<?php
	if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
	?>
	<script src="js/outside-activity-chart.js?v=1.005"></script>
	<!-- <script src="js/minigame.js"></script> -->
	<?php
	}
	?>
</body>
</html>
