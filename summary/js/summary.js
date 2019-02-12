// setPageIndex(1)

// autoSwipePages(1)


function setPageIndex(index) {

	let pages = document.querySelectorAll('.whole-box')

	let pIndex = index - 1
	let nIndex = index
	if (pIndex < 0) {
		pIndex = pages.length - 1
	}
	
	// for (let i = 0; i < pages.length; i++) {
	// 	let tval = -(100 * index) + 100 * i
	// 	pages[i].style.transform = 'translateX(' + tval + '%)'
	// }

	console.log(pIndex)
	console.log(nIndex)

	pages[nIndex].style.zIndex = "100"
	pages[pIndex].style.zIndex = "-1"

	TweenMax.to(pages[nIndex], 0, {
		ease: Power3.easeInOut,
		transform: "translateX(100%)",
		opacity: "1"
	})

	TweenMax.to(pages[nIndex], 2, {
		ease: Power4.easeInOut,
		transform: "translateX(0)",
	})

	TweenMax.to(pages[pIndex], 2, {
		ease: Power4.easeInOut,
		transform: "scale(.8)",
		opacity: "0"
	})

}


function autoSwipePages(indexBegin) {

	let pages = document.querySelectorAll('.whole-box')

	setPageIndex(indexBegin)
	setTimeout(() => {
		let nextIndex = indexBegin + 1
		if (nextIndex + 1 > pages.length) {
			nextIndex = 0
		}
		autoSwipePages(nextIndex)
	}, 4000)

}

