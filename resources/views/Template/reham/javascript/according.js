const toggleItems = Array.from(document.querySelectorAll('.toggle__according'))

toggleItems.forEach(el => {
    el.addEventListener('click', () => {
       const accBody = document.getElementById(`${el.getAttribute('data-index')}`);
       accBody.classList.contains('--show') ?
       accBody.classList.remove('--show') : 
       accBody.classList.add('--show');
    })
})