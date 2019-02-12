function dateToStr(date) {
	var str = "";

	str += String(date.getFullYear()) + '-';

	var month;
	if (String(date.getMonth()).length === 1) {
		month = '0' + String(date.getMonth() + 1);
	} else {
		month = String(date.getMonth() + 1);
	}

	var day;
	if (String(date.getDate()).length === 1) {
		day = '0' + String(date.getDate());
	} else {
		day = String(date.getDate());
	}

	str += month + '-' + day;

	return str;
}

var mode = 'today';

var today = new Date();
var todayStr = dateToStr(new Date());
var tomorrow = new Date();
tomorrow.setDate(today.getDate() + 1);
var tomorrowStr = dateToStr(tomorrow);
console.log(todayStr);
console.log(tomorrowStr);

function addAut(mode, apId) {
	var date = dateToStr(new Date());

	console.log('mode: ' + mode);

	if (mode === 'tomorrow') {
		var tomorrow = new Date();
		tomorrow.setDate(tomorrow.getDate() + 1);
		date = dateToStr(tomorrow);
	}

	date = document.querySelector('html').getAttribute('data-date');

	console.log('date: ' + date);

	$.ajax({
		url: 'ajax-php/add-autonomous.php',
		type: 'POST',
		data: {date: date, ap_id: apId},
		success: function(data) {
			console.log(data);
			var result = JSON.parse(data);
			if (result.success) {
				alert('추가되었습니다.');
				window.location.reload();
			} else {
				alert(result['error_msg']);
			}
		},
		error: function(error) {

		},
		complete: function() {

		}
	});
}




// New Code

// 자경/식기 삭제
$('.autonomous-item').on('click', function() {
	if ($(this).hasClass('new-autonomous')) {
		return;
	}
	if (!confirm("삭제하시겠습니까?")) {
		return;
	}

	console.log('delete');

	var autData = $(this).data('autonomous');

	$.ajax({
		url: 'ajax-php/delete-autonomous.php',
		type: 'post',
		data: autData,
	})
	.done(function (data) {
		console.log("success");
		console.log(data);
		alert('삭제되었습니다.');
		window.location.reload();
	})
	.fail(function () {
		console.log("error");
	})
	.always(function () {
		console.log("complete");
	});
})

$('.autonomous-item.new-autonomous').on('click', function() {
	toggleSearchWindow();
})

$('.search-result-container').on('click', '.search-result-item', function () {
	addAut(mode, $(this).get(0).getAttribute('data-ap-id'));
})