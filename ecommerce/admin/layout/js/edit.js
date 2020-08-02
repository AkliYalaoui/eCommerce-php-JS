//add astrisk on required fields
var requiredFields = document.querySelectorAll('form input[required=""]');

for(required of requiredFields){
    var astrisk = document.createElement("span");
        astrisk.appendChild(document.createTextNode('*'));
        astrisk.classList.add('astrisk');
    required.parentElement.appendChild(astrisk);
}

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

//check for Number Input

var numberInputs= document.querySelectorAll('input[type="number"]');

for(num of numberInputs){
  num.onblur =  function(){

    var min = parseInt(this.getAttribute('min'));
    var value = parseInt(this.value) ;
        this.value  = value;
    if(value < min){
        this.value = min;
    }
  };
}

//categories View Option
var fullView =  document.querySelectorAll('details.full-view');
var classic = document.getElementById('classic');
var full = document.getElementById('full');
if(classic !== null){
  classic.onclick = function(){
    for(detail of fullView){
      if(detail.hasAttribute('open')){
        detail.removeAttribute('open');
      }
    }
    this.classList.add('active');
    full.classList.remove('active');
};
}
if(full !== null){
  full.onclick = function(){
    for(detail of fullView){
      if(!detail.hasAttribute('open')){
        detail.setAttribute('open','');
      }
    }
    this.classList.add('active');
    classic.classList.remove('active');
  };
}

//dashboard
var toggleInfos =  document.querySelectorAll('.toggle-info');
for(toggleInfo of toggleInfos){
  toggleInfo.onclick = function(){
    var panelBody = this.parentElement.nextElementSibling;
    var icon = this.firstElementChild;
        panelBody.classList.toggle('hide');
        if(panelBody.classList.contains('hide')){
          icon.classList.remove('fa-plus');
          icon.classList.add('fa-minus');
        }else{
          icon.classList.add('fa-plus');
          icon.classList.remove('fa-minus');
        }
  };
}