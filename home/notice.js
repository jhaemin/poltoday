let notice = document.querySelector("#notice")
let addNewNoticeButton = notice.querySelector(".add-new-notice")
let modal = notice.querySelector(".new-notice-modal")
let textArea = modal.querySelector(".textarea")
let noticerList = modal.querySelectorAll(".noticer .member")
let uploadButton = modal.querySelector(".btn-container")
let noticeItemContainer = notice.querySelector(".notice-item-container")
let loadingBarWrapper = notice.querySelector(".loading-bar-wrapper")


loadInit()


addNewNoticeButton.addEventListener("click", e => {
	showNewNoticeModal()
})

modal.addEventListener("click", e => {
	if (
		e.target.closest &&
		!e.target.closest(".writer-box")
	) {
		closeNewNoticeModal()
	}
})

textArea.addEventListener("input", e => {
	isOkayToPublish()
})

noticerList.forEach(noticer => {
	noticer.addEventListener("click", e => {
		selectNoticer(e.target)
		isOkayToPublish()
	})
})

uploadButton.addEventListener("click", e => {
	if (isOkayToPublish()) {
		uploadNotice()
	}
})

notice.addEventListener("scroll", e => {
	if (notice.scrollTop + notice.getBoundingClientRect().height >= notice.scrollHeight - 5 && !isLoadingBarExist()) {
		addLoadingBar("100%")
		// notice.scrollTop = notice.scrollHeight
		// $(notice).animate({
		// 	scrollTop: notice.scrollHeight
		// }, 1000)

		loadMore()
	}
})

// esc 키 이벤트
window.addEventListener("keydown", e => {
	if (e.key === "Escape") {
		closeNewNoticeModal()
	}
})

function isLoadingBarExist() {
	if (notice.querySelector(".loading-bar")) {
		return true
	} else {
		return false
	}
}

function addLoadingBar(height) {
	if (!isLoadingBarExist()) {
		loadingBarWrapper.appendChild(generateLoadingBar(height))
	}
}

function removeLoadingBar() {
	if (isLoadingBarExist()) {
		loadingBarWrapper.removeChild(loadingBarWrapper.querySelector(".loading-bar"))
	}
}

function loadInit() {
	noticeItemContainer.appendChild(generateLoadingBar("calc(100vh - 10rem)"))
	noticeItemContainer.classList.add("before-loaded")

	$.ajax({
		url: "ajax/load-init.php",
		type: "post",
		data: {
			limit: 10
		},
		success: function (data) {
			setTimeout(() => {
				try {
					loadInitCallback(JSON.parse(data))
				} catch (error) {
					alert(error)
				}
			}, 1000)
			
			
		},
		error: function (error) {},
		complete: function () {}
	})
}

/**
 * 
 * @param {Array} data 
 */
function loadInitCallback(data) {
	let frag = document.createDocumentFragment()
	data.forEach(notice => {
		frag.appendChild(buildNoticeItemBlock(notice))
	})
	setTimeout(() => {
		while (noticeItemContainer.lastChild) {
			noticeItemContainer.removeChild(noticeItemContainer.lastChild)
		}
		noticeItemContainer.appendChild(frag)
		noticeItemContainer.clientHeight // wait until completely rendered
		noticeItemContainer.classList.remove("before-loaded")
	}, 0)
	
}

function loadMore() {
	$.ajax({
		url: "ajax/load-more-notice.php",
		type: "post",
		data: {
			mode: "old",
			id: Number(noticeItemContainer.querySelector(".notice-item:last-child").getAttribute("data-notice-id"))
		},
		success: function (data) {
			try {
				data = JSON.parse(data)
				let frag = document.createDocumentFragment()
				for (let i = 0; i < data.length; i++) {
					frag.appendChild(buildNoticeItemBlock(data[i]))
				}
				insertBlock(frag, "end")
				removeLoadingBar()
			} catch (error) {
				console.log(data)
				console.log(error)
			}		 
		},
		error: function (error) {},
		complete: function () {}
	})
}

/**
 * 
 * @param {Object} notice 
 */
