var go_out_cost = 10;
var out_sleep_cost = 15;

function updateMilage(apID, addOrSubtract) {

	var milagePointDOM = document.querySelector('.ap[data-ap-id="' + apID + '"] .milage-point .data');


	var milageData = getMilageData(apID);

	var milagePoint = Number(milageData.milage);
	var milageGoOutCount = Number(milageData['milage_go_out']);
	var milageOutSleepCount = Number(milageData['milage_out_sleep']);

	var newMilagePoint = milagePoint;

	if (addOrSubtract === "add") {
		newMilagePoint = milagePoint + 1;
	} else if (addOrSubtract === "subtract") {
		newMilagePoint = milagePoint - 1;
		if (newMilagePoint < 0) {
			alert("마이너스는 안됩니다.");
			return;
		}
	}

	var availableMilagePoint = newMilagePoint - (go_out_cost * milageGoOutCount + out_sleep_cost * milageOutSleepCount);

	if (availableMilagePoint < 0) {
		alert("마이너스는 안됩니다.");
		return;
	}

	milagePointDOM.innerHTML = availableMilagePoint;

	$.ajax({
		url: 'php/update-milage.php',
		type: "post",
		data: "ap_id=" + apID + "&milage_point=" + newMilagePoint,

		success: function (data) {
			if (data) {
				alert("오류가 발생했습니다. " + data);
				milagePointDOM.innerHTML = milagePoint;
			}
		},
		error: function (error) {
			alert("오류가 발생했습니다.");
			milagePointDOM.innerHTML = milagePoint;
		},
		complete: function () {

		}
	});

}

document.querySelectorAll(".milage-point .plus").forEach(function (minusButton) {
	minusButton.addEventListener("click", function () {
		var apID = minusButton.closest(".ap").getAttribute("data-ap-id");
		updateMilage(apID, "add");
	});
});

document.querySelectorAll(".milage-point .minus").forEach(function(minusButton) {
	minusButton.addEventListener("click", function() {
		var apID = minusButton.closest(".ap").getAttribute("data-ap-id");
		updateMilage(apID, "subtract");
	});
});

function updateMilageUsage(apID, type, addOrSubtract) {

	var countDOM;

	var ajaxSendTypeName;

	var count;

	var milageData = getMilageData(apID);

	if (type === "goOut") {
		ajaxSendTypeName = "go_out";
		countDOM = document.querySelector('.ap[data-ap-id="' + apID + '"] .go-out-count .count-num');
		count = Number(milageData['milage_go_out']);
	} else if (type === "outSleep") {
		ajaxSendTypeName = "out_sleep";
		countDOM = document.querySelector('.ap[data-ap-id="' + apID + '"] .out-sleep-count .count-num');
		count = Number(milageData['milage_out_sleep']);
	}
	

	var newCount;

	if (addOrSubtract === "add") {
		newCount = count + 1;
	} else if (addOrSubtract === "subtract") {
		newCount = count - 1;
		if (newCount < 0) {
			alert("마이너스는 안됩니다.");
			return;
		}
	}

	if (type === "goOut") {
		var availableMilagePoint = milageData['milage'] - (go_out_cost * newCount + out_sleep_cost * milageData['milage_out_sleep']);
	} else if (type === "outSleep") {
		var availableMilagePoint = milageData['milage'] - (go_out_cost * milageData['milage_go_out'] + out_sleep_cost * newCount);
	}

	

	console.log(availableMilagePoint);

	if (availableMilagePoint < 0) {
		alert('마일리지가 부족합니다.');
		return;
	}

	countDOM.innerHTML = newCount;

	$.ajax({
		url: 'php/update-milage-usage.php',
		type: "post",
		data: "ap_id=" + apID + "&count=" + newCount + "&type=" + ajaxSendTypeName,

		success: function (data) {
			if (data) {
				alert("오류가 발생했습니다. " + data);
				countDOM.innerHTML = count;
			} else {
				updateMilage(apID);
			}
		},
		error: function (error) {
			alert("오류가 발생했습니다.");
			countDOM.innerHTML = count;
		},
		complete: function () {

		}
	});

}

document.querySelectorAll(".go-out-count .plus").forEach(function (minusButton) {
	minusButton.addEventListener("click", function () {
		var apID = minusButton.closest(".ap").getAttribute("data-ap-id");
		updateMilageUsage(apID, "goOut", "add");
	});
});

document.querySelectorAll(".go-out-count .minus").forEach(function (minusButton) {
	minusButton.addEventListener("click", function () {
		var apID = minusButton.closest(".ap").getAttribute("data-ap-id");
		updateMilageUsage(apID, "goOut", "subtract");
	});
});

document.querySelectorAll(".out-sleep-count .plus").forEach(function (minusButton) {
	minusButton.addEventListener("click", function () {
		var apID = minusButton.closest(".ap").getAttribute("data-ap-id");
		updateMilageUsage(apID, "outSleep", "add");
	});
});

document.querySelectorAll(".out-sleep-count .minus").forEach(function (minusButton) {
	minusButton.addEventListener("click", function () {
		var apID = minusButton.closest(".ap").getAttribute("data-ap-id");
		updateMilageUsage(apID, "outSleep", "subtract");
	});
});

function getMilageData(apID) {

	var milageData = {
		milage: 0,
		milage_go_out: 0,
		milage_out_sleep: 0
	}

	var returnData;

	$.ajax({
		url: 'php/get-milage-data.php',
		type: "post",
		async: false,
		data: "ap_id=" + apID,

		success: function (data) {
			returnData = JSON.parse(data);
		},
		error: function (error) {
			alert("마일리지 데이터를 가져오는데 오류가 발생했습니다.");
		},
		complete: function () {

		}
	});

	return returnData;
}

loadHistory()
// 마일리지 기록
function loadHistory() {
	$.ajax({
		url: 'php/get-milage-history.php',
		type: "post",

		success: function (data) {
			document.querySelector(".history .blackboard").innerHTML = data
		},
		error: function (error) {
			document.querySelector(".history .blackboard").innerHTML = "기록 데이터를 가져오는 데 오류가 발생했습니다."
		},
		complete: function () {
	
		}
	})
}


let editting, saving, saved
document.querySelector(".history .blackboard").addEventListener("input", e => {
	clearTimeout(this.wait)
	clearTimeout(saved)

	document.querySelector(".history .title .activity").innerHTML = "수정중..."
	
	this.wait = setTimeout(function() {
		console.log('auto update...');
		document.querySelector(".history .title .activity").innerHTML = "저장중..."
		updateHistory();
	}, 700);
})

function updateHistory() {
	$.ajax({
		url: 'php/update-milage-history.php',
		type: "post",
		data: {content: document.querySelector(".history .blackboard").value},
	
		success: function (data) {
			if (data) console.log(data)
			saved = setTimeout(() => {
				document.querySelector(".history .title .activity").innerHTML = "저장됨"
			}, 500)
		}
	})
}