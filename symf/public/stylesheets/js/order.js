function clearActive() {
  $('.title.active').each(function(index) {
    $(this).removeClass('active');
    $('#changeOrder').css('display', 'none');
  })
}

function initOrder() {
  $('.title').each(function(index) {
    $(this).hover(function() {

      $(this).css('cursor', 'pointer');

      $(this).click(function() {
        clearActive();
        $(this).addClass('active');
        $('#changeOrder').css('display', 'flex');
      });
    });
  });
}


function moveOrder(e) {
  var way = $(e.target).data('move');
  var min = 1;
  var max = $('.title').length;
  var selected = $('.title.active').parent();
  var hisOrder = $(selected).data('order');
  
  
  var searched = (way == 'up') ? (hisOrder - 1) : (hisOrder + 1);
  
  if (searched >= min  && searched <= max) {
    var target = $('tr[data-order='+ searched +']');
    $(selected).replaceAll(target);
    
    if (way == 'up') {
      $(target).insertAfter($(selected));
    } else {
      $(target).insertBefore($(selected));
    }
    
    $(selected).data('order', searched);
    $(target).data('order', hisOrder);
    $(selected).attr('data-order', searched);
    $(target).attr('data-order', hisOrder);
    
    updateOrder(target, selected);
  }
  
  initOrder();
}

function updateOrder(target, selected) {
  
  console.log(target);
  console.log(selected);
  
  var tgtParams = {
    id: $(target).data('ident'),
    order: $(target).data('order')
  }
  
  var sldParams = {
    id: $(selected).data('ident'),
    order: $(selected).data('order')
  }
  
  var params = {
    target: tgtParams,
    selected: sldParams
  }
  
  $.ajax({
    type: 'POST',
    url: '/admin/skill/order',
    data: JSON.stringify(params),
    contentType: 'application/json',
    async: true,
    success: function(response) {
      console.log(response);
    },
    error: function(response) {
      console.log(response);
    }
  });
}

$(document).ready(initOrder);
$('#orderUp').click(moveOrder);
$('#orderDown').click(moveOrder);


