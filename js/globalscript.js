window.onload = function() {

	Notification.requestPermission(function (status) {
		if (Notification.permission !== status) {
			Notification.permission = status
		}
	})

	if (Notification && Notification.permission !== "granted") {
		Notification.requestPermission(function (status) {
			if (Notification.permission !== status) {
				Notification.permission = status
			}
		})
	}

	document.addEventListener('scroll', function() {
		if (document.querySelector('body').getBoundingClientRect().top < 0) {
			document.querySelector('.globalnav').classList.add('scrolling');
		} else {
			document.querySelector('.globalnav').classList.remove('scrolling');
		}
	})

	// START
	// Global Navigation
	var items = document.querySelectorAll('.gn-item');

	items.forEach( function(item, index) {

		

		item.addEventListener('click', function() {
			// closeAllDropDownMenus();
			if (this.classList.contains('active')) {
				closeAllDropDownMenus();
			} else {
				closeAllDropDownMenus();
				var dropDown;
				if (dropDown = item.parentElement.querySelector('.gn-item-dropdown')) {
					this.classList.toggle('active');
					dropDown.classList.toggle('hidden');
				} else {
				}
			}
		});

	});

	function closeAllDropDownMenus() {
		var dropDowns = document.querySelectorAll('.gn-item-dropdown');
		dropDowns.forEach( function(dropDown, index) {
			dropDown.classList.add('hidden');
		});
		var gnItems = document.querySelectorAll('.gn-item');
		gnItems.forEach( function(item, index) {
			item.classList.remove('active');
		});
	}

	window.addEventListener('click', function(event) {
		if (!event.target.classList.contains('gn-link')) {
			closeAllDropDownMenus();
		}
	});
	window.onscroll = function() {
		closeAllDropDownMenus();
	}
	// Global Navigation
	// END

	$('.date-input').on('keydown', function(e) {
		var target = e.target;
		console.log(e.which);
		var dateString;
		if (target.value) {
			dateString = target.value.replace(/\D/ig, "");
		} else {
			dateString = target.innerHTML.replace(/\D/ig, "");
		}

		if (dateString.length === 8) {
			console.log('over');
			if (e.which === 8 || e.which === 37 || e.which === 39 || e.which === 13 || e.which === 9) {
				return;
			} else {
				return false;
			}
		}
	});

	// START
	// Input Date
	document.addEventListener('input', function(e) {
		if (e.target && e.target.classList.contains('date-input')) {
			var target = e.target;
			var dateString;
			if (target.value) {
				dateString = target.value.replace(/\D/ig, "");
			} else {
				dateString = target.innerHTML.replace(/\D/ig, "");
			}

			// console.log(dateString);

			// if (Number(dateString[0]) !== 2 && Number(dateString[0]) !== 1) {
			// 	target.value = "";
			// 	return;
			// }

			if (dateString.length > 8) {
				dateString = dateString.slice(0, 8);
			}
			if (dateString.length > 6) {
				dateString = dateString.slice(0, 4) + "-" + dateString.slice(4, 6) + "-" + dateString.slice(6, dateString.length + 1);
			} else if (dateString.length > 4) {
				dateString = dateString.slice(0, 4) + "-" + dateString.slice(4, dateString.length + 1);
			}

			if (target.value) {
				target.value = dateString;
			} else {
				target.innerHTML = dateString;
				var sel = window.getSelection();
				var range = sel.getRangeAt(0);
				console.log(range);
				range.setStart(target.firstChild, target.firstChild.textContent.length);
			}
		}

		// Phone number input formatting
		if (e.target && e.target.classList.contains('phone-number-input')) {
			var target = e.target;
			var dateString;
			if (target.value) {
				dateString = target.value.replace(/\D/ig, "");
			} else {
				dateString = target.innerHTML.replace(/\D/ig, "");
			}

			// console.log(dateString);

			if (Number(dateString[0]) !== 0) {
				target.value = "";
				return;
			}

			if (dateString.length > 11) {
				dateString = dateString.slice(0, 11);
			}
			if (dateString.length > 10) {
				dateString = dateString.slice(0, 3) + "-" + dateString.slice(3, 7) + "-" + dateString.slice(7, dateString.length + 1);
			} else if (dateString.length > 7) {
				dateString = dateString.slice(0, 3) + "-" + dateString.slice(3, 6) + "-" + dateString.slice(6, dateString.length + 1);
			} else if (dateString.length > 3) {
				dateString = dateString.slice(0, 3) + "-" + dateString.slice(3, dateString.length + 1);
			}

			if (target.value) {
				target.value = dateString;
			} else {
				target.innerHTML = dateString;
				var sel = window.getSelection();
				var range = sel.getRangeAt(0);
				console.log(range);
				range.setStart(target.firstChild, target.firstChild.textContent.length);
			}
		}

		// Only number input foramtting
		if (e.target && e.target.classList.contains('only-number-input')) {
			var target = e.target;
			var str = target.value.replace(/\D/ig, "");
			target.value = str;
		}

		// time input formatting
		if (e.target && e.target.classList.contains('time-input')) {
			var target = e.target;
			var timeString;

			if (target.value) {
				timeString = target.value.replace(/\D/ig, "");
			} else {
				timeString = target.innerHTML.replace(/\D/ig, "");
			}

			console.log(timeString);

			if (timeString.length > 4) {
				timeString = timeString.slice(0, 4);
			}
			if (timeString.length > 2) {
				timeString = timeString.slice(0, 2) + ":" + timeString.slice(2, timeString.length + 1);
			}

			console.log("converted: " + timeString);

			if (target.value) {
				target.value = timeString;
			} else {
				target.innerHTML = timeString;
				var sel = window.getSelection();
				var range = sel.getRangeAt(0);
				console.log(range);
				range.setStart(target.firstChild, target.firstChild.textContent.length);
			}
		}
	});
	// Input Date
	// END

	// $('.time-input').on('click', function() {
	// 	var target = $(this).get(0);
	// 	if (target.value) {

	// 	} else {
	// 		var sel = window.getSelection();
	// 		sel.removeAllRange();
	// 		var range = document.createRange();
	// 		range.setStart(target.firstChild, 0);
	// 		range.setEnd(target.firstChild, target.firstChild.textContent.length);
	// 		sel.addRange(range);
	// 	}
	// });

    // 시간 입력
	$('.time-input').on('focus', function() {
		var target = $(this).get(0);
		if (target.value) {

		} else {
			var sel = window.getSelection();
			var range = document.createRange();
			range.setStart(target.firstChild, 0);
			range.setEnd(target.firstChild, target.firstChild.textContent.length);
			sel.removeAllRanges();
			sel.addRange(range);
		}
	});


	// 전반 모드 켬/끔
	$('.power-on').on('click', function() {
		var mode;
		if ($('html').hasClass('jb-mode')) {
			$('html').removeClass('jb-mode');
			mode = 'unset';
		} else {
			$('html').addClass('jb-mode');
			mode = 'set';
		}

		$.ajax({
			url: '/ajax-php/set-jb-mode.php',
			type: 'post',
			data: {mode: mode},
		})
		.done(function(data) {
			if (data) {
				console.log(data);
			}
		})
		.fail(function() {
			console.log("error");
		})
		.always(function() {
			console.log("complete");
		});
	});

	// 전반모드일 경우 html에 전반모드 여부 표시
	$.ajax({
		url: '/ajax-php/check-jb-mode.php',
	})
	.done(function(data) {
		if (data === 'true') {
			$('html').addClass('jb-mode');
		} else {
			$('html').removeClass('jb-mode');
		}
	})
	.fail(function() {
		console.log("전반모드 AJAX 에러");
	})
	.always(function() {
		// console.log("complete");
	});

	// 페이지 사이즈 조절
	$('#page-font-controller').on('input', function(e) {
		console.log($(this).val());
		$('.page-adjustable').css('font-size', $(this).val() + 'px');
	});

	window.addEventListener("dragstart", e => {
		e.preventDefault()
	})
	
}

/**
 *
 * @param {boolean} isLight
 */
function generateLoadingBar(height, isLight = false) {
	let lb = document.createElement("div")
	lb.className = "loading-bar"
	if (isLight) {
		lb.classList.add("light")
	}

	if (height) {
		lb.style.height = height
	}

	lb.innerHTML = '<div class="wrapper">' +
		'<div class="moving-part"></div>' +
	'</div>'

	return lb
}