$(document).ready(function() {
	$('.ss-item').on('click', function() {
		if ($(this).hasClass('selected')) return;
		$('.ss-item.selected').removeClass('selected');
		$(this).addClass('selected');
	});

	$('.dbs-item').on('click', function() {
		if ($(this).hasClass('selected')) return;
		$('.dbs-item.selected').removeClass('selected');
		$(this).addClass('selected');
	});

	$('.ist-item').on('click', function() {
		if ($(this).hasClass('selected')) return;
		$('.ist-item.selected').removeClass('selected');
		$(this).addClass('selected');
	});

	$('.set-btn').on('click', function() {
		var sequence, dangTeam, ilTeam;
		var ssItemSel, dangTeamSel, ilTeamSel;

		// 근무 순환 방향 설정 가져오기
		if (ssItemSel = document.querySelector('.ss-item.selected')) {
			sequence = ssItemSel.getAttribute('data-seq');
		} else {
			alert('근무 순환 방향을 선택하세요.');
			return;
		}

		if (dangTeamSel = document.querySelector('.dbs-item.selected')) {
			dangTeam = dangTeamSel.getAttribute('data-d');
		} else {
			alert('당직 팀을 선택하세요.');
			return;
		}

		if (ilTeamSel = document.querySelector('.ist-item.selected')) {
			ilTeam = ilTeamSel.getAttribute('data-i');
		} else {
			alert('일근 팀을 선택하세요.');
			return;
		}

		if (!confirm('이 설정으로 편성표를 생성하겠습니까?')) {
			return;
		}

		var year = document.querySelector('html').getAttribute('data-year');
		var month = document.querySelector('html').getAttribute('data-month');
		var daysInMonth = document.querySelector('html').getAttribute('data-days-in-month');

		// console.log(month);
		// console.log(daysInMonth);
		// console.log(sequence);
		// console.log(dangBefore);
		// console.log(ilSt);

		$.ajax({
			url: 'auto-generate-duty.php',
			type: 'post',
			data: {
				"year": year,
				"month": month,
				"days_in_month": daysInMonth,
				"sequence": sequence,
				"dang_team": dangTeam,
				"il_team": ilTeam
			},
		})
		.done(function(data) {
			if (data) {
				alert(data);
			}
			location.reload();
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});
});
