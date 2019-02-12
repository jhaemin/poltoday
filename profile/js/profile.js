

// START
// Change AP info

// Change roll
var rollItems = document.querySelectorAll('.roll-item');
rollItems.forEach( function(item, index) {
	item.addEventListener('click', function() { 
		if (this.classList.contains('selected')) {return;}

		var name = document.querySelector('.name').textContent;
		var rollName = this.textContent;

		if (confirm(name + ' 대원은 이제 ' + rollName + '입니다. 변경 기록은 삭제할 수 없습니다.')) {
			// document.querySelector('.roll-item.selected').classList.remove('selected');
			// this.classList.add('selected');
			var apID = document.querySelector('.information').getAttribute('data-ap-id');
			var newRoll = this.getAttribute('data-roll-id');
			var date = document.querySelector('.roll .date-input').value;
			updateProfile(apID, 'roll', newRoll, date);
		}
	});
});

// Change platoon
var platoonItems = document.querySelectorAll('.platoon-item');
platoonItems.forEach( function(item, index) {
	item.addEventListener('click', function() {
		if (this.classList.contains('selected')) {return;}

		var name = document.querySelector('.name').textContent;
		var platoonName = this.textContent;

		if (confirm(name + ' 대원은 이제 ' + platoonName + '입니다. 변경 기록은 삭제할 수 없습니다.')) {
			// document.querySelector('.roll-item.selected').classList.remove('selected');
			// this.classList.add('selected');
			var apID = document.querySelector('.information').getAttribute('data-ap-id');
			var newPlatoon = this.getAttribute('data-platoon-id');
			var date = document.querySelector('.platoon .date-input').value;
			updateProfile(apID, 'platoon', newPlatoon, date);
		}
	});
});

function updateProfile(apID, colName, value, today) {
	console
	$.ajax({
		url: 'update-profile.php',
		type: 'GET',
		data: 'ap_id=' + apID + '&' + colName + '=' + value + '&date=' + today,
	})
	.done(function(data) {
		// alert(data);
		location.reload();
	})
	.fail(function() {
		console.log("error");
	})
	.always(function() {
		console.log("complete");
	});
}
// Change AP info
// END


// START
// Move out
if (document.querySelector('.move-out-btn')) {
	document.querySelector('.move-out-btn').addEventListener("click", function() {
		var date = document.querySelector('.move-out .date-input').value;
		var apID = document.querySelector('.information').getAttribute('data-ap-id');
		var moveOut = 1;
		
		if (confirm("모든 페이지에서 이 대원의 정보가 사라집니다.")) {
			updateProfile(apID, 'moved_out', moveOut, date);
		}
	});
}
// END
// Move out