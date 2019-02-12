let chartItemClicked = false
let orgPageX, orgPageY

let startTime, endTime

window.addEventListener("mousedown", function(e) {

	if (e.target.closest(".col.planned")) {
		chartItemClicked = true
		orgPageX = e.pageX
		orgPageY = e.pageY
		startTime = new Date().getTime()
	}

})
window.addEventListener("mouseup", function(e) {


	chartItemClicked = false

	if (chartItemClicked) {
		if ((orgPageX - e.pageX) === 0 && (orgPageY - e.pageY) === 0) {
			return
		}

		
	}

	

	// if (e.target.closest(".col.planned")) {
	// 	chartItemClicked = false
	// }

})

window.addEventListener("mousemove", function(e) {

	if (chartItemClicked) {
		if (Math.abs(orgPageY - e.pageY) > 0) {
			chartItemClicked = false
			endTime = new Date().getTime()
			var distance = Math.abs(orgPageX - e.pageX)
			var timeDiff = Math.abs(endTime - startTime)
			var velocity = distance / timeDiff * 1000
			var e = 1
			console.log(velocity)
			if (velocity < 10 || velocity > 150) {
				e = 1 / (velocity * velocity)
			}
			var score = Math.floor( (distance * distance * distance) * e )
			if (score === NaN) {
				score = 0
			}

			$('.col.planned.moving').css('left', 0);
			$('.col.planned.moving').css('top', 0);

			$('.col.planned.moving').removeClass('moving');

			activityWillMove = false;

			var conf = confirm( score + "점! 기록을 남기겠습니까?")

			if (conf) {
				var name = prompt("이름을 입력하세요.")

				$.ajax({
					url: 'php/add-moving-score.php',
					type: 'post',
					data: {
						name: name,
						score: score
					},
					success: function (result) {
						updateBoard()
					}
				})

			}
			
		}
	}

})

function updateBoard() {
	$.ajax({
		url: 'php/get-top10-board.php',
		type: 'post',
		success: function (result) {
			let board = document.querySelector("#leaderboard")
			board.querySelector("#score-container").innerHTML = ""
			let scores = JSON.parse(result)
			console.log(scores)
			for (let i = 0; i < scores.length; i++) {
				let scoreItem = document.createElement("div")
				scoreItem.className = "item"
				scoreItem.innerHTML = i + 1 + ". " +  scores[i].name + " " + scores[i].score
				board.querySelector("#score-container").appendChild(scoreItem)
			}
		}
	})
}

updateBoard()