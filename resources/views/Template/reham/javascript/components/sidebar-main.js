const sideMain = document.getElementById('sideMain');
const sideMainClose = document.getElementById('sideMainClose');
const closeSideMain = document.getElementById('closeSideMain');
const openSideMain = document.getElementById('openSideMain');


sideMainOpen.addEventListener('click',  () => {
    toggleSideMenu();
    sideMainOpen.classList.add('d-none');
    setTimeout(() => {
        window.scrollTo(0,0);
    }, 800);

})


closeSideMain.addEventListener('click', () => {
    toggleSideMenu();
    sideMainOpen.classList.remove('d-none');
    
});

function toggleSideMenu(){
    if(sideMenu.classList.contains('--close') ){
        sideMenu.classList.remove('--close')
        sideMenu.classList.add('--open') 
    } else {
        sideMenu.classList.add('--close')
        sideMenu.classList.remove('--open') 

    }
}