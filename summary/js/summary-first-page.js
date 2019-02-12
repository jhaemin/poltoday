// Loop
updateTime()
updateSchedule(0)
updateSchedule(5000)
updateTDDJ(0)
updateTDDJ(5000)

let currentDate = ""

autoLoad()

// 매일 업데이트
function autoLoad() {
	$.ajax({
		url: 'ajax-php/fetch-data.php',
		data: {
			kind: "serverTime"
		},
		type: 'post',
		success: function (result) {
			// console.log(result)
			if (currentDate !== result) {
				currentDate = result
				updateAP(0)
				updateAbsent(0)
				updateDS(0)
				updateAutonomous(0)
			}
			setTimeout(() => {
				autoLoad()
			}, 10000);
		}
	})

}



function updateTime() {
	let dd = new Date()
	let year = dd.getFullYear()
	let month = dd.getMonth() + 1
	let date = dd.getDate()
	let hour = dd.getHours()
	let minute = dd.getMinutes()
	let second = dd.getSeconds()
	let dayKOR = [
		"일", "월", "화", "수", "목", "금", "토"
	]
	let day = dayKOR[dd.getDay()]
	let time = hour + ":" + minute + ":" + second
	let full = year + ". " + month + ". " + date + ". (" + day + ")" 
	
	document.querySelector(".date-header").innerHTML = full
	
	// 30초마다 확인
	setTimeout(() => {
		updateTime()
	}, 30000);
}

function updateAP(timeout = 1000) {
	setTimeout(() => {
		$.ajax({
			url: 'ajax-php/fetch-data.php',
			data: {
				kind: "ap-status"
			},
			type: 'post',
			success: function (result) {

				/**
				 * @type {Array}
				 */
				result = JSON.parse(result)

				document.querySelector(".ap-info .total .placeholder").innerHTML = result['all']

				document.querySelector(".ap-info .platoon-govern .placeholder.pt").innerHTML = result["platoon_all"][0]
				document.querySelector(".ap-info .platoon-1 .placeholder.pt").innerHTML = result["platoon_all"][1]
				document.querySelector(".ap-info .platoon-2 .placeholder.pt").innerHTML = result["platoon_all"][2]
				document.querySelector(".ap-info .platoon-3 .placeholder.pt").innerHTML = result["platoon_all"][3]

				document.querySelector(".ap-info .platoon-govern .placeholder.pw").innerHTML = result["platoon_work"][0]
				document.querySelector(".ap-info .platoon-1 .placeholder.pw").innerHTML = result["platoon_work"][1]
				document.querySelector(".ap-info .platoon-2 .placeholder.pw").innerHTML = result["platoon_work"][2]
				document.querySelector(".ap-info .platoon-3 .placeholder.pw").innerHTML = result["platoon_work"][3]
				

				if (timeout >= 1000) {
					updateDS(timeout)
				}
			}
		})
	}, timeout);
}

function updateAbsent(timeout = 1000) {
	setTimeout(() => {
		$.ajax({
			url: 'ajax-php/fetch-data.php',
			data: {
				kind: "absent"
			},
			type: 'post',
			success: function (result) {

				result = JSON.parse(result)

				let absent = result['absent']

				document.querySelector(".box.absent .platoon-0 .placeholder").innerHTML = ""
				document.querySelector(".box.absent .platoon-1 .placeholder").innerHTML = ""
				document.querySelector(".box.absent .platoon-2 .placeholder").innerHTML = ""
				document.querySelector(".box.absent .platoon-3 .placeholder").innerHTML = ""

				absent.forEach(function(ap) {
					let target = document.querySelector(".box.absent .platoon-" + ap["platoon"] + " .placeholder")
					let elm = document.createElement("span")
					elm.classList = "ap"
					let outAt = ap["out_at"][5] + ap["out_at"][6] + ". " + ap["out_at"][8] + ap["out_at"][9] + "."
					let inAt = ap["in_at"][5] + ap["in_at"][6] + ". " + ap["in_at"][8] + ap["in_at"][9] + "."
					let expression = ap["name"] + " <span class='time'>(" + ap["display_name"] + " " + outAt + " ~ " + inAt + ")</span>"
					elm.innerHTML = expression
					target.appendChild(elm)
				})

				for (let i = 0; i < 4; i++) {
					if (document.querySelector(".box.absent .platoon-" + i + " .placeholder").childElementCount === 0) {
						document.querySelector(".box.absent .platoon-" + i + " .placeholder").innerHTML = "없음"
					}
				}

				
				let remain = result['remain']

				document.querySelector(".box.remain .platoon-0 .placeholder").innerHTML = ""
				document.querySelector(".box.remain .platoon-1 .placeholder").innerHTML = ""
				document.querySelector(".box.remain .platoon-2 .placeholder").innerHTML = ""
				document.querySelector(".box.remain .platoon-3 .placeholder").innerHTML = ""

				remain.forEach(function(ap) {
					let target = document.querySelector(".box.remain .platoon-" + ap["platoon"] + " .placeholder")
					let elm = document.createElement("span")
					elm.classList = "ap"
					let outAt = ap["out_at"][5] + ap["out_at"][6] + ". " + ap["out_at"][8] + ap["out_at"][9] + "."
					let inAt = ap["in_at"][5] + ap["in_at"][6] + ". " + ap["in_at"][8] + ap["in_at"][9] + "."
					let expression = ap["name"] + " <span class='time'>(" + ap["display_name"] + ")</span>"
					elm.innerHTML = expression
					target.appendChild(elm)
				})

				for (let i = 0; i < 4; i++) {
					if (document.querySelector(".box.remain .platoon-" + i + " .placeholder").childElementCount === 0) {
						document.querySelector(".box.remain .platoon-" + i + " .placeholder").innerHTML = "없음"
					}
				}



				detectAutoScrolling()

				if (timeout >= 1000) {
					updateAbsent(timeout)
				}
			}
		})
	}, timeout);
}

