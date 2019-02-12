'use strict';

function activateEditMode(eventID, outAt, inAt, type, displayName, outTime, inTime, note) {
	$('#edit-event-module .event-id').val(eventID);
    $('#edit-event-module .out-at').val(outAt);
    $('#edit-event-module .in-at').val(inAt);
    $('#edit-event-module .type').val(type);
    $('#edit-event-module .display-name').val(displayName);
    $('#edit-event-module .out-time').val(outTime);
	$('#edit-event-module .in-time').val(inTime);
	$('#edit-event-module .note').val(note);
    $('#edit-event-module').removeClass('hidden');
}

function closeEditMode() {
	$('#edit-event-module').addClass('hidden');
	$('#edit-event-module input').val('');
	$('#edit-event-module select').val(0);
}

// Event Listeners
$('.discard-changes').on('click', function() {
	closeEditMode();
});

$('.editting-background').on('click', function() {
	closeEditMode();
});

$('.save-changes').on('click', function() {
	if (!confirm("수정하시겠습니까?")) {
		return;
	}
	var $data = $('.editting-window').find('input, select');
	console.log($data);
	var serializedData = $data.serialize();
	console.log(serializedData);
	$.ajax({
		url: '/edit-event-module/edit-event.php',
		type: 'post',
		data: serializedData,
	})
	.done(function(data) {
		if (data) {
			console.log(data);
		} else {
			sessionStorage.setItem('scrollTop', $(window).scrollTop());
			document.location.reload();
		}
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});

});

window.addEventListener("keydown", e => {
	if (e.key === "Escape") {
		closeEditMode()
	}
})