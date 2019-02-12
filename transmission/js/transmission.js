// Functions

// 인수인계 입력창 열기
function openAddArea(memberDOM) {

	// if (document.querySelector(".add-transmit.hidden")) {
	// 	document.querySelector(".add-transmit.hidden").parentElement.querySelector(".add-content").classList.add("hidden")
	// 	document.querySelector(".add-transmit.hidden").classList.remove("hidden")
	// }
	

	memberDOM.querySelector(".add-transmit").classList.add("hidden")
	memberDOM.querySelector(".add-content").classList.remove("hidden")
	memberDOM.querySelector("textarea").focus()
}

// 인수인계 입력창 닫기
function closeAddArea(memberDOM) {
	memberDOM.querySelector(".add-transmit").classList.remove("hidden")
	memberDOM.querySelector(".add-content").classList.add("hidden")
	memberDOM.querySelector(".add-content textarea").value = ""
	memberDOM.querySelector(".transmitter").selectedIndex = 0
	resetShareMenu(memberDOM)
	memberDOM.querySelector('.option.basic').checked = true
	memberDOM.querySelector('.select-container').classList.add('hidden')
}

/**
 * 
 * @param {Element} memberDOM 
 */
function resetShareMenu(memberDOM) {
	let sharedSelects = memberDOM.querySelectorAll('.select-wrapper')
	for (let i = 0; i < sharedSelects.length - 1; i++) {
		sharedSelects[i].parentNode.removeChild(sharedSelects[i])
	}
	memberDOM.querySelector('.select-wrapper').querySelector('select').selectedIndex = 0
}

// 인수인계 항목 DOM 생성
function generateTransmitItem(fromName, content, transmitAt, doneAt, itemID, shared = false, isAlert = false) {

	let transmitItemWrapper = document.createElement("div")
	transmitItemWrapper.className = "transmit-item-wrapper"
	transmitItemWrapper.setAttribute('data-transmit-item-id', itemID)

	if (shared) {
		transmitItemWrapper.classList.add('shared')
	}

	if (isAlert) {
		transmitItemWrapper.classList.add('alert')
	}

	let transmitItem = document.createElement("div")
	transmitItem.className = "transmit-item"

	let info = document.createElement("div")
	info.className = "info"

	let name = document.createElement("span")
	name.className = "name"
	name.innerHTML = fromName + "이(가) 인계함"
	let date = document.createElement("span")
	date.className = "date"
	date.innerHTML = transmitAt

	let contentDOM = document.createElement("div")
	contentDOM.className = "content"
	// contentDOM.innerHTML = content.replace(/(?:\r\n|\r|\n)/g, '<br>')
	contentDOM.innerHTML = content

	let doneBtn = document.createElement("button")
	doneBtn.className = "item-done"
	doneBtn.innerHTML = "완료"
	if (!doneAt) {
		doneBtn.classList.add('hidden')
	}
	

	info.appendChild(name)
	info.appendChild(date)

	transmitItemWrapper.appendChild(transmitItem)

	transmitItem.appendChild(info)
	transmitItem.appendChild(contentDOM)
	transmitItem.appendChild(doneBtn)

	if (doneAt) {
		transmitItemWrapper.classList.add("is-done")
		doneBtn.innerHTML = doneAt + " 에 완료됨"
		doneBtn.disabled = true
	}

	return transmitItemWrapper
	
}

/**
 * 인수인계 완료시 완료됨 항목으로 이동
 * @param {Number} transmitItemID
 */
function moveTransmitItemUI(transmitItemID) {

	let allItems = document.querySelectorAll('.transmit-item-wrapper[data-transmit-item-id="' + transmitItemID + '"] ')

	console.log(allItems.length)

	for (let i = 0; i < allItems.length; i++) {

		$.ajax({
			url: 'php/mark-done.php',
			type: 'POST',
			async: false,
			data: {
				transmit_item_id: Number(allItems[i].getAttribute('data-transmit-item-id'))
			},
			success: function(data) {

				allItems[i].classList.add('item-remove')

				allItems[i].querySelector('.item-done').disabled = true

				allItems[i].classList.add('is-done')

				let now = data

				setTimeout(() => {

					let height = allItems[i].getBoundingClientRect().height

					allItems[i].style.height = height + 'px'

					setTimeout(() => {
						allItems[i].classList.add('wrapper-remove')

						setTimeout(() => {

							let doneContainer = allItems[i].closest('.member').querySelector('.section.done .item-container')

							doneContainer.insertBefore(allItems[i], doneContainer.firstElementChild)

							allItems[i].querySelector('.item-done').innerHTML = now + " 에 완료됨"

							setTimeout(() => {
								allItems[i].classList.remove('wrapper-remove')
								allItems[i].classList.remove('item-remove')

								updateCount(allItems[i].closest('.member'))

							}, 50);

						}, 200);


					}, 50);



				}, 0);

			},
			error: function(error) {

			},
			complete: function() {

			}
		})

	}

	

}

