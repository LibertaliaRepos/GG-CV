/**
 * Close the zoomed orbit window.
 */
function closeOrbit() {
  $('.whiteDiv').each(function(){$(this).remove();});

  $('.orbit[data-zoomed=true]').each(function() {
    
    var cssDesabled = ['max-width', 'max-height','top', 'left'];

    $(this).attr('data-zoomed', 'false');
    $(this).data('zoomed', false);
//    $(this).css('max-width', '');
    
    for (var i = 0; i < cssDesabled.length; ++i) {
      $(this).css(cssDesabled[i], '');
    }
    
    $('#openedOrbitBack').attr('data-status', 'closed');
    
    initOrbit();
  });
}

function openOrbit() {  
  if (!$(this).data('zoomed')) {
    var whiteDiv = $('<div></div>');

    $(whiteDiv).css('width', $(this).outerWidth(false) + 'px');
    $(whiteDiv).addClass('whiteDiv');
    $(this).before(whiteDiv);
    
    
    var windowWidth = $(window).outerWidth();
    var windowHeight = $(window).outerHeight();
    
    $(this).attr('data-zoomed', true);
    $(this).data('zoomed', true);
    positionZoomed();
    $('#openedOrbitBack').attr('data-status', 'opened');
    
    $(window).resize(positionZoomed);
        
    $(this).off('click');

    $(this).mouseleave(function() {
      $('body').click(closeOrbit);
    });

    $(this).mouseenter(function(e) {
      $('body').off('click', closeOrbit);
    });
    
    var ident = '#' + $(this).attr('id');
    
    $(this).find('.orbit-exit').click(function() {
      $(ident).trigger('mouseleave');
    });
  }
}

function initOrbit() {
  $('.orbit').each(function(index) { 
    $(this).click(openOrbit);
  });
  
  $('.orbit-next, .orbit-previous').each(function(index) {
    var container = $(this).parent().parent().parent();
    $(this).mouseenter(function() {
      $(container).off('click', openOrbit);
    });
    $(this).mouseleave(function() {
      $(container).click(openOrbit);
    });
  });
  $('.orbit-bullets button').each(function(index) {
    var container = $(this).parent().parent();
    $(this).mouseenter(function() {
      $(container).off('click', openOrbit);
    });
    $(this).mouseleave(function() {
      $(container).click(openOrbit);
    });
  });
}

function disableOpenOrbit(param) {
  var container = param.data.container;
  alert(container);
}

function positionZoomed() {
  
  var windowWidth = $(window).outerWidth();
  var windowHeight = $(window).outerHeight();
  var zoomed = $('[data-zoomed=true]');
  
  $(zoomed).css('max-width', (windowWidth * 0.5) + 'px' );
  $(zoomed).css('max-height', (windowHeight * 0.5) + 'px' );
  
  var orbitDim = {
      height: $(zoomed).outerHeight(),
      width: $(zoomed).outerWidth()
    }
    
    var orbitPos = {
      left: (windowWidth - orbitDim.width) / 2,
      top: (windowHeight - orbitDim.height) / 2
    }
    
    $(zoomed).css('left', orbitPos.left + 'px');
    $(zoomed).css('top', orbitPos.top + 'px');
}

$(window).ready(initOrbit);





