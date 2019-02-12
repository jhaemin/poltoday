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
        <title>특별외출/특별외박</title>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
        <link rel="stylesheet" href="special-coupon.css" />
    </head>
    <body id="coupon-body">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/search-ap-module/search-ap-ui.html'; ?>
        <?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
        <div class="add-coupon">
			<h1 class="typography-header">특출/특박 추가</h1>
			<div class="action-button-container">
				<button type="button" class="ap-button-default add-single">추가</button>
				<button type="button" class="ap-button-default add-multiple">멀티 추가</button>
			</div>
			<form class="" action="" method="post">
				<div class="add-coupon-container">
					<div class="add-coupon-item">
						<div class="add-coupon-item-wrapper">
							<div class="coupon-detail ap-name">
								<input class="ap-id-input" type="hidden" name="ap-id[]" value="" />
								<div class="ap-name-input">대원 선택</div>
							</div>
							<div class="coupon-detail coupon-type">
								<select class="" name="type[]">
									<option value="특별외출">특별외출</option>
									<option value="특별외박">특별외박</option>
								</select>
							</div>
							<div class="coupon-detail coupon-name">
								<input type="text" name="coupon_name[]" value="" placeholder="특출/특박 이름" />
							</div>
							<div class="coupon-detail get-date">
								<input class="date-input" type="text" name="get_date[]" value="" placeholder="받은 날짜" />
							</div>
							<div class="coupon-detail expiry-date">
								<input class="date-input" type="text" name="expiry_date[]" value="" placeholder="만료 날짜" />
							</div>
							<div class="coupon-detail">
								<input type="text" name="length[]" value="" placeholder="기간" />
							</div>
						</div>
					</div>
				</div>
				<button type="submit" class="ap-button-default">완료</button>
			</form>
        </div>
        <div class="coupon-list">
            <div class="coupon-item-container">
                
            </div>
        </div>
		<script src="special-coupon.js"></script>
    </body>
</html>
