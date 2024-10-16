const switchers = [...document.querySelectorAll('.switcher')]

switchers.forEach(item => {
	item?.addEventListener('click', function() {
		switchers.forEach(item => item.parentElement.classList.remove('is-active'))
		this.parentElement.classList.add('is-active')
	})
})

let viewMode = document.getElementById("viewMode");
let changeMode = document.getElementById("changeMode");
let viewWrapper = document.getElementById("viewWrapper");
let changeWrapper = document.getElementById("changeWrapper");
viewMode?.addEventListener("click", ()=> {
	changeWrapper.classList.remove('is-active');
	viewWrapper.classList.add('is-active');
});

changeMode?.addEventListener("click", ()=> {
	viewWrapper.classList.remove('is-active');
	changeWrapper.classList.add('is-active');
});
	