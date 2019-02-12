<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

$day_name_kr = array("일", "월", "화", "수", "목", "금", "토");

class Agent {
	function __construct($id, $name, $call, $roll) {
		$agent_id = $id;
		$agent_name = $name;
		$agent_call = $call;
		$agent_roll = $roll;
	}

	public $agent_id;
	public $agent_name;
	public $agent_call;
	public $agent_roll;


}

function get_currently_serving_member($platoon = null, $today = null, $daily_flag = null) {

	global $conn;

	$members = [];

	$today_date = date('Y-m-d');

	if (isset($today)) {
		$today_date = $today;
	}

	$sql = "SELECT * FROM ap_info WHERE '$today_date' < discharge_at AND transfer_at <= '$today_date' ORDER BY level, platoon, name";

	$result = mysqli_query($conn, $sql);

	while ($ap = mysqli_fetch_assoc($result)) {
		$ap = get_ap_info($ap['id'], $today_date);
		if ($ap['moved_out']) {
			continue;
		}
		if (isset($platoon)) {
			if ($daily_flag) {
				if ($platoon == 0) {
					if ($ap['roll'] == 2) {

					} else if ($ap['platoon'] != $platoon) {
						continue;
					}
				} else {
					if ($ap['roll'] == 2) {
						continue;
					} else if ($ap['platoon'] != $platoon) {
						continue;
					}
				}
			} else if ($ap['platoon'] != $platoon) {
				continue;
			}
		}
		$members[] = $ap;
	}

	return $members;
}

function get_ap_info($ap_id, $today = null) {

	global $conn;

	$today_date = date('Y-m-d');

	if (isset($today)) {
		$today_date = $today;
	}

	$sql = "SELECT * FROM ap_info WHERE id='$ap_id'";

	$result = mysqli_query($conn, $sql);

	if (mysqli_num_rows($result) == 0) {
		return;
	}

	$ap = mysqli_fetch_assoc($result);

	$sql = "SELECT * FROM ap_info_change_event WHERE ap_id='$ap_id' AND type='roll' AND changed_at > '$today_date' ORDER BY changed_at ASC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$ap['roll'] = $row['from_val'];
	}

	$sql = "SELECT * FROM ap_info_change_event WHERE ap_id='$ap_id' AND type='platoon' AND changed_at > '$today_date' ORDER BY changed_at ASC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$ap['platoon'] = $row['from_val'];
	}

	$sql = "SELECT * FROM ap_info_change_event WHERE ap_id='$ap_id' AND type='moved_out' AND changed_at > '$today_date' ORDER BY changed_at ASC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$ap['moved_out'] = $row['from_val'];
	}

	$ap['phone_number'] = preg_replace('/(\d\d\d)(\d\d\d\d?)(\d\d\d\d)/', '$1-$2-$3', $ap['phone_number']);

	return $ap;

}

function get_platoon_name($platoon) {

	global $conn;
	$sql = "SELECT * FROM ap_platoon WHERE id='$platoon'";
	$result = mysqli_query($conn, $sql);
	if (!$result) echo mysqli_error($conn);
	$name = mysqli_fetch_assoc($result)['platoon_name'];

	return $name;

}

function get_roll_name($roll) {

	global $conn;
	$sql = "SELECT * FROM ap_roll WHERE id='$roll'";
	$result = mysqli_query($conn, $sql);
	if (!$result) echo mysqli_error($conn);
	$name = mysqli_fetch_assoc($result)['roll'];

	return $name;

}

function get_event_name($event) {
	global $conn;
	$sql = "SELECT * FROM event_name WHERE id='$event'";
	$result = mysqli_query($conn, $sql);
	if (!$result) echo mysqli_error($conn);
	$name = mysqli_fetch_assoc($result)['event'];

	return $name;
}

function get_today_affair($today) {

}

function get_today_autonomous($today) {

	global $conn;

	$autonomous = [];

	// $today = '2018-02-21';

	for ($platoon = 1; $platoon <= 3; $platoon++) {

		while (1) {
			// DB에서 자경 불러오기
			$sql = "SELECT * FROM autonomous WHERE platoon='$platoon' AND work_at='$today'";
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				echo mysqli_error($conn);
			}
			if (mysqli_num_rows($result) > 0) {
				${'platoon_'.$platoon.'_name'} = mysqli_fetch_assoc($result);
				break;
			} else {
				${'platoon_'.$platoon.'_name'} = null;
				break;
			}
		}

	}

	return array($platoon_1_name, $platoon_2_name, $platoon_3_name);

	// $sql = "SELECT * FROM autonomous WHERE platoon='$platoon' AND work_at='$today'";
	// $result = mysqli_query($conn, $sql);
	// if (!$result) {
	// 	echo mysqli_error($conn);
	// }
	// while ($row = mysqli_fetch_assoc($result)) {
	// 	$autonomous[] = $row;
	// }

	// return $autonomous;

}

