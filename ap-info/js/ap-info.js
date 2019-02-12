function toggleColumn(className) {
	var cols = document.getElementsByClassName(className);
	[].forEach.call(cols, function(col) {
		var $col = $(col);
		if ($col.hasClass('hidden')) {
			$col.removeClass('hidden');
		} else {
			$col.addClass('hidden');
		}
	});
}

// Home address hide/show
document.querySelector('.cb-address').addEventListener('change', function () {
	toggleColumn('home-address');
});

// phone number hide/show
document.querySelector('.cb-phone').addEventListener('change', function () {
	toggleColumn('phone-number');
});

// Military Serial Number hide/show
document.querySelector('.cb-msn').addEventListener('change', function () {
	toggleColumn('military-number');
});

// 주민번호
document.querySelector('.cb-ctznc').addEventListener('change', function () {
	toggleColumn('citizen-code');
});

// Roll hide/show
$('.cb-roll').on('change', function() {
	toggleColumn('roll');
})

// Parents info hide/show
$('.cb-parents-info').on('change', function() {
	toggleColumn('mother-name');
	toggleColumn('mother-pn');
	toggleColumn('father-name');
	toggleColumn('father-pn');
});

// Edit mode
$('.cb-edit').on('click', function() {
	var elm = $(this).get(0);
	if (elm.checked) {
		$('td.editable').attr('contenteditable', 'true');
	} else {
		$('td.editable').attr('contenteditable', 'false');
	}
});

// 대원 정보 수정
$('td').on('keydown', function(e) {
	if (e.which === 13) {
		e.preventDefault();

		// Get table column name
		// var apID = Number($(this).get(0).parentElement.getAttribute('data-ap-id'));
		// console.log(apID);
		// var columnName = $(this).get(0).getAttribute('data-column-name');
		// console.log(columnName);
		// var newInfo = $(this).get(0).textContent;
		// console.log(newInfo);
		$(this).blur();

		// return

		// $.ajax({
		// 	url: '/ajax-php/update-ap-info.php',
		// 	type: 'post',
		// 	data: {
		// 		ap_id: apID,
		// 		column_name: columnName,
		// 		new_data: newInfo
		// 	},
		// 	success: function(result) {
		// 		if (result) {
		// 			console.log(result)
		// 		} else {
		// 			console.log("update success")
		// 		}
		// 	}
		// })
	}
});

$('td').on('focusout', function (e) {
	// Get table column name
	var apID = Number($(this).get(0).parentElement.getAttribute('data-ap-id'));
	console.log(apID);
	var columnName = $(this).get(0).getAttribute('data-column-name');
	console.log(columnName);
	var newInfo = $(this).get(0).textContent;
	console.log(newInfo);

	// return

	$.ajax({
		url: '/ajax-php/update-ap-info.php',
		type: 'post',
		data: {
			ap_id: apID,
			column_name: columnName,
			new_data: newInfo
		},
		success: function (result) {
			if (result) {
				console.log(result)
			} else {
				console.log("update success")
			}
		}
	})
})

// Search anything
document.querySelector('.search-anything').addEventListener('keyup', function(e) {
	var keyWord = this.value;

	var searchResultCount = 0;

	var rows = document.querySelectorAll('.row-ap');
	rows.forEach(function (ap) {
		if (!ap.querySelector('.name').innerHTML.includes(keyWord) &&
			!ap.querySelector('.level').innerHTML.includes(keyWord) &&
			!ap.querySelector('.platoon').innerHTML.includes(keyWord) &&
			!ap.querySelector('.military-number').innerHTML.includes(keyWord) &&
			!ap.querySelector('.phone-number').innerHTML.includes(keyWord) &&
			!ap.querySelector('.home-address').innerHTML.includes(keyWord) &&
			!ap.querySelector('.enroll-at').innerHTML.includes(keyWord) &&
			!ap.querySelector('.transfer-at').innerHTML.includes(keyWord) &&
			!ap.querySelector('.discharge-at').innerHTML.includes(keyWord) &&
			!ap.querySelector('.roll').innerHTML.includes(keyWord)) {
			$(ap).addClass('hidden');
		} else {
			$(ap).removeClass('hidden');
			searchResultCount++;
		}
	})
	// console.log(searchResultCount);
});

