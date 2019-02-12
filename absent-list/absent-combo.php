<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/connect.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/php-module/database-api.php';

$today = date('Y-m-d');

if (isset($_SESSION['jb_mode']) && $_SESSION['jb_mode']) {
	$hour = date('G');
	if ($hour >= 5) {
		$today = date('Y-m-d', strtotime($today . '+ 1 days'));
	}
}

if (isset($_GET['date'])) {
	$today = $_GET['date'];
}
// $today = "2018-02-18";

$day_name_kr = array("일", "월", "화", "수", "목", "금", "토");

// Classify absent list information
$sql = "SELECT * FROM ap_outside_activity
        WHERE out_at <= '$today'
        AND in_at >= '$today'
        ORDER BY in_at, out_at";

$absent_result = mysqli_query($conn, $sql);
if (!$absent_result) {
	die(mysqli_error($conn));
}

for ($i = 0; $i < 4; $i++) {
	${'platoon_' . $i . '_absent'} = [
		"vacation" => [],
		"out_sleep" => [],
		"special_out_sleep" => [],
		"sick" => [],
		"etc" => [],
		"govern" => [],
		"newbie" => [],
		"autonomous" => [],
		"patient" => [],
		"etc_remain" => []
	];
}

// Categorize
while ($activity = mysqli_fetch_assoc($absent_result)) {

	$ap = get_ap_info($activity['ap_id'], $today);
	if ($ap['moved_out'] || strtotime($today) >= strtotime($ap['discharge_at'])) {
		continue;
	}

	// Fetch data from ap_outside_activity table
	// echo $ap['platoon'];
	switch ($activity['type']) {
		case 1:
		case 5:
			${'platoon_' . $ap['platoon'] . '_absent'}['vacation'][] = ["ap" => $ap, "activity" => $activity];
			break;
		case 2:
			${'platoon_' . $ap['platoon'] . '_absent'}['out_sleep'][] = ["ap" => $ap, "activity" => $activity];
			break;
		case 3:
			${'platoon_' . $ap['platoon'] . '_absent'}['special_out_sleep'][] = ["ap" => $ap, "activity" => $activity];
			break;
		case 6:
		case 7:
			${'platoon_' . $ap['platoon'] . '_absent'}['sick'][] = ["ap" => $ap, "activity" => $activity];
			break;
		case 8:
			${'platoon_' . $ap['platoon'] . '_absent'}['etc'][] = ["ap" => $ap, "activity" => $activity];
			break;
		case 9:
			${'platoon_' . $ap['platoon'] . '_absent'}['patient'][] = ["ap" => $ap, "activity" => $activity];
			break;
		case 10:
			${'platoon_' . $ap['platoon'] . '_absent'}['etc_remain'][] = ["ap" => $ap, "activity" => $activity];
			break;
		default:
			break;
	}
}


// Fetch remain data(행정대원)
$governs = get_today_govern($today);
foreach ($governs as $key => $cat) {
	foreach ($cat as $key => $ap) {
		$skip = false;

		// Already included in absent list, skip
		foreach (${'platoon_' . $ap['platoon'] . '_absent'} as $absent_type => $absent_type_array) {
			foreach ($absent_type_array as $index => $ap_and_activity) {
				if (isset($ap_and_activity['ap']) &&
					$ap_and_activity['ap']['id'] == $ap['id']) {
					$skip = true;
				}
			}
		}

		if (!$skip) {
			${'platoon_' . $ap['platoon'] . '_absent'}['govern'][] = $ap;
		}
	}
}

// Fetch autonomous
// 자경/식기
$autonomous = get_today_autonomous($today);
$platoon_1_absent['autonomous'][] = get_ap_info($autonomous[0]['ap_id'])['name'];
$platoon_2_absent['autonomous'][] = get_ap_info($autonomous[1]['ap_id'])['name'];
$platoon_3_absent['autonomous'][] = get_ap_info($autonomous[2]['ap_id'])['name'];


// echo $platoon_1_absent["vacation"][1]["ap"]["name"];

