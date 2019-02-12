<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/php-module/database-api.php';

$today = date('Y-m-d');
if (isset($_GET['date'])) {
    $today = $_GET['date'];
}

$today_dot = date("Y. m. d.");

$agent_working_info = get_agent_working_info($today);
// var_dump($agent_working_info);

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Summary</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html';?>
	<link rel="stylesheet" type="text/css" href="css/summary.css" />
</head>

<body>
	<main id="summary-main">

		<div class="header">
			<div style="display:flex; align-items:center;">
				<span class="poltoday-logo"></span>
				<h1 class="corps-duty">Summary</h1>
			</div>
			<h1 class="date-header">
				<?php echo $today_dot . " (" . $day_name_kr[date('w', strtotime($today))] . ")"; ?>
			</h1>
		</div>


		<div class="box-container main-box">

			<div class="box-container whole-box first-box" style="transform: translateX(0%);">

				<div class="box-container column" style="flex:0.8;">

					<!-- <div class="box corps-duty" style="flex: 1;">
						<div class="box-title">
							<h1 class="aqua">경력</h1>
						</div>
						<div class="box-contents">
							휴 무
						</div>
					</div> -->

					<div class="box ap-info" style="flex: 2;">
						<div class="box-title">
							<h1 class="orange">인원 현황</h1>
						</div>
						<div class="box-contents center">
							<div>
								<div class="total">총원 <span class="placeholder"></span>명</div>
								<div class="platoon-container">
									<div class="platoon platoon-govern">
										<div class="place">본부소대</div>
										<h2 class="sub-title platoon-total">총원</h2>
										<div><span class="placeholder pt"></span>명</div>
										<h2 class="sub-title platoon-work">출동인원</h2>
										<div><span class="placeholder pw"></span>명</div>
									</div>
									<div class="platoon platoon-1">
										<div class="place">1소대</div>
										<h2 class="sub-title platoon-total">총원</h2>
										<div><span class="placeholder pt"></span>명</div>
										<h2 class="sub-title platoon-work">출동인원</h2>
										<div><span class="placeholder pw"></span>명</div>
									</div>
									<div class="platoon platoon-2">
										<div class="place">2소대</div>
										<h2 class="sub-title platoon-total">총원</h2>
										<div><span class="placeholder pt"></span>명</div>
										<h2 class="sub-title platoon-work">출동인원</h2>
										<div><span class="placeholder pw"></span>명</div>
									</div>
									<div class="platoon platoon-3">
										<div class="place">3소대</div>
										<h2 class="sub-title platoon-total">총원</h2>
										<div><span class="placeholder pt"></span>명</div>
										<h2 class="sub-title platoon-work">출동인원</h2>
										<div><span class="placeholder pw"></span>명</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>

					<div class="box autonomous" style="flex: 1;">
						<div class="box-title">
							<h1 class="green-blue">무기고/식기</h1>
						</div>
						<div class="box-contents center">
							<div style="
							display: flex;
							justify-content: space-around;
							">
								<div class="platoon-1"></div>
								<div class="platoon-2"></div>
								<div class="platoon-3"></div>
							</div>
						</div>
					</div>

				</div>



				<div class="box-container column">
					<div class="box absent" style="flex: 2;">
						<div class="box-title">
							<h1 class="red">사고자</h1>
						</div>
						<div class="box-contents">
							<div class="platoon platoon-0">
								<div class="place">본부소대</div>
								<div class="placeholder"></div>
							</div>
							<div class="platoon platoon-1">
								<div class="place">1소대</div>
								<div class="placeholder"></div>
							</div>
							<div class="platoon platoon-2">
								<div class="place">2소대</div>
								<div class="placeholder"></div>
							</div>
							<div class="platoon platoon-3">
								<div class="place">3소대</div>
								<div class="placeholder"></div>
							</div>
						</div>
					</div>
					<div class="box remain" style="flex: 1.3; position: absolute; left: 0; top: 0; width: calc(100% - 2rem); height: calc(100% - 2rem); opacity: 0;">
						<div class="box-title">
							<h1 class="purple">잔류자</h1>
						</div>
						<div class="box-contents">
							<div class="platoon platoon-0">
								<div class="place">본부소대</div>
								<div class="placeholder"></div>
							</div>
							<div class="platoon platoon-1">
								<div class="place">1소대</div>
								<div class="placeholder"></div>
							</div>
							<div class="platoon platoon-2">
								<div class="place">2소대</div>
								<div class="placeholder"></div>
							</div>
							<div class="platoon platoon-3">
								<div class="place">3소대</div>
								<div class="placeholder"></div>
							</div>
						</div>
					</div>
				</div>

				<div class="box-container" style="flex: .7;">

					<div class="box-container today-work column">
						<div class="box duty">
							<div class="box-title">
								<h1 class="blue">35중대 당직 근무</h1>
							</div>
							<div class="box-contents center">
								<div>
									<div class="first"></div>
									<div class="second"> </div>
								</div>
							</div>
						</div>
						<div class="box tddj" style="flex:1;">
							<div class="box-title">
								<h1 class="green">3단 당직근무</h1>
							</div>
							<div class="box-contents center">
								<div>
									<div class="first"></div>
									<div class="second"></div>
								</div>
							</div>
						</div>
					</div>

					<div class="box schedule particle" style="flex:1.9;">
						<div class="box-title">
							<h1 class="pink">주요 일정</h1>
						</div>
						<div class="box-contents">
							<div class="placeholder"></div>
						</div>
					</div>

				</div>


			</div>

			<!-- <div class="box-container whole-box second-box" style="transform: translateX(100%);">
				두번째 페이지
			</div> -->
			
		</div>


	</main>

	<script src="/js/TweenMax.min.js"></script>
	<script src="/js/anime.min.js"></script>
	<script src="js/summary.js"></script>
	<script src="js/summary-first-page.js"></script>
	<script src="js/summary-second-page.js"></script>
	<script src="js/switch-boxes.js"></script>


</body>

</html>