var headers = document.querySelectorAll('th');
for (var i = 0; i < headers.length; i++) {
	headers[i].addEventListener('click', function() {
		if (!this.getAttribute('data-order') || this.getAttribute('data-order') === "DESC") {
			sortTable(this.getAttribute('data-header-name'), "ASC");
			this.setAttribute('data-order', 'ASC');
		} else {
			sortTable(this.getAttribute('data-header-name'), "DESC");
			this.setAttribute('data-order', 'DESC');
		}
	});
}

function sortTable(sortBy, order = "ASC") {

	var table, rows, switching, i, x, y, shouldSwitch;
	table = document.getElementById("ap-info-table");
	switching = true;

	/* Make a loop that will continue until
	no switching has been done: */
	while (switching) {

		// Start by saying: no switching is done:
		switching = false;
		rows = table.getElementsByTagName("tr");

		/* Loop through all table rows (except the
		first, which contains table headers): */
		for (i = 1; i < (rows.length - 1); i++) {

			// Start by saying there should be no switching:
			shouldSwitch = false;

			/* Get the two elements you want to compare,
			one from current row and one from the next: */
			x = rows[i].getElementsByClassName(sortBy)[0];
			y = rows[i + 1].getElementsByClassName(sortBy)[0];

			// Check if the two rows should switch place:
			if (order === "ASC") {
				if (x.textContent.toLowerCase() > y.textContent.toLowerCase()) {
					// I so, mark as a switch and break the loop:
					shouldSwitch= true;
					break;
				}
			} else if (order === "DESC") {
				if (x.textContent.toLowerCase() < y.textContent.toLowerCase()) {
					// I so, mark as a switch and break the loop:
					shouldSwitch= true;
					break;
				}
			}
		}
		if (shouldSwitch) {
			/* If a switch has been marked, make the switch
			and mark that a switch has been done: */
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
			switching = true;
		}
	}
}

// CSV 파일로 저장
function downloadCSV(csv, filename) {
	var csvFile;
	var downloadLink;

	// CSV File
	csvFile = new Blob([csv], { type: "text/csv" });

	// Download Link
	downloadLink = document.createElement("a");

	// File name
	downloadLink.download = filename;

	// Create a link to the file
	downloadLink.href = window.URL.createObjectURL(csvFile);

	// Hide download link
	downloadLink.style.display = "none";

	document.body.appendChild(downloadLink);
	
	downloadLink.click();
}

function exportTableToCSV(filename) {
	console.log('exporting');
	var csv = [];
	var rows = document.querySelectorAll("table tr:not(.hidden)");
	for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td:not(.hidden), th:not(.hidden)");
		for (var j = 0; j < cols.length; j++) {
			var data = cols[j].innerText;
			data = '"' + data.replace(/\r\n\t|\n|\r\t/gm, "") + '"';
			row.push(data);
		}
		csv.push(row.join(","));
	}

	console.log(csv);

	downloadCSV(csv.join("\n"), filename);
}

function downloadHTML (htmlFile, filename) {
	var htmlFile;
	var downloadLink;

	// Download Link
	downloadLink = document.createElement("a");

	// File name
	downloadLink.download = filename;

	// Create a link to the file
	downloadLink.href = "data:text/plain;charset=utf-8," + htmlFile;

	// Hide download link
	downloadLink.style.display = "none";

	document.body.appendChild(downloadLink);
	
	downloadLink.click();
}

function exportTableToHTML (filename) {
	var htmlFile;
	htmlFile = '<!DOCTYPE html><html><head><style>table{text-align:center;font-family: "Gulim", "굴림", "굴림체", sans-serif;font-size: 11pt;border: 1px solid black;}tr {border: 1px solid black;}td {border: 1px solid black;}a{color:black;text-decoration:none;pointer-events:none;}</style></head><body>';

	htmlFile += document.querySelector('#ap-info-table').outerHTML;

	htmlFile += '</body>';

	downloadHTML(htmlFile, filename);
}

$('#download').on('click', function() {
	console.log('다운로드');
	// exportTableToCSV("대원정보.csv");
	exportTableToHTML ("대원정보.xlsx");
});
