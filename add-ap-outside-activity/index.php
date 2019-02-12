<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

include_once $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>이벤트 생성</title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/add-ap-outside-activity.css" />
	<script src="/js/jquery.min.js"></script>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="add-ap-outside-activity-main">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/search-ap-module/search-ap-ui.html'; ?>
		<h1 class="typography-header">이벤트 추가</h1>
		<div class="action-button-container">
			<button type="button" class="ap-button-default add-single">추가</button>
			<button type="button" class="ap-button-default add-multiple">멀티 추가</button>
		</div>
		<form class="add-ap-outside-activity-form" action="add-ap-submit.php" method="post" accept-charset="utf-8">
			<table class="ap-table">
				<thead class="">
					<tr>
						<th class="">
							<span class="kind-display"></span>
						</th>
						<th class="item-col-nm">
							<span class="kind-display">이름</span>
						</th>
						<th class="item-col-oa">
							<span class="kind-display">시작일</span>
						</th>
						<th class="item-col-ia">
							<span class="kind-display">종료일</span>
						</th>
						<th class="item-col-tp">
							<span class="kind-display">분류</span>
						</th>
						<th class="item-col-dn">
							<span class="kind-display">표시명<br />(병원외출 사유)</span>
						</th>
						<th class="item-col-ot">
							<span class="kind-display">시작시간</span>
						</th>
						<th class="item-col-it">
							<span class="kind-display">종료시간</span>
						</th>
						<th class="item-col-nt">
							<span class="kind-display">비고<br />(병원이름)</span>
						</th>
					</tr>
				</thead>
				<tbody class="ap-table-body">
					<tr class="input-data-container">
						<td class="col item-col item-col-id">
							<button type="button" class="col-duplicate">복제</button>
							<!-- <span class="input-data-row-id" data-row-id="1">1</span> -->
						</td>
						<td class="col item-col item-col-nm">
							<button class="ap-name" type="button"></button>
							<input class="table-input ap-id" type="text" name="ap_id[]" required />
						</td>
						<td class="col item-col item-col-oa">
							<input class="table-input date-input date-input-out-at" type="text" name="out_at[]" required autocomplete="off" />
							<input id="all-day" class="all-day" type="checkbox" name="" tabindex="-1" />
							<label>하루종일</label>
						</td>
						<td class="col item-col item-col-ia">
							<input class="table-input date-input date-input-in-at" type="text" name="in_at[]" required autocomplete="off" />
							<input id="unknown-in-at" class="unknown-in-at" type="checkbox" name="" tabindex="-1" />
							<label>별명시</label>
						</td>
						<td class="col item-col item-col-tp">
							<!-- <input class="table-input" type="date" name="type[]" required /> -->
							<select class="table-input ap-select" name="type[]" required>
								<option selected disabled hidden value="0">분류</option>
								<?php
								$sql = "SELECT * FROM event_name ORDER BY sequence";
								$result = mysqli_query($conn, $sql);
								if (!$result) echo mysqli_error($conn);
								while ($row = mysqli_fetch_assoc($result)) {
								?>
								<option value="<?php echo $row['id']; ?>"><?php echo $row['event']; ?></option>
								<?php
								}
								?>
							</select>
						</td>
						<td class="col item-col item-col-dn">
							<input class="table-input input-display-name" type="text" name="display_name[]" required />
						</td>
						<td class="col item-col item-col-ot">
							<input class="table-input time-input out-time-input" type="text" name="out_time[]" placeholder="예) 09:00" />
						</td>
						<td class="col item-col item-col-it">
							<input class="table-input time-input in-time-input" type="text" name="in_time[]" placeholder="예) 11:00" />
						</td>
						<td class="col item-col item-col-nt">
							<input class="table-input note-input" type="text" name="note[]" />
						</td>
					</tr>
				</tbody>
			</table>
			<div class="submit-wrapper">
				<button type="submit" class="ap-button-default">완료</button>
			</div>
		</form>

		<div class="new-card-container" style="display:none;">
			<div class="card">
				<div class="delete cross-button">
					<div class="cross left-down"></div>
					<div class="cross right-down"></div>
				</div>
				<h1 class="title">CARD</h1>
				<div class="card-input-container">
					<select class="card-input ap-select" name="type[]" required>
						<option selected disabled hidden value="0">영외활동 종류</option>
						<?php
						$sql = "SELECT * FROM event_name ORDER BY sequence";
						$result = mysqli_query($conn, $sql);
						if (!$result) echo mysqli_error($conn);
						while ($row = mysqli_fetch_assoc($result)) {
						?>
						<option value="<?php echo $row['id']; ?>"><?php echo $row['event']; ?></option>
						<?php
						}
						?>
					</select>
					<div class="card-input name">이름</div>
					<input name="ap_id[]" type="hidden" class="card-input ap-id">
					<input name="out_at[]" type="text" class="date-input card-input out-at" placeholder="시작일">
					<input name="in_at[]" type="text" class="date-input card-input in-at" placeholder="종료일">
					<input display_name[] type="text" class="card-input display-name" placeholder="표시명(병원외출 사유)">
				</div>
			</div>
			<div class="add-card card">
				<div class="plus">
					<div class="cross-horizontal cross"></div>
					<div class="cross-vertical cross"></div>
				</div>
			</div>
		</div>
		
	</main>
	<script src="/js/globalscript.js"></script>
	<script src="js/add-ap-outside-activity.js?v=1.000"></script>
</body>
</html>
