document.querySelector('.ta').addEventListener('keyup', function (e) {

	clearTimeout(this.wait)

	this.wait = setTimeout(() => {
		console.log('auto updating...')
		console.log(this.value)
		$.ajax({
			url: 'update-schedule.php',
			data: {
				sc: this.value
			},
			type: 'post',
			success: function () {

			}
		})
	}, 700);

})