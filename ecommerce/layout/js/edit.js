//add astrisk on required fields
var requiredFields = document.querySelectorAll('form *[required=""]');

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

//select All passwords Fields

var passwords = document.querySelectorAll('input[type="password"]');

for(pwd of passwords){
  var eye = document.createElement('i');
      eye.classList.add('fa');
      eye.classList.add('fa-eye');
      eye.classList.add('eye');
  pwd.parentElement.appendChild(eye);
  pwd.setAttribute('data-type','text');
  eye.onclick = function(){
    var type = pwd.getAttribute('data-type');
    pwd.setAttribute('data-type',pwd.getAttribute('type'));
    pwd.setAttribute('type',type);
  }
}
//login and sigin
var spans = document.querySelectorAll('.lg-sg span');

for(sp of spans){
  sp.onclick = function(){
    document.getElementById(this.getAttribute('data-show')).classList.add('show');
    document.getElementById(this.getAttribute('data-hide')).classList.remove('show');
    this.classList.add('show');
    if(this.nextElementSibling !== null){
      this.nextElementSibling.classList.remove('show');
    }else{
      this.parentElement.firstElementChild.classList.remove('show');
    }
  }
}

//create Ad Live Preview
if(document.querySelector('form.live-preview')!== null && document.querySelector('.card.live-preview')!== null){
  document.querySelector('form.live-preview input[name="name"]').oninput = function(){
    document.querySelector('.card .card-body h3').textContent = this.value;
  };
  document.querySelector('form.live-preview input[name="description"]').oninput = function(){
    document.querySelector('.card .card-body p').textContent = this.value;
  };
  document.querySelector('form.live-preview input[name="price"]').oninput = function(){
    document.querySelector('.card .card-overlay span').textContent = "$" + this.value;
  };
}