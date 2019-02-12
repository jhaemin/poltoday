$(document).ready(function() {
	// $('.activity-item').on('click', function() {
	// 	activeBubble($(this).get(0));
	// });

	// $(window).on('click', function(e) {
	// 	console.log(e.target);
	// 	if (!e.target.classList.contains('activity-item')) {
	// 		deactiveBubble();
	// 	}
	// });

	// $(window).on('scroll', function() {
	// 	deactiveBubble();
	// });

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
});


// 대원 이름에 마우스 갖다댔을때 정보 띄우기
$('.ap-name').on('mouseover', function () {
	var apID = Number($(this).get(0).getAttribute('data-ap-id'));
	showAPInfo(apID, $(this).get(0));
})

$('.ap-name').on('mouseout', function () {
	hideAPInfoBubble();
})

/**
 * 
 * @param {Number} apID 
 * @param {HTMLElement} elm 
 */
function showAPInfo (apID, elm) {
	$.ajax({
		url: '/ajax-php/get-ap-info.php',
		type: 'post',
		data: {
			apID: apID
		},
	})
	.done(function(data) {
		// Parse fetched data
		var apInfo = JSON.parse(data);

		setAPInfoBubble(apInfo);

		// Set UI position
		var bubble = document.querySelector('.ap-info-bubble');
		var left = elm.getBoundingClientRect().left - bubble.getBoundingClientRect().width / 2 + elm.getBoundingClientRect().width / 2 + "px";
		var top = -3 + elm.getBoundingClientRect().top - bubble.getBoundingClientRect().height + 'px';
		bubble.style.left = left;
		bubble.style.top = top;

		showAPInfoBubble();

	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		// console.log("complete");
	});
}

function setAPInfoBubble (apInfo) {
	document.querySelector('.ap-info-bubble .level .contents').innerHTML = apInfo.level + "기";
	var phoneNum = apInfo['phone_number'];
	document.querySelector('.ap-info-bubble .phone-num .contents').innerHTML = phoneNum;
	document.querySelector('.ap-info-bubble .mom-phone-num .contents').innerHTML = apInfo["mother_pn"];
	document.querySelector('.ap-info-bubble .dad-phone-num .contents').innerHTML = apInfo["father_pn"];
	// document.querySelector('.ap-info-bubble .birthday').innerHTML = apInfo.birthday;
	document.querySelector('.ap-info-bubble .military-num .contents').innerHTML = apInfo['military_serial_number'];
}

function showAPInfoBubble () {
	document.querySelector('.ap-info-bubble').classList.add('shown');
}

function hideAPInfoBubble () {
	document.querySelector('.ap-info-bubble').classList.remove('shown');
}

document.querySelector('body').addEventListener('click', function (e) {
	hideAPInfoBubble();
})

document.addEventListener('scroll', function () {
	hideAPInfoBubble();
})