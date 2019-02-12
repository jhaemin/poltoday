window.addEventListener("load", (e) => {

	let passInputWrapper = document.createElement("div")
	let title = document.createElement("p")
	title.innerHTML = "암호를 입력하세요."
	title.style.color = "#fff"
	title.style.fontSize = "15px"
	title.style.marginBottom = "15px"
	title.style.textAlign = "center"

	let passBG = document.createElement("div")
	passBG.className = "pass-background"
	passBG.style.position = "fixed"
	passBG.style.left = "0"
	passBG.style.top = "0"
	passBG.style.right = "0"
	passBG.style.bottom = "0"
	passBG.style.zIndex = "99999999"
	passBG.style.backgroundColor = "rgba(0,0,0,0.8)"
	passBG.style.display = "flex"
	passBG.style.alignItems = "center"
	passBG.style.justifyContent = "center"
	// document.body.appendChild(passBG)

	let passInput = document.createElement("input")
	passInput.className = "pass-input"
	passInput.type = "password"
	// passInput.style.width = "200px"
	// passInput.style.textAlign = "center"
	// passInput.style.border = "none"
	// passInput.style.backgroundColor = "#fff"
	// passInput.style.padding = "10px"
	// passInput.style.fontSize = "20px"
	// passInput.style.borderRadius = "8px"

	passInputWrapper.appendChild(title)
	passInputWrapper.appendChild(passInput)

	passBG.appendChild(passInputWrapper)

	let nav = document.querySelector("nav")
	let main = document.querySelector("main")

	passInput.addEventListener("keydown", e => {
		let key = e.key
		if (key === "Enter") {
			console.log("start validating...")
			checkValidation(passInput.value)
		}
	})
		
	$.ajax({
		url: '/modules/password/check-validation.php',
		type: "post",
		
		success: function (data) {
			console.log(data)
			if (!Number(data)) {
				showPassInput()
			}
		},
		error: function (error) {},
		complete: function () {}
	})
		
	function setValidation() {
		$.ajax({
			url: '/modules/password/set-validation.php',
			type: "post",
			 
			success: function (data) {
				console.log(data)
			},
			error: function (error) {},
			complete: function () {}
		})
	}

	function checkValidation(inputPassword) {
		$.ajax({
			url: '/modules/password/check-validation.php',
			type: "post",
			data: {
				pass: inputPassword
			},
			 
			success: function (data) {
				if (Number(data)) {
					setValidation()
					hidePassInput()
				} else {
					// 패스워드 틀림
					shakePassInput()
					passInput.value = ""
				}
			},
			error: function (error) {},
			complete: function () {}
		})
	}
		
	function showPassInput() {

		let tempFrag = document.createDocumentFragment()
		tempFrag.appendChild(nav)
		tempFrag.appendChild(main)

		document.body.appendChild(passBG)
		passInput.focus()
	}

	function hidePassInput() {
		document.body.removeChild(passBG)
		document.body.appendChild(nav)
		document.body.appendChild(main)
	}

	function shakePassInput() {
		passInput.classList.add("shake")
		setTimeout(() => {
			passInput.classList.remove("shake")
		}, 350)
	}

})
