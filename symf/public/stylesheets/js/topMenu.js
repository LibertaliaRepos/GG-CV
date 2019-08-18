var XPPRObtn = {
  init: function () {

    this.refactor();
    $(window).resize(this.refactor);
  },

  refactor: function() {
    var width = {global: $(window).outerWidth(true), minimum: 1000};
    var text = { long: 'Expériences pro', short: 'XP. Pro' , abbr: 'Expériences professionnelles'};
    var element = $('#menuXppro');

    if (width.global < width.minimum) {
      $(element).data('short', true);
    } else {
        $(element).data('short', false);
    }

    if ($(element).data('short')) {
      $(element).text(text.short);
      $(element).attr('title', text.abbr);
    } else {
        $(element).text(text.long);
        $(element).removeAttr('title');
    }
  }
};

// var offCanvas = {
//     off: $('<div id="" class="off-canvas position-left" data-off-canvas></div>'),
//     content: $('<div class="off-canvas-content" data-off-canvas-content></div>'),
//     button: $('<button type="button" class="button" data-toggle="">Menu</button>'),
//     width: {global: $(window).outerWidth(true), minimum: 1000},
//
//
//   init: function (ident) {
//       this.id = ident;
//       $(this.off)[0].id = this.id;
//       $(this.button).attr('data-toggle', this.id);
//
//
//       $(window).resize(this.displaying);
//   },
//
//   displaying: function () {
//       offCanvas.width.global = $(window).outerWidth(true);
//
//
//
//
//       console.log(offCanvas.width);
//   }
// }

// function displayCanvas (real) {
//   console.log(real);
// }

$(document).ready(XPPRObtn.init());
// $(document).ready(offCanvas.init('offCanvas'));

