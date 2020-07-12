// login form

var inputs = document.querySelectorAll('input'),
    index = 0;

for(index = 0; index < inputs.length; index += 1){

  // add onfocus event
  inputs[index].onfocus = function(){
     this.setAttribute('data-place',this.getAttribute('placeholder'));
     this.setAttribute('placeholder','');
  }

  // add onblur event
  inputs[index].onblur = function(){
    this.setAttribute('placeholder',this.getAttribute('data-place'));
  }
}   

// welcoming message Animation

var text = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Numquam, architecto. Alias odio eveniet ratione molestiae quos iste rem.",
     p = document.querySelector('section p'),
     i = 0,
     id;
window.onload = function(){
  id = setInterval(function(){
    p.textContent += text[i];
    i += 1;
    if(i >= text.length){
      clearInterval(id);
    }
  },30);
}     