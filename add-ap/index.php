<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/php-module/database-api.php';

$today = date('Y-m-d');

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>대원 등록</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/add-ap.css" />
	<script src="/js/jquery.min.js"></script>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="add-ap-main">
		<h1 class="typography-header">대원 등록</h1>
		<div class="action-button-container">
			<button type="button" class="ap-button-default add-single">추가</button>
			<button type="button" class="ap-button-default add-multiple">멀티 추가</button>
		</div>
		<form class="add-ap-form" action="add-ap-submit.php" method="post" accept-charset="utf-8">
			<table class="ap-table">
				<tr class="input-kind-container input-row input-kind-row">
					<th class="col item-col-id">
						<span class="kind-display"></span>
					</th>
					<th class="col item-col-nm">
						<span class="kind-display">이름</span>
					</th>
					<th class="col item-col-pn">
						<span class="kind-display">휴대폰 번호</span>
					</th>
					<th class="col item-col-ea">
						<span class="kind-display">입대일</span>
					</th>
					<th class="col item-col-ta">
						<span class="kind-display">전입일</span>
					</th>
					<th class="col item-col-da">
						<span class="kind-display">전역일</span>
					</th>
					<th class="col item-col-bd">
						<span class="kind-display">생일</span>
					</th>
					<th class="col item-col-lv">
						<span class="kind-display">기수</span>
					</th>
					<th class="col item-col-pt">
						<span class="kind-display">소대</span>
					</th>
				</tr>
				<tbody class="input-data-table">
					<tr class="input-data-container input-row input-data-row">
						<td class="col col-0 col-0 item-col item-col-0 item-col-id">
							<!-- <span class="input-data-row-id" data-row-id="1">1</span> -->
						</td>
						<td class="col item-col item-col-nm">
							<input class="table-input" type="text" name="name[]" required />
						</td>
						<td class="col item-col item-col-pn">
							<input class="table-input phone-number-input" type="text" name="phone_number[]" />
						</td>
						<td class="col item-col item-col-ea">
							<input class="table-input date-input" type="text" name="enroll_at[]" required />
						</td>
						<td class="col item-col item-col-ta">
							<input class="table-input date-input" type="text" name="transfer_at[]" />
						</td>
						<td class="col item-col item-col-da">
							<input class="table-input date-input" type="text" name="discharge_at[]" />
						</td>
						<td class="col item-col item-col-bd">
							<input class="table-input date-input" type="text" name="birthday[]" />
						</td>
						<td class="col item-col item-col-lv">
							<input class="table-input only-number-input" type="text" name="level[]" required />
						</td>
						<td class="col item-col item-col-pt">
							<select class="table-input table-select" name="platoon[]" required>
								<option selected disabled hidden>소대</option>
								<option value="1">1소대</option>
								<option value="2">2소대</option>
								<option value="3">3소대</option>
								<option value="0">본부소대</option>
							</select>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="submit-wrapper">
				<button type="submit" class="ap-button-default">완료</button>
			</div>
		</form>
	</main>
	<script src="/js/globalscript.js"></script>
	<script src="js/add-ap.js"></script>
</body>
</html>