function updateDS(timeout = 1000) {
	setTimeout(() => {
		$.ajax({
			url: 'ajax-php/fetch-data.php',
			data: {
				kind: "duty"
			},
			type: 'post',
			success: function (result) {

				/**
				 * @type {Array}
				 */
				let agents = JSON.parse(result)
				let ds = []

				agents.forEach(function(agent) {
					if (
						agent["event_name"] === "당번" ||
						agent["event_name"] === "대리당번"
					) {
						ds.push(agent)
					}
				})

				document.querySelector(".duty .first").innerHTML = ds[0]["call"] + " " + ds[0]["step"] + " " + ds[0]["name"]
				document.querySelector(".duty .second").innerHTML = ds[1]["call"] + " " + ds[1]["step"] + " " + ds[1]["name"]

				if (timeout >= 1000) {
					updateDS(timeout)
				}
			}
		})
	}, timeout);
}

function updateTDDJ(timeout = 1000) {
	setTimeout(() => {
		$.ajax({
			url: 'ajax-php/fetch-data.php',
			data: {
				kind: "tddj"
			},
			type: 'post',
			success: function (result) {

				result = JSON.parse(result)

				let aaa = result['first'] + '<br>' + result['second']

				if (document.querySelector('.box.tddj').querySelector('.box-contents').innerHTML !== aaa) {
					document.querySelector('.box.tddj').querySelector('.box-contents').innerHTML = result['first'] + '<br>' + result['second']
				}

				detectAutoScrolling()
				
				if (timeout >= 1000) {
					updateTDDJ(timeout)
				}
			}
		})
	}, timeout);
}

function updateSchedule(timeout = 1000) {
	setTimeout(() => {
		$.ajax({
			url: 'ajax-php/fetch-data.php',
			data: {
				kind: "schedule"
			},
			type: 'post',
			success: function (result) {

				if (result.replace(/\n/g, '<br>') !== document.querySelector('.box.schedule').querySelector('.placeholder').innerHTML) {
					document.querySelector('.box.schedule').querySelector('.placeholder').innerHTML = result.replace(/\n/g, '<br>')
				}

				detectAutoScrolling()
				

				if (timeout >= 1000) {
					updateSchedule(timeout)
				}
			}
		})
	}, timeout);
}

function updateAutonomous(timeout = 1000) {
	setTimeout(() => {
		$.ajax({
			url: 'ajax-php/fetch-data.php',
			data: {
				kind: "autonomous"
			},
			type: 'post',
			success: function (result) {
		
				try {
					result = JSON.parse(result)
				} catch (error) {
					console.error(error, result)
				}

				console.log(result)
				
				let autBox = document.querySelector(".box.autonomous")
				autBox.querySelector(".platoon-1").innerHTML = result[0]
				autBox.querySelector(".platoon-2").innerHTML = result[1]
				autBox.querySelector(".platoon-3").innerHTML = result[2]
		
				detectAutoScrolling()
				 
		
				if (timeout >= 1000) {
					updateSchedule(timeout)
				}
			}
		})
	}, timeout)
}


