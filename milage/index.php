<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/php-module/database-api.php';



?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>마일리지</title>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
		<link rel="stylesheet" href="css/milage.css?v=1.000" />
	</head>
	<body>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/globalnav.php'; ?>

		<main id="milage-main">

			<div id="milage">
			
				<h1 class="milage-title"><span class="coin"></span>마일리지</h1>
			
				<?php
				 
				$milage_array = get_currently_serving_member();
			
				for ($i = 0; $i < sizeof($milage_array); $i++) {
			
				?>
					<div class="ap-wrapper">
						<div class="ap" data-ap-id="<?php echo $milage_array[$i]['id']; ?>">
			
			
							<?php
			
							$user_id = $milage_array[$i]['id'];
			
							$total_milage = $milage_array[$i]['milage'];
			
							$go_out_count = $milage_array[$i]['milage_go_out'];
							$out_sleep_count = $milage_array[$i]['milage_out_sleep'];
			
							$go_out_cost = 10;
							$out_sleep_cost = 15;
			
							$usable_milage = $total_milage - ($go_out_cost * $go_out_count + $out_sleep_cost * $out_sleep_count);
			
							?>
			
							<div class="section name"><?php echo $milage_array[$i]['name']; ?></div>
							<div class="section milage-point">
								<div class="minus">-</div>
								<div class="data"><?php echo $usable_milage; ?></div>
								<div class="plus">+</div>
							</div>
			
							 
			
							<div class="section go-out">
								<div class="go-out-title">외출 (10점)</div>
								<div class="go-out-count">
									<div class="minus">-</div>
									<div class="count-num"><?php echo $go_out_count; ?></div>
									<div class="plus">+</div>
								</div>
							</div>
							<div class="section out-sleep">
								<div class="out-sleep-title">외박 (15점)</div>
								<div class="out-sleep-count">
									<div class="minus">-</div>
									<div class="count-num"><?php echo $out_sleep_count; ?></div>
									<div class="plus">+</div>
								</div>
							</div>
						</div>
					</div>
				<?php
				 
				}
			
				?>
			
			</div>

			<div class="history">
				<div style="position:sticky;top:50px;">
					<h1 class="title">기록<span class="activity" style="font-size: 0.7em; color: grey; margin-left: 0.5em;"></span></h1>
					<textarea class="blackboard"></textarea>
				</div>
				
			</div>

		</main>
		

		<?php
		if (isset($_SESSION['govern_verified']) && $_SESSION['govern_verified']) {
		?>
		<script src="js/milage.js?v=1.000"></script>
		<?php
		}
		?>

		

	</body>
</html>