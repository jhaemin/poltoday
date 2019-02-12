<?php

include $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
include $_SERVER['DOCUMENT_ROOT'] . '/php-module/database-api.php';



?>
<!DOCTYPE html>
<html lang="ko" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>마일리지 - 대원용</title>
		<?php include $_SERVER['DOCUMENT_ROOT'] . '/head-css-essential.html'; ?>
		<link rel="stylesheet" href="css/milage.css" />
	</head>
	<body>

		<main id="milage-main">

			<h1 class="milage-title">마일리지</h1>

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
							<div class="data"><?php echo $usable_milage; ?></div>
						</div>

						

						<div class="section go-out">
							<div class="go-out-title">외출 (10점)</div>
							<div class="go-out-count">
								<div class="count-num"><?php echo $go_out_count; ?></div>
							</div>
						</div>
						<div class="section out-sleep">
							<div class="out-sleep-title">외박 (15점)</div>
							<div class="out-sleep-count">
								<div class="count-num"><?php echo $out_sleep_count; ?></div>
							</div>
						</div>
					</div>
				</div>
			<?php

	}

	?>

		</main>

		<script src="js/milage.js"></script>

	</body>
</html>