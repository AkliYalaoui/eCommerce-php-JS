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