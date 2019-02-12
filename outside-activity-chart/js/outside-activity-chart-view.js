var today = new Date($('.whole-table').data('date'));
var thisYear = today.getFullYear();
var thisMonth = today.getMonth() + 1;

// Count the number of days of given month and year
var totalDays = lastday(thisYear, thisMonth);

// Calculate lastday of the given month and year
function lastday(y, m) {
	return new Date(y, m, 0).getDate();
}

// Generate tables for each platoon
function generateChart(list) {


	generateChartRow(list[1], 1);
	generateChartRow(list[2], 2);
	generateChartRow(list[3], 3);
	generateChartRow(list[0], 0);
	generateChartRow(list[4], 'g');

}

// Generate empty day
function generateEmptyDay(thisDay) {
	var emptyDay = document.createElement("td");
	emptyDay.className = "col emptyDate";
	emptyDay.setAttribute('data-date', thisDay);
	emptyDay.innerHTML = "&nbsp;";

	return emptyDay;
}

// Generate a table for platoon parameter
function generateChartRow(list, platoon) {

	// Set a platoon to activities
	var colorClass;
	switch (platoon) {
		case 0:
			colorClass = "p0 planned";
			break;
		case 1:
			colorClass = "p1 planned";
			break;
		case 2:
			colorClass = "p2 planned";
			break;
		case 3:
			colorClass = "p3 planned";
			break;
		case 'g':
			colorClass = "govern planned";
			break;
	}

	var platoonWrapper = document.createElement("table");

	platoonWrapper.className = "table platoon-container" + " platoon-" + platoon;
	if (platoon === "g") {
		// platoonWrapper.className = "table platoon-container section-not-to-print"
		platoonWrapper.className = "table platoon-container"
	}

	if (platoon === 'g') {
		platoonWrapper.classList.add('govern');
		// platoonWrapper.classList.add('section-not-to-print');
	}

	var dateRow = document.createElement("th");

	dateRow.className = "row row-0 row-date";

	// How many members go out at the day?
	var countOfDay = [];

	// Generate rows
	for (var k = 0; k < 9999; k++) {

		var actRow = document.createElement("tr");
		actRow.className = "row";
		actRow.setAttribute('data-row-num', k);

		for (var i = 0; i < totalDays; i++) {

			var existAtDay = false;

			var thisDay = i + 1;

			for (var j = 0; j < list.length; j++) {

				var outDate = new Date(list[j]['out_at']);
				var inDate = new Date(list[j]['in_at']);

				var outMonth = outDate.getMonth() + 1;
				var inMonth = inDate.getMonth() + 1;

				var outDay = outDate.getDate();
				var inDay = inDate.getDate();
				let outYear = outDate.getFullYear()
				let inYear = inDate.getFullYear()

				// console.log(outDate.getTime());

				// 영외활동이 며칠인지 계산
				// 차이 ms / 하루 ms
				var interval = Math.floor((inDate.getTime()
					- outDate.getTime()) / (1000 * 60 * 60 * 24));

				if (
					thisDay === 1 &&
					(outYear < thisYear || (outYear === thisYear && outMonth < thisMonth)) &&
					inYear === thisYear &&
					inMonth === thisMonth &&
					thisDay <= inDay) {
					// 이번달 이전부터 이번달

					var activity = document.createElement("td");
					activity.className = "col hang-prev " + colorClass;

					activity.colSpan = inDay;

					activity.innerHTML = list[j]["name"] + " - " + list[j]["display_name"];

					activity.setAttribute('data-activity-id', list[j]["activity_id"]);
					activity.setAttribute('data-date', outDay);
					activity.setAttribute('data-out-at', list[j]['out_at']);
					activity.setAttribute('data-in-at', list[j]['in_at']);
					activity.setAttribute('data-type', list[j]['type']);
					activity.setAttribute('data-out-time', list[j]['out_time']);
					activity.setAttribute('data-in-time', list[j]['in_time']);

					actRow.appendChild(activity);
					i += inDay - 1;


					list.splice(j, 1);

					existAtDay = true;

					// Update countOfDay
					for (var d = 1; d <= inDay; d++) {
						if (countOfDay[d] === undefined) {
							countOfDay[d] = 0;
						}
						countOfDay[d] += 1;
					}

				} else if (
					thisYear === outYear &&
					thisMonth === outMonth &&
					thisDay === outDay &&
					thisMonth === inMonth &&
					thisYear === inYear
				) {
					// 이번달 내

					var activity = document.createElement("td");
					activity.className = "col " + colorClass;

					activity.colSpan = interval + 1;

					activity.innerHTML = list[j]["name"] + " - " + list[j]["display_name"];

					activity.setAttribute('data-activity-id', list[j]["activity_id"]);
					activity.setAttribute('data-date', outDay);
					activity.setAttribute('data-out-at', list[j]['out_at']);
					activity.setAttribute('data-in-at', list[j]['in_at']);
					activity.setAttribute('data-type', list[j]['type']);
					activity.setAttribute('data-out-time', list[j]['out_time']);
					activity.setAttribute('data-in-time', list[j]['in_time']);

					actRow.appendChild(activity);
					i += interval;


					list.splice(j, 1);

					existAtDay = true;

					// Update countOfDay
					for (var d = outDay; d <= inDay; d++) {
						if (countOfDay[d] === undefined) {
							countOfDay[d] = 0;
						}
						countOfDay[d] += 1;
					}


				} else if (
					outYear === thisYear &&
					outMonth === thisMonth &&
					(inYear > thisYear || (inYear === thisYear && inMonth > thisMonth)) &&
					outDay === thisDay) {

					// 이번달부터 이번달 다음

					var activity = document.createElement("td");
					activity.className = "col hang-next " + colorClass;

					// activity.colSpan = totalDays - outDay + 1;
					activity.colSpan = totalDays - thisDay + 1

					activity.innerHTML = list[j]["name"] + " - " + list[j]["display_name"];

					activity.setAttribute('data-activity-id', list[j]["activity_id"]);
					activity.setAttribute('data-date', outDay);
					activity.setAttribute('data-out-at', list[j]['out_at']);
					activity.setAttribute('data-in-at', list[j]['in_at']);
					activity.setAttribute('data-type', list[j]['type']);
					activity.setAttribute('data-out-time', list[j]['out_time']);
					activity.setAttribute('data-in-time', list[j]['in_time']);

					actRow.appendChild(activity);
					i += totalDays - outDay;

					list.splice(j, 1);

					existAtDay = true;

					// Update countOfDay
					for (var d = outDay; d <= totalDays; d++) {
						if (countOfDay[d] === undefined) {
							countOfDay[d] = 0;
						}
						countOfDay[d] += 1;
					}

				} else if (
					(outYear < thisYear || (outYear === thisYear && outMonth < thisMonth)) &&
					(inYear > thisYear || (inYear === thisYear && inMonth > thisMonth))
				) {
					// 이번달 이전부터 이번달 다음
					let activity = document.createElement("td")
					activity.className= "col whole " + colorClass
					activity.colSpan = totalDays
					activity.innerHTML = list[j]["name"] + " - " + list[j]["display_name"]

					activity.setAttribute('data-activity-id', list[j]["activity_id"]);
					activity.setAttribute('data-date', outDay);
					activity.setAttribute('data-out-at', list[j]['out_at']);
					activity.setAttribute('data-in-at', list[j]['in_at']);
					activity.setAttribute('data-type', list[j]['type']);
					activity.setAttribute('data-out-time', list[j]['out_time']);
					activity.setAttribute('data-in-time', list[j]['in_time']);

					actRow.appendChild(activity)
					i += totalDays

					list.splice(j, 1)

					existAtDay = true

					// Update countOfDay
					for (var d = outDay; d <= totalDays; d++) {
						if (countOfDay[d] === undefined) {
							countOfDay[d] = 0;
						}
						countOfDay[d] += 1;
					}

				}

				if (existAtDay) break;
			}

			// Empty date
			if (!existAtDay) {
				var emptyDay = generateEmptyDay(thisDay);
				actRow.appendChild(emptyDay);
			}
		}

		platoonWrapper.appendChild(actRow);

		if (list.length === 0) {
			// Additional last line for adding activities
			var actRow = document.createElement("tr");
			for (var i = 0; i < totalDays; i++) {
				var emptyDay = generateEmptyDay(i + 1);
				actRow.appendChild(emptyDay);
			}

			platoonWrapper.appendChild(actRow);

			$('.whole-table').append(platoonWrapper);
			break;
		}

	}

	// START
	// Generate date row

	for (var i = 0; i < totalDays; i++) {
		var dateCol = document.createElement("td");
		dateCol.innerHTML = i + 1;
		dateCol.className = "col col-date";
		dateCol.setAttribute('data-date', i + 1);

		if (countOfDay[i + 1] === 4) {
			dateCol.className = dateCol.className + " full";
		} else if (countOfDay[i + 1] >= 5) {
			dateCol.className = dateCol.className + " max";
		}

		dateRow.appendChild(dateCol);
	}

	$(platoonWrapper).prepend(dateRow);
	// Generate date row
	// END

}

// Load activities (Initialize);
$.ajax({
	url: 'get-activity-list.php',
	type: "post",
	data: "year=" + thisYear + "&month=" + thisMonth,

	success: function (data) {
		var result = JSON.parse(data);

		generateChart(result);

		// If scrollTop exists in sessionStorage
		// keep scrollTop for better UX
		// console.log(sessionStorage.getItem('scrollTop'));
		$(window).scrollTop(sessionStorage.getItem('scrollTop'));
		sessionStorage.removeItem('scrollTop');
	},
	error: function (error) {

	},
	complete: function () {

	}
});