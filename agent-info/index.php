<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$today = date('Y-m-d');

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>지휘요원 정보</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/agent-info.css" />
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="agent-info-main">
		<div class="current-agent-board">
			<!-- <?php
			echo $today.'<br />';
			// $agents = get_currently_serving_agent_list($today);
			$agents = get_all_agents();
			for ($i=0; $i < count($agents); $i++) { 
				echo $agents[$i]['name'].'<br />';
			}

			echo '<br />'.'get_agent_info_by_roll 함수 테스트'.'<br />';
			$date = '2018-12-12';
			$roll = 2;
			echo $date.' 의 '.$roll.' 지휘요원'.'<br />';
			$agent = get_agent_info_by_roll($roll, $date, true);
			echo $agent['name'];
			?> -->

			<div class="master top-wrapper">
				<div class="character">
					<div class="call">중대장</div>
					<div class="name"><?php echo get_agent_info_by_roll(7, $today)['name']; ?></div>
				</div>
				
			</div>

			<div class="govern top-wrapper">
				<div class="group">
					<div class="character">
						<div class="call">행정소대장</div>
						<div class="name special-name"><?php echo get_agent_info_by_roll(8, $today)['name']; ?></div>
					</div>
				</div>
				<div class="group">
					<div class="character">
						<div class="call">행정부소대장</div>
						<div class="name"><?php echo get_agent_info_by_roll(9, $today)['name']; ?></div>
					</div>
				</div>
			</div>

			<div class="platoon-container top-wrapper">
				<div class="platoon group">
					<div class="head">
						<div class="character">
							<div class="call">1소대장</div>
							<div class="name"><?php echo get_agent_info_by_roll(1, $today)['name']; ?></div>
						</div>
					</div>
					<div class="sub">
						<div class="character">
							<div class="call">1부소대장</div>
							<div class="name"><?php echo get_agent_info_by_roll(4, $today)['name']; ?></div>
						</div>
					</div>
				</div>
				<div class="platoon group">
					<div class="head">
						<div class="character">
							<div class="call">2소대장</div>
							<div class="name"><?php echo get_agent_info_by_roll(2, $today)['name']; ?></div>
						</div>
					</div>
					<div class="sub">
						<div class="character">
							<div class="call">2부소대장</div>
							<div class="name"><?php echo get_agent_info_by_roll(5, $today)['name']; ?></div>
						</div>
					</div>
				</div>
				<div class="platoon group">
					<div class="head">
						<div class="character">
							<div class="call">3소대장</div>
							<div class="name"><?php echo get_agent_info_by_roll(3, $today)['name']; ?></div>
						</div>
					</div>
					<div class="sub">
						<div class="character">
							<div class="call">3부소대장</div>
							<div class="name"><?php echo get_agent_info_by_roll(6, $today)['name']; ?></div>
						</div>
					</div>
				</div>
			</div>

			<?php

			
			
			?>
		</div>

		<div class="all-agents-list">
			<h1 class="header">지휘요원 목록</h1>
			<div class="members">
				<?php
				// $agents = get_agent_working_info($today);
				$agents = get_all_agents();
				foreach ($agents as $key => $agent) {
				?>
				<div class="person">
					<div class="name"><?php print get_agent_step_name($agent["step"]) . " " . $agent["name"]; ?></div>
				</div>
				<?php
				}
				?>
			</div>
		</div>
	</main>

	<script src="js/agent-info.js"></script>
	
</body>
</html>
