$('.add-single').on("click", function() {
	addInputDataRow(1);
});

$('.add-multiple').on("click", function() {
	var quantity = prompt("멀티 추가 개수를 입력해주세요.");
	addInputDataRow(quantity);
});

$('.ap-table').on('click', '.col-delete', function() {
	$(this).parents('.input-row').remove();
	console.log('deleting');
});

// Duplicate event
$('.ap-table').on('click', '.col-duplicate', function() {
	// addInputDataRow(1, $(this).parents('.input-data-container'));

	var currEventRow = $(this).parents('.input-data-container').get(0);

	var newEventRow = currEventRow.cloneNode();
	newEventRow.classList.add('input-row');
	newEventRow.innerHTML = currEventRow.innerHTML;

	newEventRow.querySelector('.item-col-id').innerHTML = "";
	$(newEventRow.querySelector('.item-col-id')).prepend('<button type="button" class="col-delete">삭제</button><button type="button" class="col-duplicate">복제</button>');
	newEventRow.querySelector('.ap-name').innerHTML = "";
	newEventRow.querySelector('.ap-id').value = "";
	newEventRow.querySelector('.date-input-out-at').value = currEventRow.querySelector('.date-input-out-at').value;
	newEventRow.querySelector('.date-input-in-at').value = currEventRow.querySelector('.date-input-in-at').value;
	newEventRow.querySelector('.ap-select').value = currEventRow.querySelector('.ap-select').value;
	newEventRow.querySelector('.input-display-name').value = currEventRow.querySelector('.input-display-name').value;
	newEventRow.querySelector('.all-day').checked = currEventRow.querySelector('.all-day').checked;
	newEventRow.querySelector('.unknown-in-at').checked = currEventRow.querySelector('.unknown-in-at').checked;
	newEventRow.querySelector('.out-time-input').value = currEventRow.querySelector('.out-time-input').value;
	newEventRow.querySelector('.in-time-input').value = currEventRow.querySelector('.in-time-input').value;
	newEventRow.querySelector('.note-input').value = currEventRow.querySelector('.note-input').value;

	currEventRow.parentNode.insertBefore(newEventRow, currEventRow.nextElementSibling);
});

function addInputDataRow(quantity, $dup = null) {
	// Error handling
	quantity = Number(quantity);
	if (quantity <= 0) {
		alert("잘못된 값입니다.");
	}

	for (var i = 0; i < quantity; i++) {

		var inputDataRow = document.createElement('tr');

		inputDataRow.className = "input-data-container input-row input-data-row";


		var colRowId = document.createElement('td');
		colRowId.className = "col item-col item-col-id";
		colRowId.innerHTML = '<button type="button" class="col-delete">삭제</button><button type="button" class="col-duplicate">복제</button>';
		inputDataRow.appendChild(colRowId);

		// name
		var colApID = document.createElement('td');
		colApID.className = "col item-col item-col-nm";
		colApID.innerHTML = document.querySelector('.item-col.item-col-nm').innerHTML;
		colApID.querySelector('.ap-name').innerHTML = "";
		inputDataRow.appendChild(colApID);

		// out at
		var colOutAt = document.createElement('td');
		colOutAt.className = "col item-col item-col-oa";
		colOutAt.innerHTML = document.querySelector('.item-col.item-col-oa').innerHTML;
		if ($dup) {
			colOutAt.querySelector('.date-input-out-at').value = $dup.find('.date-input-out-at').val();
		}
		inputDataRow.appendChild(colOutAt);

		// In at
		var colInAt = document.createElement('td');
		colInAt.className = "col item-col item-col-ia";
		colInAt.innerHTML = document.querySelector('.item-col.item-col-ia').innerHTML;
		if ($dup) {
			colInAt.querySelector('.date-input-in-at').value = $dup.find('.date-input-in-at').val();
		}
		inputDataRow.appendChild(colInAt);

		var colType = document.createElement('td');
		colType.className = "col item-col item-col-tp";
		colType.innerHTML = document.querySelector('.item-col.item-col-tp').innerHTML;
		inputDataRow.appendChild(colType);

		// Display Name
		var colDisplayName = document.createElement('td');
		colDisplayName.className = "col item-col item-col-dn";
		colDisplayName.innerHTML = document.querySelector('.item-col.item-col-dn').innerHTML;
		inputDataRow.appendChild(colDisplayName);

		if ($dup) {
			$dup.get(0).parentNode.insertBefore(inputDataRow, $dup.get(0).nextElementSibling);
		} else {
			document.querySelector('.ap-table-body').appendChild(inputDataRow);
		}

		// Out Time
		var colOutTime = document.createElement('td');
		colOutTime.className = "col item-col item-col-ot";
		colOutTime.innerHTML = document.querySelector('.item-col.item-col-ot').innerHTML;
		inputDataRow.appendChild(colOutTime);

		if ($dup) {

		} else {
			document.querySelector('.ap-table-body').appendChild(inputDataRow);
		}

		// In Time
		var colInTime = document.createElement('td');
		colInTime.className = "col item-col item-col-ot";i
		colInTime.innerHTML = document.querySelector('.item-col.item-col-it').innerHTML;
		inputDataRow.appendChild(colInTime);

		if ($dup) {

		} else {
			document.querySelector('.ap-table-body').appendChild(inputDataRow);
		}

		// Note
		var note = document.createElement('td');
		note.className = "col item-col item-col-nt";
		note.innerHTML = document.querySelector('.item-col.item-col-nt').innerHTML;
		inputDataRow.appendChild(note);

		if ($dup) {

		} else {
			document.querySelector('.ap-table-body').appendChild(inputDataRow);
		}

	}
}

