<?php

include $_SERVER['DOCUMENT_ROOT'].'/connect.php';

include $_SERVER['DOCUMENT_ROOT'].'/php-module/database-api.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title>대원정보</title>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/head-css-essential.html'; ?>
	<link rel="stylesheet" type="text/css" href="css/ap-info.css?v=1.003" />
	<link rel="stylesheet" type="text/css" href="/css/input-ui.css"/>
</head>
<body>
	<?php include $_SERVER['DOCUMENT_ROOT'].'/globalnav.php'; ?>
	<main id="ap-info-main">

		<div class="header-wrapper">
			<h1 class="typography-header ap-info-header">대원 정보</h1>

			<div class="ap-info-search-wrapper">
				<input class="input-text-ui search-anything" type="text" name="search_anything" placeholder="아무거나 검색" />
				<div class="checkbox-container">
					<input id="cb-edit" class="cb cb-edit" type="checkbox" name=""><label for="cb-edit">수정모드</label>
					<input id="cb-msn" class="cb cb-msn" type="checkbox" checked /><label for="cb-msn">군번</label>
					<input id="cb-ctznc" class="cb cb-ctznc" type="checkbox" checked /><label for="cb-ctznc">주민번호</label>
					<input id="cb-phone" class="cb cb-phone" type="checkbox" checked /><label for="cb-phone">휴대폰 번호</label>
					<input id="cb-address" class="cb cb-address" type="checkbox" /><label for="cb-address">집 주소</label>
					<input id="cb-parents-info" class="cb cb-parents-info" type="checkbox"><label for="cb-parents-info">부모님 정보</label>
					<input id="cb-roll" class="cb cb-roll" type="checkbox" /><label for="cb-roll">보직</label>
					<button id="download">엑셀 다운로드</button>
				</div>
			</div>
		</div>
		
		
		<div class="ap-info-wrapper">
			
			<div class="ap-info-container">
				<table id="ap-info-table">
					<thead>
						<tr>
							<th class="name" data-header-name="name">이름</th>
							<th class="level" data-header-name="level">기수</th>
							<th class="platoon" data-header-name="platoon">소대</th>
							<th class="military-number" data-header-name="military-number">군번</th>
							<th class="citizen-code" data-header-name="citizen-code">주민번호</th>
							<th class="phone-number" data-header-name="phone-number">휴대폰 번호</th>
							<th class="home-address hidden" data-header-name="home-address">집 주소</th>
							<th class="father-name hidden" data-header-name="father-name">아버지 성함</th>
							<th class="father-pn hidden" data-header-name="father-pn">아버지 번호</th>
							<th class="mother-name hidden" data-header-name="mother-name">어머니 성함</th>
							<th class="mother-pn hidden" data-header-name="mother-pn">어머니 번호</th>
							<th class="enroll-at" data-header-name="enroll-at">입대일</th>
							<th class="transfer-at" data-header-name="transfer-at">전입일</th>
							<th class="discharge-at" data-header-name="discharge-at">전역일</th>
							<th class="roll hidden" data-header-name="roll">보직</th>
						</tr>
					</thead>
					<tbody>
						<?php

						$ap_list = get_currently_serving_member();

						foreach ($ap_list as $key => $ap) {
						?>

						<tr class="row-ap" data-ap-id="<?php echo $ap['id']; ?>">
							<td class="name">
								<a href="/profile/?ap_id=<?php echo $ap['id']; ?>" title=""><?php echo $ap['name']; ?></a>
							</td>
							<td class="level" data-column-name="level"><?php echo $ap['level']; ?>기</td>
							<td class="platoon" data-column-name="platoon"><?php
							if ($ap['platoon'] == 0) {
								echo '본부소대';
							} else {
								echo $ap['platoon'] . '소대';
							}
							?></td>
							<td class="military-number editable" data-column-name="military_serial_number"><?php echo $ap['military_serial_number']; ?></td>
							<td class="citizen-code editable" data-column-name="citizen_code"><?php echo $ap['citizen_code']; ?></td>
							<td class="phone-number phone-number-input editable" data-column-name="phone_number"><?php echo preg_replace('/(\d\d\d)(\d\d\d\d?)(\d\d\d\d)/', '$1-$2-$3', $ap['phone_number']); ?></td>
							<td class="home-address hidden editable" data-column-name="home_address"><?php echo $ap['home_address']; ?></td>
							<td class="father-name hidden editable" data-column-name="father_name"><?php echo $ap['father_name']; ?></td>
							<td class="father-pn hidden phone-number-input editable" data-column-name="father_pn"><?php echo preg_replace('/(\d\d\d)(\d\d\d\d?)(\d\d\d\d)/', '$1-$2-$3', $ap['father_pn']); ?></td>
							<td class="mother-name hidden editable" data-column-name="mother_name"><?php echo $ap['mother_name']; ?></td>
							<td class="mother-pn hidden phone-number-input editable" data-column-name="mother_pn"><?php echo preg_replace('/(\d\d\d)(\d\d\d\d?)(\d\d\d\d)/', '$1-$2-$3', $ap['mother_pn']); ?></td>
							<td class="enroll-at date-input editable" data-column-name="enroll_at"><?php echo $ap['enroll_at']; ?></td>
							<td class="transfer-at date-input editable" data-column-name="transfer_at"><?php echo $ap['transfer_at']; ?></td>
							<td class="discharge-at date-input editable" data-column-name="discharge_at"><?php echo $ap['discharge_at']; ?></td>
							<td class="roll hidden"><?php
							if ($ap['roll'] == 1) {
								echo '일반';
							} else if ($ap['roll'] == 2) {
								echo '행정';
							} else if ($ap['roll'] == 3) {
								echo '항해사';
							} else if ($ap['roll'] == 4) {
								echo '중대수인';
							}
							?></td>
						</tr>

						<?php
						}

						?>
					</tbody>
				</table>
			</div>
		</div>
	</main>
	<script src="js/ap-info.js?v=1.002"></script>
</body>
</html>
