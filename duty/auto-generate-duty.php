<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

$year = $_POST['year'];
$month = $_POST['month'];
$days_in_month = $_POST['days_in_month'];
$sequence = $_POST['sequence'];
$dang_team = $_POST['dang_team'];
$il_team = $_POST['il_team'];

if ($dang_team + $il_team == 3) {
    $be_team = 3;
} else if ($dang_team + $il_team == 4) {
    $be_team = 2;
} else if ($dang_team + $il_team == 5) {
    $be_team = 1;
}

$duty_at = $year . '-' . $month . '-01';

$next_dang_team = $dang_team;
$next_il_team = $il_team;
$next_be_team = $be_team;

for ($i = 0; $i < $days_in_month; $i++) {
    // 당직
    $sql = "SELECT * FROM duty_stack WHERE dang_before = '$next_dang_team' AND duty_at < '$duty_at' ORDER BY duty_at DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }

    if (mysqli_num_rows($result) == 0) {
        die('이전 달 근무 편성 기록이 없어서 편성표를 생성할 수 없습니다.');
    }

    $da1 = mysqli_fetch_assoc($result)['duty_at'];

    $sql = "SELECT * FROM duty_stack WHERE dang_after = '$next_dang_team' AND duty_at < '$duty_at' ORDER BY duty_at DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }

    if (mysqli_num_rows($result) == 0) {
        die('이전 달 근무 편성 기록이 없으므로 편성표를 생성할 수 없습니다.');
    }

    $da2 = mysqli_fetch_assoc($result)['duty_at'];

    if ($da1 > $da2) {
        $next_dang_after = $next_dang_team;
        $next_dang_before = get_sub_agent_roll_by_team($next_dang_team);
    } else if ($da1 < $da2) {
        $next_dang_before = $next_dang_team;
        $next_dang_after = get_sub_agent_roll_by_team($next_dang_team);
    }

    // 일근
    $sql = "SELECT * FROM duty_stack WHERE il_st = '$next_il_team' AND duty_at < '$duty_at' ORDER BY duty_at DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }

    if (mysqli_num_rows($result) == 0) {
        die('이전 달 근무 편성 기록이 없으므로 새로운 편성표를 생성할 수 없습니다.');
    }

    $ist1 = mysqli_fetch_assoc($result)['duty_at'];

    $sql = "SELECT * FROM duty_stack WHERE il_bst = '$next_il_team' AND duty_at < '$duty_at' ORDER BY duty_at DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }

    if (mysqli_num_rows($result) == 0) {
        die('이전 달 근무 편성 기록이 없으므로 편성표를 생성할 수 없습니다.');
    }

    $ist2 = mysqli_fetch_assoc($result)['duty_at'];

    if ($ist1 > $ist2) {
        $next_il_bst = $next_il_team;
        $next_il_st = get_sub_agent_roll_by_team($next_il_team);
    } else if ($ist1 < $ist2) {
        $next_il_st = $next_il_team;
        $next_il_bst = get_sub_agent_roll_by_team($next_il_team);
    }

    // echo '당직전반: '.get_agent_call($next_dang_before).', 당직후반: '.get_agent_call($next_dang_after).', 일근선탑: '.get_agent_call($next_il_st).', 일근비선탑: '.get_agent_call($next_il_bst).'<br />';

    // INSERT
    $sql = "SELECT * FROM duty_stack WHERE duty_at = '$duty_at'";
    $result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }
    if (mysqli_num_rows($result) > 0) {
        // Already exists duty stack at this day
        $sql = "UPDATE duty_stack SET dang_team = '$next_dang_team', dang_before = '$next_dang_before', dang_after = '$next_dang_after', il_team = '$next_il_team', il_st = '$next_il_st', il_bst = '$next_il_bst', be_team = '$next_be_team' WHERE duty_at = '$duty_at'";
    } else {
        $sql = "INSERT INTO duty_stack (dang_team, dang_before, dang_after, il_team, il_st, il_bst, be_team, duty_at) VALUES ('$next_dang_team', '$next_dang_before', '$next_dang_after', '$next_il_team', '$next_il_st', '$next_il_bst', '$next_be_team', '$duty_at')";
    }

    $result = mysqli_query($conn, $sql);
    if (!$result) { echo mysqli_error($conn); }

    $next_dang_team = get_next_team($next_dang_team, $sequence);
    $next_il_team = get_next_team($next_il_team, $sequence);
    $next_be_team = get_next_team($next_be_team, $sequence);

    $duty_at = date('Y-m-d', strtotime($duty_at.'+ 1 days'));
}

function get_next_team($team, $sequence) {
    if ($sequence == 1) {
        if ($team == 1) {
            return 2;
        } else if ($team == 2) {
            return 3;
        } else if ($team == 3) {
            return 1;
        }
    } else if ($sequence == 2) {
        if ($team == 1) {
            return 3;
        } else if ($team == 2) {
            return 1;
        } else if ($team == 3) {
            return 2;
        }
    }
}

?>
