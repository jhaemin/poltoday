let clicked = false, isMoving = false
let orgX, newX, orgY, newY

document.querySelectorAll(".members .person").forEach(function(item) {
	
	
	item.addEventListener("mousedown", (e) => {
		clicked = true
		orgX = e.pageX
		orgY = e.pageY
		item.classList.add("moving-target")
	})

})

window.addEventListener("mousemove", (e) => {
	let target = document.querySelector(".moving-target")
	if (!target) return
	if (clicked) {
		isMoving = true
		newX = e.pageX
		newY = e.pageY
		target.style.left = newX - orgX + "px"
		target.style.top = newY - orgY + "px"
		target.style.zIndex = "2000"
	}
})

window.addEventListener("mouseup", (e) => {
	clicked = false
	let target = document.querySelector(".moving-target")
	if (!target) return
	target.classList.remove("moving-target")
	TweenMax.to(target, 0.3, {
		ease: Power1.easeInOut,
		left: "0px",
		top: "0px"
	})
	setTimeout(() => {
		target.style.zIndex = ""
	}, 300)
})