function get_today_govern_fair($today = null) {
	// 행정대원, 행정지원

	global $conn;

	$govern_aps = [];

	if (!isset($today)) {
		$today = date('Y-m-d');
	}

	$sql = "SELECT * FROM ap_info WHERE '$today' < discharge_at AND transfer_at <= '$today' AND roll = 2 ORDER BY level ASC";

	$result = mysqli_query($conn, $sql);

	while ($govern_ap = mysqli_fetch_assoc($result)) {
		$govern_aps[] = $govern_ap;
	}

	return $govern_aps;

}

function get_today_govern($today = null) {
	// 행정대원, 행정지원

	global $conn;

	if (!isset($today)) {
		$today = date('Y-m-d');
	}

	$remain_list = [
		"gov" => [],
		"semi_gov" => [],
	];

	// 본부소대 행정대원
	$sql = "SELECT * FROM ap_info WHERE '$today' < discharge_at AND transfer_at <= '$today' ORDER BY level ASC";
	$result= mysqli_query($conn, $sql);
	if (!$result) echo mysqli_error($conn);
	while ($ap = mysqli_fetch_assoc($result)) {

		$ap = get_ap_info($ap['id'], $today);

		if ($ap['platoon'] == 0 && $ap['roll'] == 2) {
			$remain_list['gov'][] = $ap;
		} else if ($ap['roll'] == 2) {
			$remain_list['semi_gov'][] = $ap;
		}
	}

	return $remain_list;
}

function update_event($display_name, $out_at, $in_at) {
	global $conn;

	$sql = "UPDATE ap_outside_activity SET display_name='$display_name', out_at='$out_at', in_at='$in_at'";

	if (isset($display_name)) {

	}

	$result = mysqli_query($conn, $sql);
	if (!$result) {
		echo mysqli_error($conn);
	} else {

	}
}

function remove_event($event_id) {

}

// 1,2,3팀 당직 가져오기
// 쉬는 날, 대리당직 관계없이
// 원래 루틴대로 반환함.
function get_today_duty($date = NULL) {
	global $conn;

	$today = date('Y-m-d');
	if (isset($date)) {
		$today = $date;
	}

	$duty_result = [
		'd' => '',
		'i' => '',
		'b' => ''
	];

	$sql = "SELECT * FROM duty_stack WHERE duty_at = '$today'";
	$result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }

	$duty = mysqli_fetch_assoc($result);

	$duty_result['d'] = $duty['dang_team'];
	$duty_result['i'] = $duty['il_team'];
	$duty_result['b'] = $duty['be_team'];

	return $duty_result;
}

// 지휘요원 API


function get_all_agents($order = null) {
	global $conn;
	$sql = "SELECT * FROM agent_info ORDER BY `name`";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
	$agent_list = [];
	while ($agent = mysqli_fetch_assoc($result)) {
		$agent_list[] = $agent;
	}

	return $agent_list;
}

// 현재 근무중인 지휘요원 목록 순서를 옵션에 맞춰 반환
function get_currently_serving_agent_list($date, $order = NULL) {
	global $conn;
	$today = date('Y-m-d');
	if (isset($date)) {
		$today = $date;
	}

	$sql = "SELECT * FROM agent_info WHERE work_begin<='$today' AND work_end >= '$today' AND moved_out = 0 ORDER BY roll ASC";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }

	$agent_list = [];
	while ($agent = mysqli_fetch_assoc($result)) {
		$agent = get_agent_info_by_id($agent['id'], $today);
		$agent_list[] = $agent;
	}

	$agent_ordered_list = [];

	// 순서 옵션 없음
	// 기본 데이터베이스에 저장된 순으로 반환
	if ($order == NULL) {
		
		return $agent_list;
	
	} else if ($order == "govern") {
		
		// 소대장님순
		// 중->행소->행부->1소->2소->3소->1부->2부->3부
		$agent_ordered_list[] = $agent_list[6];
		$agent_ordered_list[] = $agent_list[7];
		$agent_ordered_list[] = $agent_list[8];
		$agent_ordered_list[] = $agent_list[0];
		$agent_ordered_list[] = $agent_list[1];
		$agent_ordered_list[] = $agent_list[2];
		$agent_ordered_list[] = $agent_list[3];
		$agent_ordered_list[] = $agent_list[4];
		$agent_ordered_list[] = $agent_list[5];
		return $agent_ordered_list;
	
	} else if ($order == "platoon") {
		
		// 소대별로 나열
		// 본부->1->2->3
		$agent_ordered_list[] = $agent_list[6];
		$agent_ordered_list[] = $agent_list[7];
		$agent_ordered_list[] = $agent_list[8];
		$agent_ordered_list[] = $agent_list[0];
		$agent_ordered_list[] = $agent_list[3];
		$agent_ordered_list[] = $agent_list[1];
		$agent_ordered_list[] = $agent_list[4];
		$agent_ordered_list[] = $agent_list[2];
		$agent_ordered_list[] = $agent_list[5];
		return $agent_ordered_list;
	
	} else {
		
		return $agent_list;
	
	}
}

