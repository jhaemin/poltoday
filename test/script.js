"use strict"

// API (Application Programming Interface)

// DOM (객체)

// Event, EventListener

let btn = document.getElementsByClassName("btn")[0]

let inputBox = document.getElementById("input-box")


inputBox.addEventListener("input", e => {
	document.querySelector("p").innerHTML = inputBox.value
})

let str1 = "hello "
let str2 = "윤현"