function echo_absent_item($platoon_absent_array, $daily_flag = null)
{

	global $today;

	$paa = $platoon_absent_array;

	for ($i = 0; $i < count($paa); $i++) {

		$ap = $paa[$i]['ap'];
		$act = $paa[$i]['activity'];

		$color_mark = "";

		if (date("Y-m-d", strtotime($act['out_at'])) == $today) {
			$color_mark = " blue";
			if (date("Y-m-d", strtotime($act['in_at'])) == $today) {
				$color_mark = " violet";
			}
		} else if (date("Y-m-d", strtotime($act['in_at'])) == $today) {
			$color_mark = " green";
		}

		$name = '<span class="ap-name" data-ap-id="' . $ap['id'] . '">' . $ap['name'] . '</span>';
		$start_date = date('m. d', strtotime($act['out_at']));
		$end_date = date('m. d', strtotime($act['in_at']));

		$date = new DateTime($act['in_at']);

		if ($date->format('Y') == "9999") {
			$end_date = "별명시";
		}
		$interval = $start_date . ' - ' . $end_date;
		if ($start_date == $end_date) {
			$interval = $start_date;
		}
		$display_name = $act['display_name'];

		// Check if there are similar items
		// Merge theme into one item for saving spaces
		while (1) {
			if (isset($paa[$i + 1])) {
				$next_ap = $paa[$i + 1]['ap'];
				$next_act = $paa[$i + 1]['activity'];
				if ($act['out_at'] == $next_act['out_at'] && $act['in_at'] == $next_act['in_at'] && $act['display_name'] == $next_act['display_name']) {
					$name .= " " . '<span class="ap-name" data-ap-id="' . $next_ap['id'] . '">' . $next_ap['name'] . '</span>';
					$i += 1;
					// echo 'same';
				} else {
					// echo 'not same';
					break;
				}
			} else {
				break;
			}
		}
		if (!$daily_flag) {
			echo
				'<div class="activity-item' . $color_mark . '">
				<span style="font-weight: 800;">' . $name . '<br /></span>
				(' . $interval . ')<br />'
				. $display_name .
				'</div>';
		} else {
			echo
				'<div class="activity-item' . $color_mark . '">
				<span style="font-weight: 800;">' . $name . '<br /></span>
				(' . $interval . ')' .
				'</div>';
		}
	}
}

function echo_remain($platoon)
{
	global $conn;
	global ${'platoon_' . $platoon . '_absent'};
	global $today;

	$paa = ${'platoon_' . $platoon . '_absent'}['govern'];

	if (sizeof($paa) > 0) {
		echo '<div>';
	}

	$first = true;
	foreach ($paa as $index => $ap) {
		if (!$first) {
			echo " ";
		}
		echo $ap['name'];
		$first = false;
	}

	if ($platoon == 0) {
		$purpose = "(행정대원)";
	} else {
		$purpose = "(행정지원)";
	}

	if (sizeof($paa) > 0) {
		echo "<br />" . $purpose;
		echo '</div>';
	}

	// 환자 표시
	$paa = ${'platoon_' . $platoon . '_absent'}['patient'];
	if (sizeof($paa) > 0) {
		echo '<div>';
	}
	$first = true;
	foreach ($paa as $index => $item) {
		if (!$first) {
			echo " ";
		}
		echo $item['ap']['name'];
		$first = false;
	}
	if (sizeof($paa) > 0) {
		echo "<br />" . "(환자)";
		echo '</div>';
	}

	// 기타 잔류
	$paa = ${'platoon_' . $platoon . '_absent'}['etc_remain'];
	// sort the array to bind same event into one
	usort($paa, function ($a, $b) {
		return $a['activity']['display_name'] <=> $b['activity']['display_name'];
	});

	for ($i = 0; $i < count($paa); $i++) {

		echo '<div class="activity-item">';

		$ap = $paa[$i]['ap'];
		$act = $paa[$i]['activity'];

		$name = $ap['name'];

		// Check if there are similar items
		// Merge theme into one item for saving spaces
		while (1) {
			if (isset($paa[$i + 1])) {
				$next_ap = $paa[$i + 1]['ap'];
				$next_act = $paa[$i + 1]['activity'];
				if ($act['display_name'] == $next_act['display_name']) {
					$name .= ", " . $next_ap['name'];
					$i += 1;
				} else {
					break;
				}
			} else {
				break;
			}
		}

		echo $name . '<br />';
		echo '(' . $act['display_name'] . ')';
		echo '</div>';
	}
}

function num_go_out($platoon_absent_array, $platoon)
{

	global $today;

	$total = 0;

	$paa = $platoon_absent_array;

	foreach ($paa as $absent_type => $absent_type_array) {
		foreach ($absent_type_array as $index => $ap_and_activity) {
			if (!empty($ap_and_activity)) {
				$total++;
			}
		}
	}

	return count(get_currently_serving_member($platoon, $today)) - $total;
}

include_once $_SERVER['DOCUMENT_ROOT'] . "/daily-information/calc-pol-status.php";

?>