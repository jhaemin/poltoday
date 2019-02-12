$(document).ready(function() {
	function updateContents() {

		// Gather data
		var totalData = {
			contents: "",
			handed_at: $('body').data('today')
		}

		var boxData = {
			lightout: "",
			hand: "",
			patient: "",
			catch: ""
		}

		boxData.lightout = $('.light-out .box').val().replace(/\n/g, '<br>');
		boxData.hand = $('.hand .box').val().replace(/\n/g, '<br>');
		boxData.patient = $('.patient .box').val().replace(/\n/g, '<br>');
		boxData.catch = $('.catch .box').val().replace(/\n/g, '<br>');

		totalData.contents = boxData;

		console.log(JSON.stringify(totalData));


		$.ajax({
			url: '/agent-continue/agent-continue-db.php',
			type: "post",
			data: totalData,

			success: function(data){
				if (data) {
					console.log(data);
				} else {
					console.log('업데이트 성공');
				}
			},
			error: function(error) {

			},
			complete: function() {

			}
		})
	}


	// Event Listeners
	$('.box').on('keyup', function() {

		clearTimeout(this.wait);

		this.wait = setTimeout(function() {
			console.log('auto update...');
			updateContents();
		}, 700);

	});
});