// UI에 인수인계 항목 추가
function addTransmitItemUI(transmitItemData, animate = false, direction = "after") {

	for (let i = 0; i < transmitItemData.length; i++) {

		$.ajax({
			url: '/ajax-php/get-ap-info.php',
			type: 'POST',
			async: false,
			data: {
				apID: transmitItemData[i]['from']
			},
			success: function(data) {

				data = JSON.parse(data)

				let name = data['name']

				let item = generateTransmitItem(name, transmitItemData[i]['content'], transmitItemData[i]['transmit_at'], transmitItemData[i]['done_at'], transmitItemData[i]['transmit_item_id'], transmitItemData[i]['shared'], Number(transmitItemData[i]['is_alert']))

				let doneItemContainer = document.querySelector('.member[data-ap-id="' + transmitItemData[i]['ap_id'] + '"] .transmit-item-container .done .item-container')

				let toDoItemContainer = document.querySelector('.member[data-ap-id="' + transmitItemData[i]['ap_id'] + '"] .transmit-item-container .to-do .item-container')

				let insertTarget


				if (transmitItemData[i]['done_at']) {
					insertTarget = doneItemContainer
				} else {
					insertTarget = toDoItemContainer
				}

				if (animate) {
					item.classList.add('wrapper-remove')
					item.classList.add('item-remove')
				}

				if (direction === "after") {
					insertTarget.appendChild(item)
				} else if (direction === "before") {
					insertTarget.insertBefore(item, insertTarget.firstChild)
				}
				

				updateCount(doneItemContainer.closest('.member'))

				if (animate) {
					setTimeout(() => {
						item.classList.remove('wrapper-remove')
						item.classList.remove('item-remove')
					}, 100);
				}

				
				
			},
			error: function(error) {

			},
			complete: function() {

			}
		})

	}
}

/**
 * 카운트 수정
 * @param {HTMLElement} memberDOM 
 * @param {Number} val 
 */
function updateCount(memberDOM, val) {
	
	let countDOM = memberDOM.querySelector('.left-count')

	let newVal = memberDOM.querySelectorAll('.transmit-item-wrapper:not(.is-done)').length

	countDOM.innerHTML = newVal

	if (newVal === 0) {
		countDOM.classList.add('hidden')
	} else {
		countDOM.classList.remove('hidden')
	}
}


// 서버에서 초기 인수인계 항목 가져오기
function fetchTransmitItem(apID, lastFetchedID, count) {

	$.ajax({
		url: 'php/fetch-transmit.php',
		type: 'POST',
		data: {
			ap_id: apID,
			last_fetched_id: lastFetchedID,
			count: count
		},
		success: function(data) {
			data = JSON.parse(data)

			// console.log(data)
			
			addTransmitItemUI(data['result'])
		},
		error: function(error) {

		},
		complete: function() {

		}
	})

}

// 서버에서 완료된 항목 더 가져오기
function fetchMoreDoneItem(apID, lastDoneDate) {

	$.ajax({
		url: 'php/fetch-done-transmit.php',
		type: 'POST',
		data: {
			ap_id: apID,
			last_done_date: lastDoneDate
		},
		success: function(data) {

			console.log(data)
			data = JSON.parse(data)

			console.log(data)

			addTransmitItemUI(data['result'])
		},
		error: function(error) {

		},
		complete: function() {

		}
	})

}

// 화면이 로드되면 수행
function init() {
	document.querySelectorAll(".member").forEach(function(memberDOM) {
		let apID = Number(memberDOM.getAttribute("data-ap-id"))
		fetchTransmitItem(apID, 0, 100)
	})
}

init()

/**
 * 
 * @param {Number} from 
 * @param {Array} to 
 * @param {String} content 
 */
function addTransmit(from, to, content, type, direction = "after") {
	
	$.ajax({
		url: 'php/add-transmit.php',
		type: 'POST',
		async: false,
		data: {
			from: from,
			to: to,
			content: content.trim(),
			type: type
		},
		success: function (data) {
			console.log(data)
			data = JSON.parse(data)
			if (data['err']) {
				alert("오류가 발생했습니다. " + data['err_msg'])
			} else {

				addTransmitItemUI(data['result'], true, direction)

			}
		},
		error: function (error) {

		},
		complete: function () {

		}
	})
}



// Event Listeners

// 인수인계 입력 버튼
document.querySelectorAll(".add-transmit").forEach(function(item) {
	item.addEventListener("click", function() {
		openAddArea(this.closest(".member"))
	})
})

// 인수인계 취소 버튼
document.querySelectorAll(".add-content button.cancel").forEach(function(item) {
	item.addEventListener("click", function() {
		closeAddArea(this.closest(".member"))
	})
})

