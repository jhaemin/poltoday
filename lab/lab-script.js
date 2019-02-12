window.addEventListener("load", () => {
	let license = undefined
	let dueDate = "2019-03-21"
	dueDate = new Date(dueDate)
	let diff, currentDate
 
	let licenseDom = document.createElement("div")
	licenseDom.className = "license-view"
		 
	licenseDom.style.width = "auto"
	licenseDom.style.minWidth = "150px"
	licenseDom.style.minHeight = "34px"
	licenseDom.style.display = "flex"
	licenseDom.style.alignItems = "center"
	licenseDom.style.boxSizing = "border-box"
	licenseDom.style.height = "auto"
	licenseDom.style.padding = "10px"
	licenseDom.style.position = "fixed"
	licenseDom.style.right = "20px"
	licenseDom.style.bottom = "20px"
	licenseDom.style.borderRadius = "10px"
	licenseDom.style.backgroundColor = "#000"
	licenseDom.style.color = "#fff"
	licenseDom.style.fontSize = "12px"
	licenseDom.style.zIndex = "9999999999999999999999999999999999"
	licenseDom.innerHTML = "만료까지 00일 00시간 00분 00초 남음"
 
	licenseDom.innerHTML = '<div class="loading-bar light">' +
		'<div class="wrapper">' +
			'<div class="moving-part"></div>' +
		'</div>' +
	'</div>'
 
	document.body.appendChild(licenseDom)
	startTimer()
 
 
 
	licenseDom.addEventListener("mouseover", e => {
		stopTimer()
		licenseDom.innerHTML = "신한은행 110-436-387740 장해민, 10,000원/월"
	})
 
	licenseDom.addEventListener("mouseleave", e => {
		startTimer()
	})
 
	var timer

	function startTimer() {
		timer = setInterval(() => {
			currentDate = new Date()
			diff = dueDate - currentDate
			if (diff < 0) {
				test()
			}
			let days = parseInt(Math.floor(diff/1000/60/60/24))
			diff = diff - days*24*60*60*1000
			let hours = parseInt(Math.floor(diff/1000/60/60))
			diff = diff - hours*60*60*1000
			let mins = parseInt(Math.floor(diff/1000/60))
			diff = diff - mins*60*1000
			let seconds = parseInt(Math.floor(diff/1000))
			licenseDom.innerHTML = "만료까지 " + days + "일 " + hours + "시간 " + mins + "분 " + seconds + "초 남음"
		}, 1000)
	}
 
	function stopTimer() {
		clearInterval(timer)
	}

	function credit() {
	licenseDom.innerHTML = "1087k 장해민님이 만듦"
	}
 
}
)