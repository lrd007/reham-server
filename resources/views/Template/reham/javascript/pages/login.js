const restForm = document.getElementById("restForm")
const toggleRestForm = document.getElementById("toggleRestForm")

toggleRestForm.addEventListener('click',()=> {
    restForm.classList.contains('d-none') ?
    restForm.classList.remove('d-none') :
    restForm.classList.add('d-none')
})