function get_sub_agent_roll_by_team($team) {
	if ($team == 1) {
		return 5;
	} else if ($team == 2) {
		return 6;
	} else if ($team == 3) {
		return 4;
	} else if ($team == 4) {
		return 3;
	} else if ($team == 5) {
		return 1;
	} else if ($team == 6) {
		return 2;
	}
}

function get_agent_info_by_id($agent_id, $date = null) {
	global $conn;

	$today = date('Y-m-d');
	if (isset($date)) {
		$today = $date;
	}

	$sql = "SELECT * FROM agent_info WHERE id='$agent_id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }

	$agent = mysqli_fetch_assoc($result);

	$sql = "SELECT * FROM agent_info_change_event
	        WHERE agent_id='$agent_id'
	        AND type='roll'
	        AND changed_at > '$today'
	        ORDER BY changed_at
	        ASC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$agent['roll'] = $row['from_val'];
	}

	$sql = "SELECT * FROM agent_info_change_event
	        WHERE agent_id='$agent_id'
	        AND type = 'step'
					AND changed_at > '$today'
					ORDER BY changed_at
					ASC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }
	if (mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$agent['step'] = $row['from_val'];
	}

	$agent['call'] = get_agent_call($agent['roll'], false);
	$agent['step'] = get_agent_step_name($agent['step']);

	return $agent;
}

function get_agent_info_by_roll($roll = null, $date = null, $polite = false) {
	global $conn;

	if (!$roll) {
		return ;
	}

	$today = date('Y-m-d');
	if (isset($date)) {
		$today = $date;
	}

	$sql = "SELECT * FROM agent_info_change_event WHERE changed_at >= '$today' AND type = 'roll' AND from_val = '$roll' ORDER BY changed_at ASC LIMIT 1";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }

	if (mysqli_num_rows($result) == 0) {
		// No record for this change
		// then select current roll agent
		$sql = "SELECT * FROM agent_info WHERE roll='$roll' AND work_begin <= '$today' AND '$today' < work_end AND moved_out=0";
		$result2 = mysqli_query($conn, $sql);
		if (!$result2) { echo mysqli_error($conn); }

		$agent = mysqli_fetch_assoc($result2);
		$agent['step'] = get_agent_step_name($agent['step']);

	} else {
		$agent_id = mysqli_fetch_assoc($result)['agent_id'];
		echo $agent_id;
		$agent = get_agent_info_by_id($agent_id, $today);
	}

	$agent['call'] = get_agent_call($roll, $polite);

	return $agent;
}

function get_agent_call($roll, $polite = false) {
	global $conn;

	if (!$roll || $roll == "") {
		return "";
	}

	switch ($roll) {
		case 1:
			$call = '1소대장';
			break;
		case 2:
			$call = '2소대장';
			break;
		case 3:
			$call = '3소대장';
			break;
		case 4:
			$call = '1부소대장';
			break;
		case 5:
			$call = '2부소대장';
			break;
		case 6:
			$call = '3부소대장';
			break;
		case 7:
			$call = '중대장';
			break;
		case 8:
			$call = '행정소대장';
			break;
		case 9:
			$call = '행정부소대장';
			break;

		default:
			# code...
			break;
	}

	if ($polite) {
		$call = $call.'님';
	}

	return $call;
}

function get_agent_step_name($step_id) {
	global $conn;

	$sql = "SELECT * FROM agent_step WHERE id = '$step_id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) {
		die(mysqli_error($conn));
	} else {
		$step_name = mysqli_fetch_assoc($result)["name"];
		return $step_name;
	}
}

function get_agent_event_name($event_type_id) {
	global $conn;

	$sql = "SELECT * FROM agent_event_name WHERE id = '$event_type_id'";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }

	$event_name = mysqli_fetch_assoc($result)['name'];

	return $event_name;
}


// 지휘요원 근무현황
/**
 * 지휘요원 근무현황
 * @param string $date
 * @param string $order "govern" | "platoon"
 */
