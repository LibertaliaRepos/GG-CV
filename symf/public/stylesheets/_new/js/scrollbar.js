/**
 *
 */
class Scroller {
    constructor(explanation, scrollbar, active) {
        this.explanation = explanation;
        this.scrollbar = scrollbar;
        this.active = active;
        this.toScroll = null;
        this.step = 5;
        this.currentScrolling = 0;
    }

    init() {
        this.showScrollbar();
        this.moveScrollbar();

        this.initScrollbar();
    }

    showScrollbar() {
        if (this.requestRealHeight() > this.requestExplanationHeight()) {
            $(this.scrollbar.container).css('display', 'block');
        } else {
            $(this.scrollbar.container).css('display', 'none');

            return;
        }

        this.toScroll = this.requestRealHeight() - this.requestExplanationHeight();

        this.listen();
    }

    scrolling(deltaY) {

        if (deltaY > 0)
            this.scrollUp();
        else
            this.scrollDown();

        this.moveScrollbar();

        this.scrollbar.position = {top: this.scrollbar.calcPosition(), left: null};
    }

    scrollUp() {
        this.currentScrolling -= this.step;

        if (Math.abs(this.currentScrolling) < this.toScroll ) {

            var scroll = this.currentScrolling;

            $(this.explanation).children().each(function () {
                $(this).css('transform', 'translateY(' + scroll + 'px)');
            });
        } else {
            this.currentScrolling = - this.toScroll;
        }
    }

    scrollDown() {
        this.currentScrolling += this.step;

        if (this.currentScrolling < 0) {

            var scroll = this.currentScrolling;
            $(this.explanation).children().each(function () {
                $(this).css('transform', 'translateY(' + scroll + 'px)');
            });
        } else {
            this.currentScrolling = 0;
        }
    }

    moveScrollbar() {
        this.scrollbar.percent = this.scrollPercent();

        this.scrollbar.move();
    }

    initScrollbar() {
        var scroller = this;

        $(this.scrollbar.svg).draggable({
            start: function(e, ui) {
            },
            drag: function (e, ui) {


                ui.position.left = null;

                var max = $(scroller.scrollbar.container).outerHeight(false) + $('#globalHead').outerHeight(true) + $('#contentHead h1').outerHeight(true) - scroller.scrollbar.svg[0].getBBox().height ;

                if (ui.position.top < 0)
                    ui.position.top = 0;
                else if (ui.position.top > max)
                    ui.position.top = max;

                var y = (ui.position.top / scroller.scrollbar.height) * 100;
                $(scroller.scrollbar.svg).attr('y', y + '%');

                // if (y >= 100) {
                //     y = y * scroller.scrollbar.scale;
                //     ui.position.top = y
                // }


                // var scrolleY = -(scroller.scrollbar.percent / 100) * scroller.toScroll;
                //
                // $(scroller.explanation).children().each(function () {
                //     $(this).css('transform', 'translateY(' + scrolleY + 'px)');
                // });
                // $(scroller.explanation).attr('data-translate', scrolleY);
            },
            stop: function (e, ui) {
            }
        });
    }

    requestRealHeight() {
        var height = 0;

        $(this.explanation).children().each(function () {
            height += $(this).outerHeight(true);
        }) ;

        return height;
    }

    requestExplanationHeight() { return $(this.explanation).outerHeight(false); }

    scrollPercent() { return (Math.abs(this.currentScrolling) / this.toScroll) * 100; }

    listen() {
        $(this.explanation).on('wheel', {scroller : this}, function (e) { e.data.scroller.scrolling(e.originalEvent.deltaY); });
    }
}

/**
 *
 */
class Scrollbar {
    constructor(container, svg, percent = null) {
        this.container = container;
        this.svg = svg;
        this.percent = percent;
        this.min = 0;
        this.max = 95;
        this.height = $(this.container).outerHeight();
        this.scale = 0.95;
        this.position = {top: null, left: null};
    }

    move() {
        $(this.svg).attr('y', this.scalling() + '%');
    }

    scalling() { return this.percent * this.scale; }

    calcPosition() { return (this.scalling() / 100) * this.height; }

    scrollLimits() {
        this.percent = (this.percent > 100) ? 100 : this.percent;
        this.percent = (this.percent < 0) ? 0 : this.percent;
    }
}


function initScrollbar(e) {
    var globScroller = new Scroller(
        $(e.data.active).children('.innerPage').children('.explanation'),
        new Scrollbar($(e.data.active).children('.innerPage').children('.scrollbar'), $(e.data.active).children('.innerPage').children('.scrollbar').children('.move')),
        Boolean($(e.data.active).data('active'))
    );

    globScroller.init();
}

$(window).on('load', {active : $('#explanationList .page[data-active="1"]')}, function (e) { initScrollbar(e); });
// $(window).on('resize', {active : $('#explanationList .page[data-active="1"]')}, function (e) {
//     // globScroller = null;
//     initScrollbar(e);
// });

$('#pageMenu a').each(function () {
   $(this).on('click', {active : $($(this).attr('href'))}, function (e) {
       // globScroller = null;
       initScrollbar(e);

   });
});