// navigation menu
var menu = document.getElementById('menu'),
    menuBarOne = document.getElementById('menuBarOne'),
    menuBarTwo = document.getElementById('menuBarTwo'),
    ulSlide = document.getElementById('ulSlide'),
    subNav = document.getElementById('subNav'),
    DoIt = true,
    isHidden = true;
if(menu!== null){
    menu.onclick = function(){
        menuBarOne.style.display = DoIt ? 'flex':'none';
        if(menuBarTwo!== null){
            menuBarTwo.style.display = DoIt ? 'flex':'none';
        }
        DoIt = !DoIt;
    }
}
if(subNav !== null){
    subNav.onclick = function(){
        ulSlide.style.display = isHidden ? 'flex':'none';
        isHidden = !isHidden;
    }
}

window.onresize = function(){
        if(window.innerWidth > 768){
            if(menuBarOne !== null){
                menuBarOne.style.display = 'block';
            }
            if(menuBarTwo !== null){
                menuBarTwo.style.display = 'flex';
            }
        }else{
            if(menuBarOne !== null){
                menuBarOne.style.display = 'none';
            }
            if(menuBarTwo !== null){
                menuBarTwo.style.display = 'none';
            }
        }
}