function buildNoticeItemBlock(notice) {

	let noticeDOM = document.createElement("div")
	noticeDOM.classList.add("notice-item")
	noticeDOM.setAttribute("data-notice-id", notice["id"])
	if (Number(notice["is_agent"])) {
		noticeDOM.classList.add("agent")
	}

	let noticedAtDOM = document.createElement("div")
	noticedAtDOM.classList.add("ni-date")
	noticedAtDOM.innerHTML = notice["noticed_at"]

	let noticerDOM = document.createElement("div")
	noticerDOM.classList.add("noticed-by")
	noticerDOM.innerHTML = notice["name"]

	let manifestoDOM = document.createElement("div")
	manifestoDOM.classList.add("ni-manifesto")
	manifestoDOM.innerHTML = notice["content"]

	noticeDOM.appendChild(noticerDOM)
	noticeDOM.appendChild(noticedAtDOM)
	noticeDOM.appendChild(manifestoDOM)

	return noticeDOM
}

function insertBlock(frag, direction = "end") {
	if (direction === "end") {
		noticeItemContainer.appendChild(frag)
	} else if (direction === "begin") {
		noticeItemContainer.insertBefore(frag, noticeItemContainer.firstChild)
	}
}

function showNewNoticeModal() {
	modal.classList.add("active")
	textArea.focus()
}

function closeNewNoticeModal() {
	modal.classList.remove("active")
	textArea.classList.remove("agent")
	clearTextArea()
	clearNoticer()
	hideUploadButton()
}

function clearTextArea() {
	textArea.value = ""
}

function clearNoticer() {
	noticerList.forEach(noticer => {
		noticer.classList.remove("selected")
	})
}

/**
 * 
 * @param {HTMLElement} element 
 */
function selectNoticer(element) {
	clearNoticer()
	element.classList.add("selected")
	let type = element.getAttribute("data-type")
	if (type === "ap") {
		textArea.classList.remove("agent")
	} else if (type === "agent") {
		textArea.classList.add("agent")
	}
}

function getNoticer() {
	let id
	if (notice.querySelector(".member.selected").getAttribute("data-ap-id")) {
		id = notice.querySelector(".member.selected").getAttribute("data-ap-id")
	} else if (notice.querySelector(".member.selected").getAttribute("data-agent-id")) {
		id = notice.querySelector(".member.selected").getAttribute("data-agent-id")
	}
	return {
		id: id,
		type: notice.querySelector(".member.selected").getAttribute("data-type")
	}
}

function isNoticerSelected() {
	if (notice.querySelector(".member.selected")) {
		return true
	} else {
		return false
	}
}

function isOkayToPublish() {
	if (
		textArea.value.replace(/\s+/g, "") !== "" &&
		isNoticerSelected()
	) {
		showUploadButton()
		return true
	} else {
		hideUploadButton()
		return false
	}
}

function showUploadButton() {
	uploadButton.classList.add("active")
}

function hideUploadButton() {
	uploadButton.classList.remove("active")
}

function uploadNotice() {
	let content = textArea.value.trim()
	let noticer = getNoticer()
	let isAgent = noticer.type === "agent"
	if (isAgent) {
		isAgent = 1
	} else {
		isAgent = 0
	}
	$.ajax({
		url: "ajax/upload-notice.php",
		type: "post",
		data: {
			content: content,
			noticerID: noticer.id,
			isAgent: isAgent
		},
		success: function (data) {
			if (data) {
				alert(data)
			} else {
				closeNewNoticeModal()
				refreshNotice()
			}
		},
		error: function (error) {},
		complete: function () {}
	})
}

function refreshNotice() {
	$.ajax({
		url: "ajax/load-more-notice.php",
		type: "post",
		data: {
			mode: "new",
			id: Number(noticeItemContainer.querySelector(".notice-item:first-child").getAttribute("data-notice-id")),
		},
		success: function (data) {
			try {
				data = JSON.parse(data)
				console.log(data)
				let frag = document.createDocumentFragment()
				for (let i = 0; i < data.length; i++) {
					frag.appendChild(buildNoticeItemBlock(data[i]))
				}
				insertBlock(frag, "begin")
			} catch (error) {
				console.log(error)
			}
		},
		error: function (error) {},
		complete: function () {}
	})
}
