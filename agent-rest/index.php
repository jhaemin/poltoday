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
?>

<!DOCTYPE html>
<html lang="ko" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>지휘요원 이벤트</title>
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
		<link rel="stylesheet" href="css/agent-rest.css" />
    </head>
    <body>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
        <main id="agent-rest-main">
						<h1 class="typography-header" style="font-weight:900;">지휘요원 이벤트</h1>
						<h3 style="margin-bottom:10px;font-weight:800;">이벤트 추가 시 유의사항</h3>
			<p style="line-height:1.4;font-weight:500;">이벤트를 추가해도 당직근무 편성표는 원래대로 표시됩니다.</p>
			<p style="line-height:1.4;font-weight:500;">당번, 일근, 비번 이벤트는 기존 당직근무 편성 근무를 덮어씁니다.</p>
			<p style="line-height:1.4;font-weight:500;">비선탑 이벤트는 일근 지휘요원들이 서로 선탑<->비선탑을 변경할 때만 사용하세요.</p>
			<p style="line-height:1.4;font-weight:500;">기타 이벤트는 휴무/연가/비번과 같이 사고자로 처리되는 이벤트입니다.</p>
			<form class="new-events-container">
				<div class="new-event-item">
					<input class="agent-id" type="hidden" name="agent_id[]" value="" >
					<div class="agent-name nei-input">지휘요원 선택</div>
					<input class="event-at nei-input" type="date" name="event_at[]" value="" required>
					<select class="event-type nei-input" name="event_type[]" required>
						<?php
						$sql = "SELECT * FROM agent_event_name";
						$result = mysqli_query($conn, $sql);
						if (!$result) { echo mysqli_error($conn); }
						while ($row = mysqli_fetch_assoc($result)) {
						?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
						<?php
						}
						?>
					</select>
					<input type="text" class="etc-event-name nei-input" name="etc_event_name[]" placeholder="기타 이벤트명">
				</div>
				<div class="arm-button-container">
					<button class="arm-add-btn" type="submit">추가</button>
				</div>
			</form>

			<div class="recent-agent-event-list">
				<p>가장 최근 이벤트 50개입니다.</p>
				<?php
				$sql = "SELECT * FROM agent_event ORDER BY event_at DESC LIMIT 50";
				$result = mysqli_query($conn, $sql);
				if (!$result) {
					echo mysqli_error($conn);
				}
				while ($row = mysqli_fetch_assoc($result)) {
				?>
				<div class="item" data-event-id="<?php echo $row['id']; ?>">
					<button class="delete" type="button">삭제</button>
					<?php
					
					echo $row['event_at'] . ' ' . get_agent_info_by_id($row['agent_id'], $today)['name'].' ';

					if ($row['event_type'] == 9) {
						echo $row['etc_event_name'];
					} else {
						echo get_agent_event_name($row['event_type']);
					}
					
					?>
				</div>
				<?php
				}
				?>
			</div>
        </main>
		<?php include $_SERVER['DOCUMENT_ROOT'].'/modules/search-agent-module/search-agent-ui.php'; ?>
		<script src="js/agent-rest.js?v=1.000"></script>
    </body>
</html>
