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


function MyAccordion(element) {
  this.header = $(element).find('.myAccordion-header');
  this.content = $(element).find('.myAccordion-content');
  this.arrow = null;
  this.header.opened = '<span class="arrow" title="Réduire">⬆</span>';
  this.header.closed = '<span class="arrow" title="Ouvrir">⬇</span>';
  this.open = function(e) {
    console.log(this);

    var header = e.data.header;
    var content = e.data.content;
    var opened = $(header).attr('data-opened');
    var title = {
      open: 'Réduire',
      close: 'Ouvrir'
    };
    var arrows = {
      open: '⬇',
      close: '⬆'
    };



    if(opened == 'true') {
      var parentH = $(header).outerHeight() + 'px';

      $(this).attr('title', title.open);
      $(this).text(arrows.open);

      $(header).attr('data-opened', 'false');
      $(content).css('height', '0');
      $(content).parent().css('height', parentH);
    } else if(opened == 'false') {
      $(this).attr('title', title.close);
      $(this).text(arrows.close);

      $(header).attr('data-opened', 'true');
      $(content).css('height', '');
      $(content).parent().css('height', '');
    }
  }
  this.init = function() {
    var open = $(this.header).attr('data-opened');

    if (open == 'true') {
      $(this.header).append(this.header.opened);
    } else if (open == 'false') {
      $(this.header).append(this.header.closed);
    }

    
    this.arrow = $(this.header).find('.arrow');
    this.arrow.on('click', {header: this.header, content: this.content},this.open);

    if (open == 'false') {
      $(this.header).attr('data-opened', 'true');
      this.arrow.trigger('click', {header: this.header, content: this.content});
    }
  }
}