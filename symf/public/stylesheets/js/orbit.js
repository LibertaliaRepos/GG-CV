/**
 * Close the zoomed orbit window.
 */
function closeOrbit() {
  $('.whiteDiv').each(function(){$(this).remove();});

  $('.orbit[data-zoomed=true]').each(function() {

    $(this).attr('data-zoomed', 'false');
    $(this).data('zoomed', false);
    $(this).css('max-width', '');
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
    
    $(this).attr('data-zoomed', true);
    $(this).css('max-width', (windowWidth * 0.33) + 'px' );
    $(this).data('zoomed', true);
    $('#openedOrbitBack').attr('data-status', 'opened');
        
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



$(window).ready(initOrbit);



