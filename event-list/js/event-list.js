var modifyBtns = document.querySelectorAll('.event-modify');
modifyBtns.forEach( function(btn, index) {
	btn.addEventListener('click', function() {

	});
});

var deleteBtns = document.querySelectorAll('.event-delete');
deleteBtns.forEach( function(item, index) {
	item.addEventListener('click', function() {

		if (!confirm('정말 삭제하시겠습니까? 사고자리스트에 반영됩니다.')) {
			return;
		}

		var $eventItem = $(this).parents('.event-item');
		var activityId = $eventItem.data('event-id');

		$.ajax({
			url: '/ajax-php/ap-outside-activity-functions.php',
			type: 'POST',
			data: {activity_id: activityId, mode: "remove"},
		})
		.done(function() {
			// console.log("success");
			$eventItem.remove();
		})
		.fail(function() {
			// console.log("error");
		})
		.always(function() {
			// console.log("complete");
		});

	});
});

$('.event-modify').on('click', function() {
	var eventDOM = $(this).parents('.event-item').get(0);
	var eventID = Number(eventDOM.getAttribute('data-event-id'));
	var outAt = eventDOM.getAttribute('data-out-at');
	var inAt = eventDOM.getAttribute('data-in-at');
	var type = eventDOM.getAttribute('data-type');
	var displayName = eventDOM.getAttribute('data-display-name');
	var outTime = eventDOM.getAttribute('data-out-time');
	var inTime = eventDOM.getAttribute('data-in-time');
	var note = eventDOM.getAttribute('data-note');
	activateEditMode(eventID, outAt, inAt, type, displayName, outTime, inTime, note);
});