$('.add-ap-outside-activity-form').on('submit', function(e) {
	e.preventDefault();

	if (!confirm("추가하시겠습니까?")) {
		return;
	}

	$.ajax({
		url: '/ajax-php/add-ap-outside-activity-submit.php',
		type: 'POST',
		data: $(this).serialize(),
		success: function(data) {
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
				alert('추가되었습니다.');
				location.reload();
			}
		},
		error: function(error) {

		},
		complete: function() {

		}
	});
});

$('.search-result-container').on('click', '.search-result-item', function() {
	var apId = $(this).data('ap-id');
});

// Click name area
$('.ap-table').on('click', '.item-col-nm', function() {
	$targetElm = $(this);
    toggleSearchWindow();
});

var $targetElm;
var targetElm;

// Select searched AP
$('.search-result-container').on('click', '.search-result-item', function() {
	var apId = $(this).data('ap-id');
	var name = $(this).find('.col-search-result-name').html();

	$targetElm.find('.ap-id').val(apId);
	$targetElm.find('.ap-name').html(name);

	toggleSearchWindow();
});

// When type selection has changed
$('.ap-table').on('change', '.ap-select', function() {
	var typeName = $(this).parents('.input-data-container').find('.ap-select option:selected').text();

	$(this).parents('.input-data-container').find('.item-col-dn').find('.table-input').val(typeName);
});


document.addEventListener('change', function(e) {
	// 별명시
	if (e.target && e.target.classList.contains('unknown-in-at')) {
		var target = e.target;
		var dateInput = target.parentNode.querySelector('.date-input');
		if (target.checked) {
			dateInput.value = "9999-12-25";
			dateInput.style.display = 'none';
		} else {
			dateInput.value = "";
			dateInput.style.display = "";
		}
	}
});

$(document).on('change', '.all-day', function() {
	var target = $(this).get(0);
	var outAtInput = $(this).parents('.input-data-container').find('.date-input-out-at').get(0);
	var inAtInput = $(this).parents('.input-data-container').find('.date-input-in-at').get(0);
	var outAtValue = outAtInput.value;

	if (target.checked) {
		inAtInput.value = outAtValue;
	} else {
		inAtInput.value = "";
	}
});


// Card
function addNewCard() {
	let sampleCard = document.querySelector('.card').cloneNode(true)
	sampleCard.querySelectorAll('input').forEach(function(item) {
		item.value = ""
	})

	document.querySelector('.new-card-container').insertBefore(sampleCard, document.querySelector('.add-card'))
}

/**
 * 
 * @param {Element} card 
 */
function duplicateCard(card) {
	let duplicatedCard = card.cloneNode(true)
	card.parentElement.insertBefore()
}

/**
 * 
 * @param {Element} card 
 */
function showTimeOption(card) {
	let outTime = document.createElement("input")
	outTime.type = "text"
	outTime.name = "out_time[]"
	outTime.className = "card-input out-time"
	outTime.placeholder = "시작시간"
	outTime.required = true
	let inTime = document.createElement("input")
	inTime.type = "text"
	inTime.name = "in_time[]"
	inTime.className = "card-input in-time"
	inTime.placeholder = "종료시간"
	inTime.required = true
	let hospitalName = document.createElement("input")
	hospitalName.type = "text"
	hospitalName.name = "note[]"
	hospitalName.className = "card-input note"
	hospitalName.placeholder = "병원명"
	hospitalName.required = true
	let cardInputContainer = card.querySelector('.card-input-container')
	cardInputContainer.appendChild(outTime)
	cardInputContainer.appendChild(inTime)
	cardInputContainer.appendChild(hospitalName)
}

/**
 * 
 * @param {Element} card 
 */
function hideTimeOption(card) {
	let cardInputContainer = card.querySelector('.card-input-container')
	let outTime = cardInputContainer.querySelector('.out-time')
	if (outTime) {
		cardInputContainer.removeChild(outTime)
	}
	
	let inTime = cardInputContainer.querySelector('.in-time')
	if (inTime) {
		cardInputContainer.removeChild(inTime)
	}

	let hospitalName = cardInputContainer.querySelector('.note')
	if (hospitalName) {
		cardInputContainer.removeChild(hospitalName)
	}
}

// Card -- Event Listeners
document.querySelector('.add-card .plus').addEventListener('click', function() {
	addNewCard()
})

window.addEventListener("change", function(e) {
	if (e.target.closest(".ap-select")) {
		let apSelect = e.target.closest(".ap-select")
		let val = Number(apSelect.value)
		if (val === 11) {
			console.log("hello")
			showTimeOption(apSelect.closest('.card'))
		} else {
			hideTimeOption(apSelect.closest('.card'))
		}
	}
})