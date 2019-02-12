
// document.querySelector('#chart-width-controller').addEventListener('input', function() {
// 	var width = this.value;
// 	document.querySelector('.whole-table').style.maxWidth = "calc(" + width + "% - 40px)";
// })

$('.password-input').on('keydown', function(e) {
	var pass = $('.password-input').val();
	console.log(pass);
	if (pass === "rnldyal" && e.which === 13) {
		console.log('same');
		$(this).val("");
		$(this).blur();
		$('.table.govern').css('display', 'table');
	}
});

window.addEventListener("keydown", e => {
	if (e.key === "Escape") {
		closeNewActivityWindow()
	}
})

// START
// Adding a new activity by selecting empty dates
var dateSelected = false;

$('.whole-table').on('click', '.emptyDate', function() {
	if (!dateSelected) {
		$(this).addClass('selected');
		dateSelected = true;
		$selectedDate = $(this);
	} else if ($(this).hasClass('selected')) {
		$(this).removeClass('selected');
		dateSelected = false;
	} else {
		$outDate = $('.emptyDate.selected');
		$inDate = $(this);

		if ($outDate.parents('.row').data('row-num') !== $inDate.parents('.row').data('row-num')) {
			console.log('different row');
			clearDateSelection();
			return;
		} else if ($outDate.parents('.row').data('row-num') === $inDate.parents('.row').data('row-num')) {
			// console.log('same row');
			addActivity($('.emptyDate.selected').data('date'), $(this).data('date'));
		}
	}
});

function clearDateSelection() {
	$('.emptyDate.selected').removeClass('selected');
	dateSelected = false;
}


// Adding activity
function addActivity(first, second) {

	var outAt;
	var inAt;
	if (first < second) {
		outAt = first;
		inAt = second;
	} else {
		outAt = second;
		inAt = first;
	}

	// console.log(outAt);
	// console.log(inAt);

	// Initialize the new activity window
	$('.interval-display').text(thisYear + ". " + thisMonth + ". " + outAt + " - " + thisYear + ". " + thisMonth + ". " + inAt);

	$('.out-at').val(thisYear + "-" + thisMonth + "-" + outAt);
	$('.in-at').val(thisYear + "-" + thisMonth + "-" + inAt);

	clearDateSelection();
	$('.type.ap-input').prop('selected', function() {
        return this.defaultSelected;
    });
	$('.ap-input-placeholder').html('대원 선택');
	$('.ap-id.ap-input').val("");
	$('.display-name.ap-input').val("");

	$('.add-activity-wrapper').removeClass('hidden');
	setTimeout(function() {
		$('.add-activity-wrapper').addClass('active');
	}, 0);
}

// Close new activity window
function closeNewActivityWindow() {
	$('.add-activity-wrapper').removeClass('active');
	setTimeout(function() {
		$('.add-activity-wrapper').addClass('hidden');
	}, 300);
}

// deactive window
$('.add-activity-background').on('click', function() {
	closeNewActivityWindow();
});

// Searching ap module
$('.ap-input-placeholder').on('click', function() {
	toggleSearchWindow();
});

$('.search-result-container').on('click', '.search-result-item', function() {
	var apId = $(this).data('ap-id');
	var name = $(this).find('.col-search-result-name').text();
	closeSearchWindow();

	$('.ap-input-placeholder').text(name);
	$('.ap-id.ap-input').val(apId);
});

document.querySelector('.add-activity-form .cancel').addEventListener('click', function() {
	closeNewActivityWindow();
});

$('.add-activity-form').on('submit', function(e) {
	e.preventDefault();

	// if ()

	var serializedData = $(this).serialize();
	// console.log(serializedData);

	$.ajax({
		url: '/ajax-php/add-ap-outside-activity-submit.php',
		type: "post",
		data: serializedData,

		success: function(data){

			console.log(data);

			var result = JSON.parse(data);
			if (result['sql_error']) {
				var msg = 'SQL 에러: ' + result['sql_error'];
				alert(msg);
			}
			if (result['msg']) {
				var msg = result['msg'];
				alert(msg);
			} else {
				closeNewActivityWindow();
				alert('등록됨');
				sessionStorage.setItem('scrollTop', $(window).scrollTop());
				document.location.reload();
			}

	    },
		error: function(error) {

		},
		complete: function() {

		}
	});
});

// Add new activity
// END

// Moving activity item
var activityWillMove = false;
var initX, initY, nextX, nextY;
$('.whole-table').on('mousedown', '.col.planned', function(e) {

	if (event.button === 1 || event.button === 2) return;

	$(this).addClass('moving');
	activityWillMove = true;

	initX = nextX = e.pageX;
	initY = nextY = e.pageY;
});

