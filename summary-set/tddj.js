document.querySelector('.save').addEventListener('click', function() {
	$.ajax({
		url: 'update-tddj.php',
		data: {
			first: document.querySelector('.tddj-input.first').value,
			second: document.querySelector('.tddj-input.second').value,
			date: document.querySelector('html').getAttribute('date')
		},
		type: 'post',
		success: function (result) {
			location.reload()
		}
	})
})