function get_agent_working_info($date, $order = NULL) {

	global $today;
	global $conn;

	$today = $date;

	$agents_result = [];

	$serving_agents = get_currently_serving_agent_list($today, $order);

	$today_duty = get_today_duty($today);

	foreach ($serving_agents as $key => $value) {

		$working_group = null;
		if ($value['roll'] == $today_duty['d'] || $value['roll'] == get_sub_agent_roll_by_team($today_duty['d'])) {
			$working_group = 6;
		} else if ($value['roll'] == $today_duty['i'] || $value['roll'] == get_sub_agent_roll_by_team($today_duty['i'])) {
			$working_group = 7;
		} else if ($value['roll'] == $today_duty['b'] || $value['roll'] == get_sub_agent_roll_by_team($today_duty['b'])) {
			$working_group = 8;
		} else if ($value['roll'] == 7) {
			$working_group = 7;
		} else if ($value['roll'] == 8 || $value['roll'] == 9) {
			if (echo_day_kr($today) == '토' || echo_day_kr($today) == '일') {
				$working_group = 8;
			} else {
				$working_group = 7;
			}
		}

		$event_name = get_agent_event_name($working_group);

		$sql = "SELECT * FROM duty_stack WHERE duty_at = '$today'";
		$result = mysqli_query($conn, $sql);
		if (!$result) { print mysqli_error($conn); }

		$duty_stack = mysqli_fetch_assoc($result);

		$sub_working_type = null;

		if ($value['roll'] == $duty_stack['il_st']) {
			$sub_working_type = 5;
		}

		$agent_id = $value['id'];


		$event_added = false;
		// 비번, 연가, 대리당번, 직무대리 등 기타 이벤트 확인
		$sql = "SELECT * FROM agent_event WHERE event_at = '$today' AND agent_id = '$agent_id'";
		$result = mysqli_query($conn, $sql);
		$etc_event_name = "";
		if (!$result) { print mysqli_error($conn); }
		if (mysqli_num_rows($result) > 0) {
			$event = mysqli_fetch_assoc($result);
			$etc_event_name = $event['etc_event_name'];
			$event_type = $event['event_type'];
			$event_name = get_agent_event_name($event_type);
			if ($event_type == 6 || $event_type == 7 || $event_type == 8) {
				$working_group = $event_type;
			} else {
				$sub_working_type = $event_type;
			}

			$event_added = true;
		}

		if ($etc_event_name != "") {
			$event_name = $etc_event_name;
		}

		$agent = [
			"id" => $value['id'],
			"step" => $value['step'],
			"roll" => $value['roll'],
			"name" => $value['name'],
			"working_group" => $working_group,
			"sub_working_type" => $sub_working_type,
			"event_name" => $event_name,
			"etc_event_name" => $etc_event_name,
			"call" => get_agent_call($value['roll'], false),
			"event_added" => $event_added
		];

		// echo $agent['name'].$agent['sub_working_type'].'<br />';

		$agents_result[] = $agent;
	}

	return $agents_result;
}

// 당직 소대장님 찾기
function get_today_d_s($date) {
	global $conn;
	$dang_team = get_today_duty($date)['d'];
	$dang_agent = get_agent_info_by_roll($dang_team, $date);
	$agent_id = $dang_agent['id'];

	// 당직 소대장님이 휴가나 연가 쓰셨으면
	// 대리당번 찾음
	$sql = "SELECT * FROM agent_event WHERE agent_id = '$agent_id' AND event_at = '$date'";
	$result = mysqli_query($conn, $sql);
	if (!$result) { echo mysqli_error($conn); }

	if (mysqli_num_rows($result) > 0) {
		$sql = "SELECT * FROM agent_event WHERE event_type = 3 AND event_at = '$date'";
		$result = mysqli_query($conn, $sql);
		if (!$result) {
			echo mysqli_error($conn);
		}

		if (mysqli_num_rows($result) > 0) {
			$dang_agent = get_agent_info_by_id(mysqli_fetch_assoc($result)['agent_id'], $date);
			return $dang_agent;
		} else {
			// 대리당번이 없으면
			// 당직관을 찾을 수 없음
			$empty_agent = $dang_agent;
			$empty_agent['step'] = "";
			$empty_agent['roll'] = "";
			$empty_agent['call'] = "";
			$empty_agent['name'] = "<span style='color:red;'>당직관을 찾을 수 없습니다.</span>";

			return $empty_agent;
		}
	}

	return $dang_agent;
	
}

// 한국어 요일 출력
function echo_day_kr($date) {
	$day_name_kr = array("일", "월", "화", "수", "목", "금", "토");
	return $day_name_kr[date('w', strtotime($date))];
}

?>
