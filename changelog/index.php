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
	<title>PolToday</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="changelog.css?v=1.007" />
</head>
<body id="changelog-body">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/globalnav.php'; ?>
	<main id="changelog-main">

		<div id="logs">
			<h1>업데이트</h1>
			<section class="log-section" id="update-20181220">
				<h2>1.6.3 (2018-12-20)</h2>
				<ul>
					<li>패스워드</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181212">
				<h2>1.6.2 (2018-12-12)</h2>
				<ul>
					<li>지휘요원 비선탑 이벤트 항목 추가, 일일업무보고 및 근무일지에서 별도의 비선탑 이벤트 표시 방식 개선</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181207-2">
				<h2>1.6.1 (2018-12-07)</h2>
				<ul>
					<li>사고자리스트, 일일업무보고, 근무일지에서 별명시로 설정된 이벤트가 전역일 이후에도 여전히 표시되는 문제 수정</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181207-1">
				<h2>1.6 (2018-12-07)</h2>
				<ul>
					<li>인수인계 보드의 공지 기능을 삭제하고 홈 공지사항 기능으로 대체됩니다.</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181203">
				<h2>1.5.3 (2018-12-03)</h2>
				<ul>
					<li>인증 유지 시간 10시간으로 확장 (10시간 이내에 새로운 동작 감지 시 10시간 재연장)</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181201">
				<h2>1.5.2 (2018-12-01)</h2>
				<ul>
					<li>영외활동 계획표에서 별명시 이벤트가 잘못 표시되는 문제 수정</li>
					<li>이제 영외활동 계획표에서 ESC 키로 팝업창을 닫을 수 있습니다.</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181129">
				<h2>1.5.1 (2018-11-29)</h2>
				<ul>
					<li>마일리지 기록 기능 추가</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181101">
				<h2>1.5 (2018-11-01)</h2>
				<ul>
					<li>새로운 기능: 폴투데이 써머리</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181012">
				<h2>1.4 (2018-10-12)</h2>
				<ul>
					<li>새로운 기능: 경력일보 출력 툴</li>
				</ul>
			</section>
			<section class="log-section" id="update-20181003">
				<h2>1.3.4 (2018-10-03)</h2>
				<ul>
					<li>이제 인수인계 보드에서 아래로 스크롤 시 완료된 항목이 10개씩 더 로드됩니다.</li>
					<li>인수인계 보드에 '전체공유' 기능 추가</li>
				</ul>
			</section>
			<section class="log-section" id="update-20180917">
				<h2>1.3.3 (2018-09-17)</h2>
				<ul>
					<li>지휘요원 기타 이벤트 기능 추가</li>
				</ul>
			</section>
			<section class="log-section" id="update-20180904">
				<h2>1.3.2 (2018-09-04)</h2>
				<ul>
					<li>인수인계 보드 공지 기능 업데이트</li>
				</ul>
			</section>
			<section class="log-section" id="update-20180831">
				<h2>1.3.1 (2018-08-31)</h2>
				<ul>
					<li>인수인계 보드 공유 기능 업데이트</li>
					<li>홈에 인수인계 현황 표시</li>
				</ul>
			</section>
			<section class="log-section" id="update-20180831">
				<h2>1.3 (2018-08-31)</h2>
				<ul>
					<li><a href="/transmission">인수인계 보드 기능 추가</a></li>
				</ul>
			</section>
			<section class="log-section" id="update-20180828">
				<h2>1.2.1 (2018-08-28)</h2>
				<ul>
					<li>영외활동 계획표 미니게임 패치</li>
				</ul>
			</section>
			<section class="log-section" id="update-20180827">
				<h2>1.2 (2018-08-27)</h2>
				<ul>
					<li>대원정보 수정모드 추가</li>
					<li>코멘트 기능 추가</li>
					<li>영외활동 계획표 미니게임</li>
				</ul>
			</section>
			<section class="log-section" id="update-20180827">
				<h2>1.1 (2018-06-03)</h2>
				<ul>
					<li>근무일지(베타)</li>
					<li>일일업무보고</li>
					<li>금일외출현황(베타)</li>
					<li>음주운전 의무위반 예방 체크리스트</li>
					<li>지휘요원 이벤트</li>
					<li>당직근무 편성</li>
					<li>당직근무 인수인계</li>
				</ul>
			</section>
			<section class="log-section" id="update-20180301">
				<h2>1.0 (2018-03-01)</h2>
			</section>
		</div>


		<?php
		if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
		?>

		<!-- <div id="comments">

			<h1>실시간 코멘트</h1>
			<div class="input-section">
				<input type="text" id="name-input" class="cmt-input" placeholder="이름(실명 추천)">
				<input id="comment-input" class="cmt-input" placeholder="내용(욕설 금지)">
			</div>
			
			<div id="comments-list"></div>

		</div> -->

		<?php
		}
		?>

		

	</main>

	<script src="changelog.js?v=1.002"></script>
</body>