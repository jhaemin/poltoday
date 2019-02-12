$('.add-single').on("click", function() {
	addInputDataRow(1);
});

$('.add-multiple').on("click", function() {
	var quantity = prompt("멀티 추가 개수를 입력해주세요.");
	addInputDataRow(quantity);
});

function addInputDataRow(quantity) {
	// Error handling
	quantity = Number(quantity);
	if (quantity <= 0) {
		alert("잘못된 값입니다.");
	}

	for (var i = 0; i < quantity; i++) {
		
		var inputDataRow = document.createElement('tr');

		inputDataRow.className = "input-data-container input-row input-data-row";


		var colRowId = document.createElement('td');
		colRowId.className = "col item-col-id";
		colRowId.innerHTML = '<button type="button" class="col-delete">삭제</button>';

		inputDataRow.appendChild(colRowId);

		// Name node
		var colName = document.createElement('td');
		colName.className = "col item-col-nm";
		colName.innerHTML = $('.item-col.item-col-nm').html();

		inputDataRow.appendChild(colName);

		// Phone Number node
		var colPhoneNum = document.createElement('td');
		colPhoneNum.className = "col item-col-pn";
		colPhoneNum.innerHTML = $('.item-col.item-col-pn').html();

		inputDataRow.appendChild(colPhoneNum);

		var colEnrollAt = document.createElement('td');
		colEnrollAt.className = "col item-col-ea";
		colEnrollAt.innerHTML = $('.item-col.item-col-ea').html();

		inputDataRow.appendChild(colEnrollAt);

		var colTransferAt = document.createElement('td');
		colTransferAt.className = "col item-col-ta";
		colTransferAt.innerHTML = $('.item-col.item-col-ta').html();

		inputDataRow.appendChild(colTransferAt);

		var colDischargeAt = document.createElement('td');
		colDischargeAt.className = "col item-col-da";
		colDischargeAt.innerHTML = $('.item-col.item-col-da').html();

		inputDataRow.appendChild(colDischargeAt);

		var colBirthday = document.createElement('td');
		colBirthday.className = "col item-col-bd";
		colBirthday.innerHTML = $('.item-col.item-col-bd').html();

		inputDataRow.appendChild(colBirthday);

		var colLevel = document.createElement('td');
		colLevel.className = "col item-col-lv";
		colLevel.innerHTML = $('.item-col.item-col-lv').html();

		inputDataRow.appendChild(colLevel);

		var colPlatoon = document.createElement('td');
		colPlatoon.className = "col item-col-pt";
		colPlatoon.innerHTML = $('.item-col.item-col-pt').html();

		inputDataRow.appendChild(colPlatoon);

		document.querySelector('.input-data-table').appendChild(inputDataRow);
	}
}

$('.add-ap-form').on('submit', function(e) {
	e.preventDefault();
	$.ajax({
		url: '/ajax-php/add-ap-submit.php',
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
				alert('등록이 성공적으로 완료되었습니당!');
			}
		},
		error: function(error) {

		},
		complete: function() {

		}
	});
});

$('.ap-table').on('click', '.col-delete', function() {
	$(this).parents('.input-row').remove();
});

// Phone number input formatting
$('.ap-table').on('keyup', '.ap-input.pn', function() {
	
	var number = $(this).val();
	var newNumber = number;

	newNumber = number.replace(/\D/ig, "");

	// if (newNumber.length > 4)

	$(this).val(newNumber);

});