function detectAutoScrolling() {
	// return
	document.querySelectorAll(".box").forEach(function(box) {
		let boxHeight = box.getBoundingClientRect().height
		let boxTitleHeight
		if (box.querySelector(".box-title")) {
			boxTitleHeight = box.querySelector(".box-title").getBoundingClientRect().height
		}
		let boxContentsHeight
		if (box.querySelector(".box-contents")) {
			boxContentsHeight = box.querySelector(".box-contents").getBoundingClientRect().height
		}
		
		if (boxHeight < boxTitleHeight + boxContentsHeight) {
			if (box.classList.contains("is-scrollable")) {
				
			} else {
				box.classList.add("is-scrollable")
				// let movement = boxTitleHeight + boxContentsHeight - boxHeight
				let movement = boxHeight - boxTitleHeight
				loopScroll(box, movement, "down")
			}
			
		} else {
			if (box.querySelector('.box-contents')) {
				box.querySelector('.box-contents').style.transform = "translateY(0px)"
			}
			box.classList.remove("is-scrollable")
			box.classList.remove('scrolling')
		}

	})
}

let allLoopTimeout = []

function loopScroll(box, movement, dir) {
	let randomTime = Math.random()
	randomTime = randomTime * 1000000000
	randomTime = randomTime % 1500
	randomTime = randomTime + 3000
	// console.log("randomTime: ", randomTime)
	let boxHeight = box.getBoundingClientRect().height
	let boxTitleHeight
	if (box.querySelector(".box-title")) {
		boxTitleHeight = box.querySelector(".box-title").getBoundingClientRect().height
	}
	let boxContentsHeight
	let nextMovement, nextDir
	if (box.querySelector(".box-contents")) {
		boxContentsHeight = box.querySelector(".box-contents").getBoundingClientRect().height
	}
	// scrollable box
	if (boxHeight < boxTitleHeight + boxContentsHeight) {
		// movement = boxTitleHeight + boxContentsHeight - boxHeight

		nextMovement = movement + (boxHeight - boxTitleHeight)
		if (dir === "up") {
			nextMovement = movement
		}

		if (movement > (boxTitleHeight + boxContentsHeight - boxHeight)) {
			movement = boxTitleHeight + boxContentsHeight - boxHeight
			nextMovement = (boxHeight - boxTitleHeight)
			nextDir = "up"
		} else {
			nextDir = "down"
		}
		
	} else {
		movement = 0
		nextMovement = 0
		if (box.querySelector('.box-contents')) {
			// box.querySelector('.box-contents').style.transform = "translateY(0px)"
			let boxContents = box.querySelector('.box-contents')
			boxContents.style.transform = "translateY(0)"
		}
		box.classList.remove("is-scrollable")
		box.classList.remove('scrolling')
		return
	}

	if (dir === "down") {
		// box.querySelector(".box-contents").style.transform = "translateY(calc(-" + movement + "px))"
		let boxContents = box.querySelector('.box-contents')
		TweenMax.to(boxContents, 2, {
			ease: Power4.easeInOut,
			transform: "translateY(calc(-" + movement + "px))"
		})
		box.classList.add("scrolling")
		let to = setTimeout(() => {
			loopScroll(box, nextMovement, nextDir)
		}, randomTime)
		// allLoopTimeout.push(to)
	} else if (dir === "up") {
		// box.querySelector(".box-contents").style.transform = "translateY(0px)"
		boxContents = box.querySelector('.box-contents')
		TweenMax.to(boxContents, 2, {
			ease: Power4.easeInOut,
			transform: "translateY(0px)"
		})
		setTimeout(() => {
			box.classList.remove("scrolling")
		}, 1700);
		let to = setTimeout(() => {
			loopScroll(box, nextMovement, "down")
		}, randomTime)
		// allLoopTimeout.push(to)
	}
}

window.addEventListener("resize", () => {

	allLoopTimeout.forEach(timeout => {
		clearTimeout(timeout)
	})

	allLoopTimeout = []

	document.querySelectorAll(".box").forEach(box => {
		if (box.querySelector('.box-contents')) {
			// box.querySelector('.box-contents').style.transform = "translateY(0px)"
			let boxContents = box.querySelector(".box-contents")
			TweenMax.to(boxContents, 0, {
				ease: Power4.easeInOut,
				transform: "translateY(0)"
			})
		}
		box.classList.remove("is-scrollable")
		box.classList.remove('scrolling')
		
	})

	detectAutoScrolling()

	location.reload()
})

window.addEventListener("contextmenu", e => {
	e.preventDefault()
})
