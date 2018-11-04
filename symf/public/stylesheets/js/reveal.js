function openRevealListen() {
  
  $('a[data-open-reveal]').each(function(index) {
    $(this).click(function (e) {
      
      var ref = {
        ident: $(e.currentTarget).data('open-reveal'),
        title: $(e.currentTarget).data('parent-title'),
        action : $(e.currentTarget).data('action')
      }
      
      $('#beforeDel .ref-title').text(ref.title);
      $('#beforeDel a[data-delete]').attr('data-delete', ref.ident);
      $('#beforeDel a[data-delete]').attr('data-action', ref.action);
      
      $('#beforeDel').foundation('open');
      
      
    });
  });
  
  
  
  $('#beforeDel[data-reveal]').on('open.zf.reveal', function() {
    $('[data-abort]').click(function() {
      $('#beforeDel').foundation('close');
    });
    
    $('[data-delete]').click(function() {
      var ident = $(this).data('delete');
      var action = $(this).data('action');
      
      $.ajax({
        type: 'POST',
        url: '/admin/' + action + '/del/' + ident,
        async: true,
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          console.log(response);
        }
      });
    });
  });
}

$(document).ready(openRevealListen);