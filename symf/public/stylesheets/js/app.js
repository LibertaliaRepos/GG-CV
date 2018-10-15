$(document).foundation();

function leftWidth() {
  var logo = $('#top-menu').find('.logo:first-child');
  var leftWidth = logo.width() + 'px';
  $('#toAnchor').css('width', leftWidth);
  console.log(logo);
  console.log(leftWidth);
  
//  var logo = document.querySelector('#top-menu .logo:first-child');
//  var leftWidth = logo.clientWidth;
//  
//  document.getElementById('toAnchor').style.width = leftWidth + 'px';
//  
//  console.log(logo);
//  console.log(leftWidth);
  
}

//window.addEventListener('load', leftWidth, false);

$(document).ready(leftWidth());