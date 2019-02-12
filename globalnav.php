<?php

$path = $_SERVER['REQUEST_URI'];
$tokens = explode('/', $path);
$last_path = $tokens[sizeof($tokens) - 2];

?>
<nav class="globalnav">
	<ul class="gn-container">
		<li class="gn-item-wrapper">
			<div class="gn-item">
				<a href="/home" class="gn-link home <?php if($last_path == "home") echo "current"; ?>" title=""><br><br><br>홈</a>
			</div>
		</li>
		
		<li class="gn-item-wrapper">
			<div class="gn-item">
				<span class="gn-link agent"><br><br><br>지휘요원</span>
			</div>
			<div class="gn-item-dropdown hidden">
				<ol class="dropdown-list">
					<!-- <li class="dropdown-item <?php if($last_path == "ap-info") echo "current"; ?>">
						<a href="/ap-info" class="" title="대원정보">지휘요원 정보</a>
					</li> -->
					<!-- <li class="dropdown-item <?php if($last_path == "add-ap") echo "current"; ?>">
						<a href="/add-ap" class="" title="대원등록">지휘요원 등록</a>
					</li> -->
					
					<?php
					if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
					?>
					<li class="dropdown-item beta <?php if($last_path == "agent-info") echo "current"; ?>">
						<a href="/agent-info" title="">지휘요원 정보</a>
					</li>
					<li class="dropdown-item <?php if($last_path == "agent-continue") echo "current"; ?>">
						<a href="/agent-continue" title="">당직관 인수인계</a>
					</li>
					<?php
					}
					?>
					<li class="dropdown-item <?php if($last_path == "duty") echo "current"; ?>">
						<a href="/duty" title="">당직근무 편성</a>
					</li>
					
				</ol>
			</div>
		</li>

		<li class="gn-item-wrapper">
			<div class="gn-item">
				<span class="gn-link ap"><br><br><br>의무경찰</span>
			</div>
			<div class="gn-item-dropdown hidden">
				<ol class="dropdown-list">
					<?php
					if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
					?>
					<li class="dropdown-item <?php if($last_path == "ap-info") echo "current"; ?>">
						<a href="/ap-info" class="" title="대원정보">대원 정보</a>
					</li>
					<?php
					}
					?>
					<?php
					if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
					?>
					<li class="dropdown-item <?php if($last_path == "add-ap") echo "current"; ?>">
						<a href="/add-ap" class="" title="대원등록">신병 등록</a>
					</li>
					<!-- <li class="dropdown-item beta <?php if($last_path == "special-coupon") echo "current"; ?>">
						<a href="/special-coupon">특별외출/특별외박 관리</a>
					</li> -->
					<?php
					}
					?>
					<li class="dropdown-item update <?php if ($last_path == "milage") echo "current"; ?>">
						<a href="/milage">마일리지</a>
					</li>
				</ol>
			</div>
		</li>
		<li class="gn-item-wrapper">
			<div class="gn-item">
				<span class="gn-link event"><br><br><br>이벤트</span>
			</div>
			<div class="gn-item-dropdown hidden">
				<ol class="dropdown-list">
					<?php
					if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
					?>
					<li class="dropdown-item <?php if($last_path == "agent-rest") echo "current"; ?>">
						<a href="/agent-rest" title="">지휘요원 이벤트 관리</a>
					</li>
					<!-- <li class="dropdown-item beta <?php if($last_path == "calendar") echo "current"; ?>">
						<a href="/calendar" title="">달력</a>
					</li> -->
					<li class="dropdown-item <?php if($last_path == "add-ap-outside-activity") echo "current"; ?>">
						<a href="/add-ap-outside-activity" title="">새로운 대원 이벤트</a>
					</li>
					<li class="dropdown-item <?php if($last_path == "event-list") echo "current"; ?>">
						<a href="/event-list" title="">대원 이벤트 관리</a>
					</li>
					<?php
					}
					?>
					<li class="dropdown-item <?php if($last_path == "outside-activity-chart") echo "current"; ?>">
						<a href="/outside-activity-chart" title="">영외활동 계획표</a>
					</li>
					<?php
					if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
					?>
					<li class="dropdown-item <?php if($last_path == "outside-activity-report") echo "current"; ?>">
						<a href="/outside-activity-report" title="">영외활동 보고</a>
					</li>
					<?php
					}
					?>
				</ol>
			</div>
		</li>
		<?php
		if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
		?>
		<li class="gn-item-wrapper">
			<div class="gn-item">
				<span class="gn-link jb"><br><br><br>전반</span>
			</div>
			<div class="gn-item-dropdown hidden">
				<ol class="dropdown-list">
					<li class="dropdown-item <?php if($last_path == "autonomous") echo "current"; ?>">
						<a href="/autonomous" title="">무기고/식기 설정</a>
					</li>
					<li class="dropdown-item<?php if($last_path == "absent-list") echo " current"; ?>">
						<a href="/absent-list" title="">사고자리스트</a>
					</li>
					<li class="dropdown-item<?php if($last_path == "daily-information") echo " current"; ?>">
						<a href="/daily-information" title="">일일업무보고</a>
					</li>
					<li class="dropdown-item<?php if($last_path == "duty-journal") echo " current"; ?>">
						<a href="/duty-journal" title="">근무일지</a>
					</li>
					<!-- <li class="dropdown-item<?php if($last_path == "new-member-report") echo " current"; ?>">
						<a href="/new-member-report" title="">소대 인원 점검부</a>
					</li> -->
					<!-- <li class="dropdown-item beta<?php if($last_path == "leave-day") echo " current"; ?>">
						<a href="/leave-day" title="">금일 외출 현황</a>
					</li> -->
					<li class="dropdown-item<?php if($last_path == "alcohol") echo " current"; ?>">
						<a href="/alcohol" title="">음주운전 의무위반 예방 체크리스트</a>
					</li>
					<li class="dropdown-item <?php if($last_path == "summary-set") echo "current"; ?>">
						<a href="/summary-set" title="">써머리 설정</a>
					</li>
					<li class="dropdown-item <?php if($last_path == "daily-working-info") echo " current"; ?>">
						<a href="/daily-working-info" title="">경력일보 출력 툴</a>
					</li>
				</ol>
			</div>
		</li>
		<?php
		}
		?>


		<?php
		if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
		?>
		<li class="gn-item-wrapper">
			<div class="gn-item">
				<button class="gn-link power-on" title=""><br><br><br>전반모드</button>
			</div>
		</li>
		<?php
		}
		?>

		<!-- <?php
		if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
		?>
		<li class="gn-item-wrapper">
			<a href="/a-a-x-z-y-76-1-v.php">
				<div class="gn-item">
					<button class="gn-link" title="">인증해제</button>
				</div>
			</a>
		</li>
		<?php
		}
		?> -->

		<?php
		if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
		?>
		<li class="gn-item-wrapper">
			<div class="gn-item">
				<span class="gn-link manual"><br><br><br>매뉴얼</span>
			</div>
			<div class="gn-item-dropdown hidden">
				<ol class="dropdown-list">
					<li class="dropdown-item new<?php if($last_path == "manual/armor.php") echo " current"; ?>">
						<a href="/manual/armor.php" title="">장비</a>
					</li>
				</ol>
			</div>
		</li>
		<?php
		}
		?>
		

	</ul>
	<script src="/js/globalscript.js" /></script>
</nav>