$('.whole-table').on('mouseup', '.col.planned', function(event) {

	if (event.button === 1 || event.button === 2) return;

	$('.col.planned.moving').css('left', 0);
	$('.col.planned.moving').css('top', 0);

	$(this).removeClass('moving');

	activityWillMove = false;

	if (initX === nextX && initY === nextY) {
		// console.log('okay');
		activeBubble(event.target);
	} else {
		activityIsMoved = false;
	}
});


$(window).on('mousemove', function(e) {

	if (activityWillMove) {
		deactiveBubble();
		nextX = e.pageX;
		nextY = e.pageY;
		$('.col.planned.moving').css('left', nextX - initX);
		$('.col.planned.moving').css('top', nextY - initY);
	}
});

// Popup bubble
function activeBubble(target) {

	var activityItem = target;
	// console.log(activityItem.getBoundingClientRect());

	var activityId = target.dataset.activityId;

	var actItemRect = activityItem.getBoundingClientRect();

	var bubble = document.querySelector('.action-bubble');

	document.querySelector('.ab-background').removeAttribute('style');

	bubble.setAttribute('data-activity-id', activityId);

	bubble.style.left = actItemRect.left +
		(actItemRect.width - bubble.getBoundingClientRect().width) / 2 + "px";

	bubble.style.top = actItemRect.top -
		bubble.getBoundingClientRect().height - 3 + "px";

	console.log(bubble.getBoundingClientRect().left);
	console.log(window.innerWidth);

	if (bubble.getBoundingClientRect().right >= window.innerWidth) {


		document.querySelector('.ab-background').style.right =
			bubble.getBoundingClientRect().right - window.innerWidth + 30 + "px";
	}

	if (bubble.getBoundingClientRect().left <= 0) {
		document.querySelector('.ab-background').style.left =
			- bubble.getBoundingClientRect().left + 10 + "px";
	}

	$(bubble).addClass('active');

	activityIsMoved = false;
}

function deactiveBubble() {
	var bubble = document.querySelector('.action-bubble');
	$(bubble).removeClass('active');
	bubble.removeAttribute('data-activity-id');
}

// Window scrolling events
window.addEventListener("scroll", function() {
	deactiveBubble();
});

// Deactive bubble when click anywhere except itself
window.addEventListener("click", function(event) {

	if (!event.target.classList.contains('planned') &&
		!event.target.classList.contains('ab-delete') &&
		!event.target.classList.contains('ab-edit') &&
		$('.action-bubble').hasClass('active')) {

		deactiveBubble();
	}
});

// Remove activity when click delete inside the bubble
document.querySelector('.ab-delete').addEventListener('click', function() {
	removeActivity(document.querySelector('.action-bubble').getAttribute('data-activity-id'));
}, true);

// Activate edit mode when click 'edit' button inside the bubble
document.querySelector('.ab-edit').addEventListener('click', function() {
	var eventID = Number(document.querySelector('.action-bubble').getAttribute('data-activity-id'));
	console.log(eventID);
	var eventDOM = document.querySelector('.col.planned[data-activity-id="' + eventID + '"]');
	var outAt = eventDOM.getAttribute('data-out-at');
	var inAt = eventDOM.getAttribute('data-in-at');
	var type = Number(eventDOM.getAttribute('data-type'));
	var displayName = eventDOM.textContent;
	var outTime = eventDOM.getAttribute('data-out-time');
	var inTime = eventDOM.getAttribute('data-in-time');

	displayName = displayName.slice(displayName.indexOf(' - ') + 3);
	activateEditMode(eventID, outAt, inAt, type, displayName, outTime, inTime);
}, true);

// Remove activity item
function removeActivity(activityId) {

	if (!confirm("정말 삭제하시겠습니까? 사고자리스트에 반영됩니다.")) {
		return;
	}

	$.ajax({
		url: '/ajax-php/ap-outside-activity-functions.php',
		type: "post",
		data: {activity_id: activityId, mode: "remove"},

		success: function(data){

			if (data === "success") {
				deactiveBubble();
				removeActivityUI(activityId);
			} else if (data === "fail") {

			}

	    },
		error: function(error) {

		},
		complete: function() {

		}
	});
}

// Update Activity
function updateActivity(activityId, data) {

}

// Remove activity and update ui
function removeActivityUI(activityId) {
	console.log(activityId);
	var target = document.querySelectorAll('[data-activity-id="' + activityId + '"]')[0];
	// console.log(target);

	var interval = target.getAttribute('colspan');
	// console.log(interval + "일");

	var startDate = target.getAttribute('data-date');

	for (var i = 0; i < interval; i++, startDate++) {
		var emptyDay = generateEmptyDay(startDate);

		target.parentNode.insertBefore(emptyDay, target);
	}

	target.parentNode.removeChild(target);
}

// Add activity and update ui
function addActivityUI() {

}
