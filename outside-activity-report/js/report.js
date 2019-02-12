function updateReport(timeElm, contentElm, timeUpdate) {
	var exactTime = timeElm.innerHTML;
	var reportID = contentElm.getAttribute('data-report-id');
	var apID = contentElm.getAttribute('data-ap-id');
	
	$.ajax({
		url: 'update-outside-report.php',
		type: 'post',
		data: {
			report_id: reportID,
			ap_id: apID,
			time_update: timeUpdate,
			exact_time: exactTime
		}
	})
	.done(function(data) {
		console.log(data);
		parsedData = JSON.parse(data);
		if (Number(parsedData['time_update'])) {
			console.log('time updated too');
			timeElm.innerHTML = parsedData['exact_time'];
		}
		if (Number(parsedData['first_set'])) {
			
		}
	})
}

$('.td-report-time').on('keydown', function(e) {
	var self = $(this).get(0);
	var infoElm = self.nextElementSibling;
	if (e.which === 13) {
		e.preventDefault();
		self.blur();

		var exactTime = self.innerHTML;
		console.log(exactTime);
		var reportID = infoElm.getAttribute('data-report-id');
		var apID = infoElm.getAttribute('data-ap-id');
		var timeUpdate = 1;

		$.ajax({
			url: 'update-outside-report.php',
			type: 'post',
			data: {
				report_id: reportID,
				ap_id: apID,
				time_update: timeUpdate,
				exact_time: exactTime
			},
		})
		.done(function(data) {
			console.log(data);
			data = JSON.parse(data);
			console.log(Number(data['time_update']));
			if (Number(data['time_update'])) {
				console.log('time updated too');
				self.innerHTML = data['exact_time'];
			}
			if (Number(data['first_set'])) {
				self.previousElementSibling.innerHTML = data['exact_time'];
				self.previousElementSibling.setAttribute('contenteditable', true);
			}
			self.setAttribute('data-report-id', data['report_id']);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}
});

$('.td-report-contents').on('keyup', function(e) {
	var self = $(this).get(0);
    // if (self.textContent === "집") {
	// 	self.textContent = "집에서 휴식 중";
	// 	self.blur();
	// 	self.focus();
	// 	var sel = window.getSelection();
	// 	var range = document.createRange();
	// 	range.setStart(self, self.childNodes.length);
	// 	sel.removeAllRanges();
	// 	sel.addRange(range);
    // }
});


$('.td-report-contents').on('keydown', function(e) {
	var self = $(this).get(0);
	var update = false;
	var timeUpdate = 0;
	var optionSelected = false;
	if (e.ctrlKey && e.which === 13) {
        // 컨트롤 엔터
		console.log('update with time');
		update = true;
		timeUpdate = 1;
		console.log(timeUpdate);
	} else if (e.which === 13 && !e.ctrlKey) {
		// 엔터만 칠 때
		update = true;
		console.log('only update content');
		timeUpdate = 0;
		console.log(timeUpdate);

		// 옵션박스 목록이 선택된 상태에서 엔터
		if (document.querySelector('.option-box .item.hover')) {
			e.stopPropagation();
			e.preventDefault();
			console.log('action box item hovered');
			var content = document.querySelector('.option-box .item.hover').innerHTML;
			insertReportContent(content);

			return;
		}

	} else if (e.which === 27) {
        // esc키 눌렀을 때
		self.innerHTML = "";
		self.blur();
    }

	if (update) {
		e.preventDefault();
		self.blur();

		var reportID = self.getAttribute('data-report-id');
		var apID = self.getAttribute('data-ap-id');
		var reportContents = self.textContent;
		var reportAt = self.getAttribute('data-report-at');
        console.log(reportID + " " + apID + " " + reportContents);
        
        if (reportContents.replace(/\s/ig, "") === "") {
            console.log('empty string');
            return;
        }

		$.ajax({
			url: 'update-outside-report.php',
			type: 'post',
			data: {
				report_id: reportID,
				ap_id: apID,
				report_contents: reportContents,
				report_at: reportAt,
				time_update: timeUpdate
			},
		})
		.done(function(data) {
			data = JSON.parse(data);
			console.log(Number(data['time_update']));
			if (Number(data['time_update'])) {
				console.log('time updated too');
				self.previousElementSibling.innerHTML = data['exact_time'];
				self.previousElementSibling.setAttribute('contenteditable', true);
			}
			if (Number(data['first_set'])) {
				self.previousElementSibling.innerHTML = data['exact_time'];
				self.previousElementSibling.setAttribute('contenteditable', true);
			}
			self.setAttribute('data-report-id', data['report_id']);
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	}
});

// 보고내용 포커스 인
$('.td-report-contents').on('focusin', function() {
	$(this).addClass('selected');
});


// 보고내용 포커스 아웃
$('.td-report-contents').on('focusout', function(e) {
	$(this).removeClass('selected');
	hideOptionBox();
});

// 보고내용 클릭
$('.td-report-contents').on('click', function(e) {
	var selfRect = $(this).get(0).getBoundingClientRect();
	var optBox = $('.option-box').get(0);
	showOptionBox(selfRect.top + selfRect.height + 10 + 'px', selfRect.left + 10 + 'px');
});



function insertReport(elm, apID, reportAt, reportContents) {
	// Update UI
	elm.innerHTML = reportContents;
	elm.previousElementSibling.innerHTML = reportAt;
}

$('.agent-option').on('change', function() {
	console.log('changed');
	var agentID = $(this).val();
	var agentAt = document.querySelector('html').getAttribute('data-today');
	console.log(agentID);
	console.log(agentAt);
	$.ajax({
		url: 'update-agent.php',
		type: 'post',
		data: {agent_id: agentID, agent_at: agentAt},
	})
	.done(function(data) {
		if (data) {
			alert(data);
		} else {
			location.reload();
		}
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
	
});

$(window).on('scroll', function() {
	hideOptionBox();
});

// 옵션박스

// 옵션박스 가리기
function hideOptionBox () {
	$('.option-box').css('display', 'none');
	$('.option-box .item').removeClass('hover');
}

// 옵션박스 보이기
function showOptionBox (top, left) {
	$('.option-box').css('display', 'block');
	var optBox = $('.option-box').get(0);
	optBox.style.top = top;
	optBox.style.left = left;
}

// 옵션박스 아이템 클릭
$('.option-box .item').on('mousedown', function(e) {
	e.preventDefault();
	var content = $(this).get(0).textContent;
	console.log(content);
	insertReportContent(content);
});

// 옵션박스


// 현재 선택된 보고내용 칸에 보고내용 입력
function insertReportContent (content) {
	$('.td-report-contents.selected').html(content);
	hideOptionBox();
}


// Event Listeners

// 보고내용에서 키보드로 옵션박스 목록 이동
$('.td-report-contents').on('keydown', function (e) {
	console.log(e.which);
	// 40 : down key
	// 38 : up key

	var keyCode = e.which;
	
	if (keyCode === 40) {
		if (document.querySelector('.option-box .item.hover')) {
			var current = document.querySelector('.option-box .item.hover');
			current.classList.remove('hover');

			if (current.nextElementSibling) {
				current.nextElementSibling.classList.add('hover');
			} else {
				document.querySelector('.option-box .item').classList.add('hover');
			}

		} else {
			document.querySelector('.option-box .item').classList.add('hover');
		}
	} else if (keyCode === 38) {
		if (document.querySelector('.option-box .item.hover')) {
			var current = document.querySelector('.option-box .item.hover');
			current.classList.remove('hover');

			if (current.previousElementSibling) {
				current.previousElementSibling.classList.add('hover');
			} else {
				document.querySelector('.option-box .item:last-child').classList.add('hover');
			}

		} else {
			document.querySelector('.option-box .item:last-child').classList.add('hover');
		}
	}
})

// 옵션박스 hover
$('.option-box .item').on('mouseover', function () {
	$('.option-box .item').removeClass('hover');
	$(this).addClass('hover');
})

$('.option-box .item').on('mouseout', function () {
	$('.option-box .item').removeClass('hover');
})