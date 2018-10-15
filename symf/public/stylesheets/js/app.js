$(document).foundation();


$(document).scroll(function() {
  var toAnchor = $('#toAnchor');
  var toAnchorPos = toAnchor.offset();
  var scrollTop = $(document).scrollTop();
  var leftLogoHeight = $('#left-logo').outerHeight();

  
  if (scrollTop >= (leftLogoHeight - 50)) {
      var top = ((scrollTop - leftLogoHeight) + 200) + 'px';
      toAnchor.css('top', top);
  }
});

function skillImageDim() {
  var skill_elems = $('#skills > section');
  
  skill_elems.each(function(index) {  
    var h2 = $(this).find('h2')[0];
    var text = $(this).find('p')[0];
    var img = $(this).find('img')[0];
    
    var h2Height = $(h2).outerHeight(true);
    var textHeight = $(text).outerHeight(true);
    
    var blockHeight = h2Height + textHeight + 10;
    
    $(img).css('max-height', blockHeight + 'px');
  });
  
  console.log(skill_elems);
  
}

$(document).ready(skillImageDim());
$(window).resize(function() {
  skillImageDim();
});




