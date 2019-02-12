init()

function init() {

	$.ajax({
		url: 'php/fetch-init-comments.php',
		type: 'post',
		success: function (result) {

			if (result) {
				var commentsArr = JSON.parse(result)

				for (let i = commentsArr.length - 1; i >= 0; i--) {
					generateComment(commentsArr[i])
				}
			}
			
			autoFetch()

		}
	})

}

let interval

function autoFetch() {

	let lastID = 1

	if (document.querySelectorAll("#comments .comment-item")[0]) {
		lastID = document.querySelectorAll("#comments .comment-item")[0].getAttribute("comment-id")
	}

	interval = setInterval(function () {

		// console.log("checking...")
		$.ajax({
			url: 'php/fetch.php',
			type: 'post',
			data: {
				last_id: lastID
			},
			success: function (result) {

				let newComments = JSON.parse(result)

				if (newComments.length === 0) {
					return
				}

				lastID = newComments[newComments.length - 1].id

				// console.log(newComments)
				for (let i = 0; i < newComments.length; i++) {

					if (Notification && Notification.permission === "granted") {

						var n = new Notification(newComments[i].comment)
						n.onshow = function() {
							setTimeout(function() {
								n.close()
							}, 5000)
						}

					} else if (Notification && Notification.permission !== "denied") {
						Notification.requestPermission(function (status) {
							if (Notification.permission !== status) {
								Notification.permission = status
							}
						})
					}

					setTimeout(() => {
						generateComment(newComments[i], true)
					}, i * 100);					

				}

			}
		})

	}, 1000)

}

function generateComment(commentObj, fetch = false) {

	let commentItem = document.createElement("div")

	commentItem.className = "comment-item"
	commentItem.setAttribute("comment-id", commentObj.id)

	if (commentObj.name === "장해민") {
		commentItem.classList.add("jhm")
	} else if (commentObj.name === "나지훈") {
		commentItem.classList.add("njh")
	} else if (commentObj.name === "조병훈") {
		commentItem.classList.add("jbh")
	} else if (commentObj.name === "장준희") {
		commentItem.classList.add("jjh")
	} else if (commentObj.name === "구현모") {
		commentItem.classList.add("khm")
	} else if (commentObj.name === "박진호") {
		commentItem.classList.add("pjh")
	} else if (commentObj.name === "행소") {
		commentItem.classList.add("boss")
	}

	let nameDOM = document.createElement("div")
	nameDOM.className = "name"
	nameDOM.innerHTML = commentObj.name

	let commentDOM = document.createElement("div")
	commentDOM.className = "comment"
	commentDOM.innerHTML = commentObj.comment

	commentItem.appendChild(nameDOM)
	commentItem.appendChild(commentDOM)

	// if the sequence is wrong, handle it
	let lastDOM = document.querySelector("#comments .comment-item")

	if (!lastDOM) {
		document.querySelector("#comments #comments-list").appendChild(commentItem)
		return
	}

	let lastDOMId = Number(lastDOM.getAttribute("comment-id"))

	if (Number(commentObj.id) === lastDOMId) {
		return
	} else if (Number(commentObj.id) < lastDOMId) {
		let nextDOM = lastDOM.nextElementSibling

		while (1) {

			if (!nextDOM) {
				lastDOM.parentElement.appendChild(commentItem)
				break
			}

			if (Number(nextDOM.getAttribute("comment-id")) === lastDOMId) {
				return
			} else if (Number(nextDOM.getAttribute("comment-id")) < lastDOMId) {
				lastDOM.parentElement.insertBefore(commentItem, nextDOM)
				break
			} else {
				nextDOM = nextDOM.nextElementSibling
			}

		}
	} else {
		lastDOM.parentElement.insertBefore(commentItem, lastDOM)
	}

	if (fetch) {
		commentItem.classList.add("new")
		setTimeout(() => {
			commentItem.classList.remove("new")
		}, 300)
	}

}

function addComment() {

	clearInterval(interval)

	var name = "", comment=""
	name = document.querySelector("#comments #name-input").value
	comment = document.querySelector("#comments #comment-input").value

	if (name.replace(/\s+/g, "") === "") {
		alert("이름을 입력하세요!")
		document.querySelector("#comments #name-input").focus()
		return
	}

	if (comment.replace(/\s+/g, "") === "") {
		alert("내용을 입력하세요!")
		document.querySelector("#comments #comment-input").focus()
		return
	}


	$.ajax({
		url: 'php/add-comment.php',
		type: 'post',
		data: {
			name: name,
			comment: comment
		},
		success: function (result) {

			document.querySelector("#comments #comment-input").value = ""

			generateComment({
				name: name,
				comment: comment,
				id: result
			})

			autoFetch()

		}
	})

}



// Event Listeners

document.querySelector("#comments #name-input").addEventListener("keydown", function(e) {
	if (e.which === 13) {
		if (this.value.replace(/\s+/g, "") === "") {
			alert("이름을 입력하세요!")
		} else {
			document.querySelector("#comments #comment-input").focus()
		}
		
	}
})

document.querySelector("#comments #comment-input").addEventListener("keydown", function(e) {
	
	let keyCode = e.which

	// press enter
	if (keyCode === 13) {
		addComment()
	}

})