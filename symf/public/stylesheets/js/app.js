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

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    
    reader.onload = function(e) {
      $('#pictPreview figure img').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function escapeHtml(text) {
  var map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };

  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}






