<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

// 인증되지 않은 접속
if (!isset($_SESSION['govern_verified']) || !$_SESSION['govern_verified']) {

	header('Location: /home');

}

?>
<!DOCTYPE html>
<html>

<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>PolToday</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/transmission.css?v=1.010" />
</head>

<body id="transmission-body">
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="transmission-main">
		<h1 class="board-title">인수인계 보드</h1>
		
		<div class="transmission-board">

			<?php $govern_aps = get_today_govern_fair(); ?>

			<!-- <div class="member all">
				<div class="name">모두에게</div>
				<div class="add">
					<button class="add-transmit">모두에게 전달</button>
					<div class="add-content hidden">
						<textarea class="input-area" placeholder="전달 내용"></textarea>
						<select class="transmitter" name="" id="">
							<option value="0" selected disabled hidden>전달자</option>
							<?php
							foreach ($govern_aps as $key => $ap) {
							?>
							<option value="<?php echo $ap['id']; ?>">전달자 - <?php echo $ap['name']; ?></option>
							<?php
							}
							?>
						</select>
						<div class="button-wrapper">
							<button class="cancel">취소</button>
							<button class="done">인계하기</button>
						</div>
					</div>
				</div>
				<div class="transmit-item-container">
					<div class="to-do section">
						<h2 class="title">전달 중</h2>
						<div class="item-container"></div>
					</div>
					<div class="done section">
						<h2 class="title">모두가 다 확인함</h2>
						<div class="item-container"></div>
					</div>
				</div>
			</div> -->

			<?php
			
			foreach ($govern_aps as $key => $ap) {

				$current_member_ap_id = $ap['id'];

			?>

			<div class="member" data-ap-id="<?php echo $ap['id']; ?>">
				<div class="name"><?php echo $ap['name']; ?><span class="left-count hidden">0</span></div>
				<div class="add">
					<button class="add-transmit">새로운 인수인계 또는 해야 할 일</button>
					<div class="add-content hidden">
						<textarea class="input-area" placeholder="인수인계 내용"></textarea>
						<select class="transmitter select" name="" id="">
							<option value="0" selected disabled hidden>인계자</option>
							<?php
							foreach ($govern_aps as $key => $ap) {
							?>
							<option value="<?php echo $ap['id']; ?>">인계자 - <?php echo $ap['name']; ?></option>
							<?php
							}
							?>
						</select>
						<form class="transmit-type">
							<div class="type-option-wrapper"><input class="basic option" type="radio" value="1" name="type-option" checked="checked"></div>
							<!-- <div class="type-option-wrapper"><input class="alert option" type="radio" value="2" name="type-option"></div> -->
							<div class="type-option-wrapper"><input class="share option" type="radio" value="3" name="type-option"></div>
						</form>
						<div class="select-container hidden">
							<div class="select-all-wrapper">
								<input class="checkbox" type="checkbox">
								<span class="text">전체공유</span>
							</div>
							<div class="select-wrapper">
								<select class="shared-with select" name="" id="">
									<option value="0" selected disabled hidden>공유자 추가</option>
									<?php
									foreach ($govern_aps as $key => $ap) {
										if ($ap['id'] == $current_member_ap_id) {
											continue;
										}
									?>
									<option value="<?php echo $ap['id']; ?>">공유자 - <?php echo $ap['name']; ?></option>
									<?php
									}
									?>
								</select>
								<button class="shared-delete">삭제</button>
							</div>
						</div>
						
						
						<div class="button-wrapper">
							<button class="cancel">취소</button>
							<button class="done">인계하기</button>
						</div>
					</div>
				</div>
				<div class="transmit-item-container-wrapper">
					<!-- <div class="shadow"></div> -->
					<div class="transmit-item-container">
						<div class="to-do section">
							<h2 class="title">진행중</h2>
							<div class="item-container"></div>
						</div>
						<div class="done section">
							<h2 class="title">완료됨</h2>
							<div class="item-container"></div>
						</div>
					</div>
				</div>
				
			</div>

			<?php

			}

			?>
		</div>
	</main>
	<script src="js/transmission-all.js?v=1.000"></script>
	<script src="js/transmission.js?v=1.011"></script>
</body>