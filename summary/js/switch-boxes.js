function remToPx() {
	let elm = document.createElement("div")
	elm.style.opacity = "0"
	elm.position = "fixed"
	document.querySelector("body").appendChild(elm)
	elm.style.width = "1rem"
	let px = elm.getBoundingClientRect().width
	document.querySelector("body").removeChild(elm)
	return px
}


switch1()

function switch1() {
	let v = 0
	let rem = remToPx()
	let boxAbsent = document.querySelector('.box.absent')
	let boxRemain = document.querySelector('.box.remain')

	let height = boxRemain.getBoundingClientRect().height

	v = height - 2*rem
	TweenMax.to(boxAbsent, 2, {
		ease: Power4.easeInOut,
		// transform: "translateY(calc(-" + height + "px - 2rem))",
		transform: "translateY(" + -v + "px)",
		opacity: 0
	})

	

	TweenMax.to(boxRemain, 0, {
		ease: Power4.easeInOut,
		transform: "translateY(calc(" + height + "px + 2rem))",
		opacity: 0
	})

	TweenMax.to(boxRemain, 2, {
		ease: Power4.easeInOut,
		transform: "translateY(0)",
		opacity: 1
	})

	setTimeout(() => {
		switch2()
	}, 6000)
	
}

function switch2() {

	let boxAbsent = document.querySelector('.box.absent')
	let boxRemain = document.querySelector('.box.remain')

	let height = boxRemain.getBoundingClientRect().height

	TweenMax.to(boxRemain, 2, {
		ease: Power4.easeInOut,
		transform: "translateY(calc(-" + height + "px - 2rem))",
		opacity: 0
	})

	

	TweenMax.to(boxAbsent, 0, {
		ease: Power4.easeInOut,
		transform: "translateY(calc(" + height + "px + 2rem))",
		opacity: 0
	})

	TweenMax.to(boxAbsent, 2, {
		ease: Power4.easeInOut,
		transform: "translateY(0)",
		opacity: 1
	})

	setTimeout(() => {
		switch1()
	}, 9000)
}

// 당직근무 -> 주요일정
switch3()
function switch3() {
	let boxSchedule = document.querySelector('.box.schedule')
	let boxDuty = document.querySelector('.box.duty')
	let boxTddj = document.querySelector('.box.tddj')
	let todayWork = document.querySelector('.box-container.today-work')

	boxSchedule.style.zIndex = "100"
	boxDuty.style.zIndex = "-1"
	boxTddj.style.zIndex = "-1"

	TweenMax.to(boxSchedule, 0, {
		ease: Power4.easeInOut,
		transform: "scale(1)",
		opacity: 1
	})

	let width = todayWork.getBoundingClientRect().width
	let rem = remToPx()

	TweenMax.to(boxSchedule, 0, {
		ease: Power4.easeInOut,
		transform: "translateX(" + (width + 5*rem) + "px)",
		opacity: 1
	})

	TweenMax.to(boxSchedule, 2, {
		ease: Power4.easeInOut,
		transform: "translateX(0)",
		opacity: 1
	})

	TweenMax.to(todayWork, 2, {
		ease: Power4.easeInOut,
		transform: "scale(.9)",
		opacity: 0
	})

	// TweenMax.to(boxDuty, 2, {
	// 	ease: Power4.easeInOut,
	// 	transform: "scale(.9)",
	// 	opacity: 0
	// })
	// TweenMax.to(boxTddj, 2, {
	// 	ease: Power4.easeInOut,
	// 	transform: "scale(.9)",
	// 	opacity: 0
	// })

	setTimeout(() => {
		switch4()
	}, 10000)
}

// 주요일정 -> 당직근무
function switch4() {
	let boxSchedule = document.querySelector('.box.schedule')
	let boxDuty = document.querySelector('.box.duty')
	let boxTddj = document.querySelector('.box.tddj')
	let todayWork = document.querySelector('.box-container.today-work')

	boxSchedule.style.zIndex = "-1"
	boxDuty.style.zIndex = "100"
	boxTddj.style.zIndex = "100"

	TweenMax.to(boxDuty, 0, {
		ease: Power4.easeInOut,
		transform: "scale(1)",
		opacity: 1
	})

	let width = todayWork.getBoundingClientRect().width
	let rem = remToPx()

	// TweenMax.to(boxDuty, 0, {
	// 	ease: Power4.easeInOut,
	// 	transform: "translateX(calc(" + (width + 5*rem) + "px))",
	// 	opacity: 1
	// })
	// TweenMax.to(boxTddj, 0, {
	// 	ease: Power4.easeInOut,
	// 	transform: "translateX(calc(" + (width + 5*rem) + "px))",
	// 	opacity: 1
	// })

	// TweenMax.to(boxDuty, 2, {
	// 	ease: Power4.easeInOut,
	// 	transform: "translateX(0)",
	// 	opacity: 1
	// })
	// TweenMax.to(boxTddj, 2, {
	// 	ease: Power4.easeInOut,
	// 	transform: "translateX(0)",
	// 	opacity: 1
	// })

	TweenMax.to(todayWork, 0, {
		ease: Power4.easeInOut,
		transform: "translateX(" + (width + 7*rem) + "px)",
		opacity: 1
	})

	TweenMax.to(todayWork, 2, {
		ease: Power4.easeInOut,
		transform: "translateX(0)",
		opacity: 1
	})

	TweenMax.to(boxSchedule, 2, {
		ease: Power4.easeInOut,
		transform: "scale(.9)",
		opacity: 0
	})

	setTimeout(() => {
		switch3()
	}, 7000)
}