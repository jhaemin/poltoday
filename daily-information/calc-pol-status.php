<?php

if (!isset($agent_working_info_order)) {
	$agent_working_info_order = null;
}

// 지휘요원 인원현황 파악
$agents_working_array = get_agent_working_info($today, $agent_working_info_order);
$agent_total_num = 9;
$agent_total_absent_num = 0;
$agent_total_remain_num = 0;
$platoon_agent_total_num = [3, 2, 2, 2];
$platoon_agent_absent_num = [0, 0, 0, 0];
$platoon_agent_remain_num = [0, 0, 0, 0];

$platoon_ap_total_num = [0, 0, 0, 0];

foreach ($agents_working_array as $key => $agent) {
	
	if ($agent['roll'] == 7) { // 중대장님
		if ($agent['working_group'] == 8) {
			// 휴무임
			$platoon_agent_absent_num[0]++;
			$agent_total_absent_num++;
		} else if ($agent['sub_working_type']) {

			if ($agent['sub_working_type'] != 3 && $agent['sub_working_type'] != 4 && $agent['sub_working_type'] != 6 && $agent['sub_working_type'] != 7) {
				// 그 외 쉼
				$platoon_agent_absent_num[0]++;
				$agent_total_absent_num++;
			}
			
		
		}
	} else { // 중대장님 아님
		$agent_platoon;
		if ($agent['roll'] == 1 || $agent['roll'] == 4) {
			$agent_platoon = 1;
		} else if ($agent['roll'] == 2 || $agent['roll'] == 5) {
			$agent_platoon = 2;
		} else if ($agent['roll'] == 3 || $agent['roll'] == 6) {
			$agent_platoon = 3;
		} else if ($agent['roll'] == 8 || $agent['roll'] == 9) {
			$agent_platoon = 0;
		}

		if ($agent['working_group'] == 8) { // 휴무일때
			if ($agent['sub_working_type'] == 3 || $agent['sub_working_type'] == 4) { // 대리당번, 직무대리

			} else if (!$agent['sub_working_type']) { // 휴무일 때 추가로 이벤트가 있는 경우
				$platoon_agent_absent_num[$agent_platoon]++;
				$agent_total_absent_num++;
			}
		} else { // 휴무 아님
			if ($agent['sub_working_type'] == 1 || $agent['sub_working_type'] == 2 || $agent['sub_working_type'] == 9) { // 비번, 연가 썼을 때 그리고 기타
				$platoon_agent_absent_num[$agent_platoon]++;
				$agent_total_absent_num++;
			} else if ($agent['working_group'] == 7) { // 출근하는 일근임
				if (!$agent['sub_working_type']) { // 일근일 때 추가로 이벤트가 없음
					$platoon_agent_remain_num[$agent_platoon]++;
					$agent_total_remain_num++;
				} else { // 일근일 때 추가로 이벤트 있음 (대당이나 직대)

					if ($agent['roll'] == 8 || $agent['roll'] == 9) {
						$platoon_agent_remain_num[$agent_platoon]++;
						$agent_total_remain_num++;
					} else {
						if ($agent['sub_working_type'] == 5) { // 일근 선탑
							
						} else if ($agent['sub_working_type'] == 10) { // 일근 비선탑
							$platoon_agent_remain_num[$agent_platoon]++;
							$agent_total_remain_num++;
						}
					}
					
				}
			}
		}
	}
}

// 의무경찰 인원현황 파악
$ap_absent_platoon_total = [];

for ($i = 0; $i < 4; $i++) {
	$ap_absent_platoon_total[] =
		count(${"platoon_" . $i . "_absent"}['vacation']) +
		count(${"platoon_" . $i . "_absent"}['out_sleep']) +
		count(${"platoon_" . $i . "_absent"}['etc']) +
		count(${"platoon_" . $i . "_absent"}['sick']) +
		count(${"platoon_" . $i . "_absent"}['special_out_sleep']);
}

$ap_absent_total = $ap_absent_platoon_total[0] + $ap_absent_platoon_total[1] + $ap_absent_platoon_total[2] + $ap_absent_platoon_total[3];

?>