// 인수인계 등록 완료 버튼
document.querySelectorAll(".add-content button.done").forEach(function (item) {

	item.addEventListener("click", function () {

		let memberDOM = this.closest(".member")

		// 인수인계 내용
		let content = memberDOM.querySelector(".input-area").value

		if (content.replace(/\s+/g, "") === "") {
			alert("내용을 입력하세요.")
			return
		}

		// 인계자 선택했는지 확인
		let from = Number(memberDOM.querySelector(".transmitter").value)
		
		if (from === 0) {
			alert("인계자를 선택하세요.")
			return
		}

		// 인수인계 타입
		let typeOptions = memberDOM.querySelectorAll('.type-option-wrapper .option')
		let type = 1 // default 1
		for (let i = 0; i < typeOptions.length; i++) {
			if (typeOptions[i].checked) {
				type = Number(typeOptions[i].value)
				break
			}
		}

		// 인수자
		let to = []

		if (type === 2) {

			document.querySelectorAll('.member').forEach(function(memItem) {
				to.push(Number(memItem.getAttribute('data-ap-id')))
			})

		} else {

			if (type === 1) {

				to.push(Number(memberDOM.getAttribute("data-ap-id")))
				
			} else if (type === 3) {

				

				if (memberDOM.querySelector('.select-all-wrapper .checkbox').checked) {
					console.log("전체 공유 활성화")
					document.querySelectorAll('.member').forEach(function(item) {
						to.push(Number(item.getAttribute('data-ap-id')))
					})
				} else {
					let sharedCount = 0
					to.push(Number(memberDOM.getAttribute("data-ap-id")))

					memberDOM.querySelectorAll('.shared-with').forEach(function(item) {
						if (Number(item.value) !== 0) {
							to.push(Number(item.value))
							sharedCount++
						}
					})

					if (sharedCount === 0) {
						alert("공유자가 없습니다.")
						return
					}
				}



			}

			

			

		}
		

		addTransmit(from, to, content, type, "before")
		
		closeAddArea(this.closest(".member"))

	})
})

// 공유자 추가할 때 새로운 공유자 추가란 생성
window.addEventListener('change', function(e) {

	if (e.target.closest('.shared-with')) {

		let sharedSelect = e.target.closest('.shared-with')
		let alreadyExist = false
		let lastChild = false
		let dup = false

		let otherSharedSelects = sharedSelect.closest('.add-content').querySelectorAll('.shared-with')

		otherSharedSelects.forEach(function(a) {
			if (a !== sharedSelect) {
				if (a.value === sharedSelect.value && !dup) {
					
					alert('이미 선택되었습니다.')

					alreadyExist = true
					sharedSelect.selectedIndex = 0

					dup = true

				}
			}

			if (sharedSelect === otherSharedSelects[otherSharedSelects.length - 1]) {
				lastChild = true
			}
			
		})

		if (!alreadyExist && lastChild && !dup) {
			let duplicated = sharedSelect.parentNode.cloneNode(true)
			sharedSelect.parentNode.parentNode.insertBefore(duplicated, sharedSelect.parentNode.nextSibling)
		}
		
	}

})

// 공유자 삭제 버튼 클릭
window.addEventListener('click', function(e) {
	if (e.target.closest('.shared-delete')) {
		if (
			e.target.closest('.add-content').querySelectorAll('.select-wrapper').length > 1 &&
			e.target.closest('.shared-delete').previousElementSibling.selectedIndex !== 0
		) {
			e.target.closest('.select-wrapper').parentNode.removeChild(e.target.closest('.select-wrapper'))
		}
	}
})

// 항목 완료 버튼 눌렀을 때
document.querySelector('.transmission-board').addEventListener('click', function(e) {
	if (e.target.closest('.item-done')) {
		console.log('clicked done')
		moveTransmitItemUI(Number(e.target.closest('.transmit-item-wrapper').getAttribute('data-transmit-item-id')))
	}
})

// 항목 클릭 시 완료 버튼 표시
window.addEventListener('click', function (e) {
	if (e.target.closest('.transmit-item-wrapper:not(.is-done)')) {
		e.target.closest('.transmit-item-wrapper').querySelector('.item-done').classList.toggle('hidden')
	}
})

// 인수인계 타입 옵션 선택 시
document.querySelectorAll('.type-option-wrapper .option').forEach(function(item) {
	item.addEventListener('click', function(e) {

		if (e.target.closest('.share')) {
			e.target.closest('.add-content').querySelector('.select-container').classList.remove('hidden')
		} else {
			e.target.closest('.add-content').querySelector('.select-container').classList.add('hidden')
		}
	})
})

// 맨 아래로 스크롤 시 지난 완료된 항목 추가로 가져옴
document.querySelectorAll('.transmit-item-container').forEach(function(tic) {
	tic.addEventListener('scroll', function() {
		console.log(tic.scrollTop + tic.getBoundingClientRect().height - 10, tic.scrollHeight)
		if (tic.scrollTop + tic.getBoundingClientRect().height >= tic.scrollHeight) {
			console.log('fetching more history...')
			let apID = Number(tic.closest('.member').getAttribute('data-ap-id'))
			let isDone = tic.querySelectorAll('.is-done')
			console.log(isDone)
			let lastDoneDate = isDone[isDone.length - 1].querySelector('.date').innerHTML
			console.log(lastDoneDate)
			// fetchTransmitItem(Number(tic.closest('.member').getAttribute('data-ap-id')), )
			fetchMoreDoneItem(apID, lastDoneDate)
		}
	})
})

// 전체공유 활성화/해제 시
