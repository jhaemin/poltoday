let dropZone = document.querySelector('#drop-zone')
let pageContainer = document.querySelector('.page-container')
let fileReader = new FileReader()

let options = document.querySelectorAll('input[name=page-count]')
let divideCount

dropZone.addEventListener('dragenter', function(e) {
	e.preventDefault()
	this.className = 'dragover'
})

dropZone.addEventListener('dragover', function (e) {
	e.preventDefault()
	this.className = 'dragover'
})

dropZone.addEventListener('dragleave', function (e) {
	this.className = ''
})

dropZone.addEventListener('drop', function(e) {
	console.log('drop')
	dropHandler(e)
})

function setDivideCount() {
	for (let i = 0; i < options.length; i++) {
		if (options[i].checked) {
			divideCount = Number(options[i].value)
		}
	}
	if (divideCount === 2) {
		pageContainer.classList.add('landscape')
	}
}

let dt, files, sortFiles = [], threshold = 0, pageTarget

/**
 * 
 * @param {DragEvent} e 
 */
function dropHandler(e) {

	setDivideCount()

	setPage()

	e.preventDefault()
	e.stopPropagation()

	let firstImgHolder = addPage()

	dt = e.dataTransfer
	files = dt.files

	sortFiles = []
	for (let i = 0; i < files.length; i++) {
		sortFiles.push(files[i])
	}

	sortFiles.sort(function(a, b) {
		if (a.name < b.name) return -1
		if (a.name > b.name) return 1
		return 0
	})

	pageTarget = firstImgHolder
	loadPage()

}

function loadPage() {
	console.log('load', sortFiles.length)
	if (sortFiles.length === 0) {
		return
	}
	fileReader.readAsDataURL(sortFiles[0])
	fileReader.onloadend = function() {
		let imgWrapper = document.createElement('div')
		imgWrapper.className = 'img-wrapper'
		let img = document.createElement('img')
		imgWrapper.appendChild(img)
		img.src = fileReader.result
		img.className = 'image'
		pageTarget.appendChild(imgWrapper)
		threshold++
		sortFiles.shift()
		if (threshold >= divideCount) {
			threshold = 0
			if (sortFiles.length > 0) {
				pageTarget = addPage()
			}
			
		}
		
		loadPage()
		
	}
}

function setPage() {
	dropZone.style.display = 'none'
	pageContainer.style.display = ''
}

function addPage() {
	console.log("page was added")
	let newPage = document.createElement('div')
	newPage.classList = 'page page-a4 img-holder'
	
	pageContainer.appendChild(newPage)
	return newPage
}