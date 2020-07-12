// navigation menu
var menu = document.getElementById('menu'),
    menuBarOne = document.getElementById('menuBarOne'),
    menuBarTwo = document.getElementById('menuBarTwo'),
    ulSlide = document.getElementById('ulSlide'),
    subNav = document.getElementById('subNav'),
    DoIt = true,
    isHidden = true;

menu.onclick = function(){
    menuBarOne.style.display = DoIt ? 'flex':'none';
    menuBarTwo.style.display = DoIt ? 'flex':'none';
    DoIt = !DoIt;
}
subNav.onclick = function(){
    ulSlide.style.display = isHidden ? 'flex':'none';
    isHidden = !isHidden;
}

window.onresize = function(){
    
    if(window.innerWidth > 768){
        menuBarOne.style.display = 'block';
        menuBarTwo.style.display = 'flex';
    }else{
        menuBarOne.style.display = 'none';
        menuBarTwo.style.display = 'none';
    }
}