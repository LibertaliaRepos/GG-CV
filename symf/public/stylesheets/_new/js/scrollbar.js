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
    }

    showScrollbar() {
        if (this.requestRealHeight() > this.requestExplanationHeight()) {
            $(this.scrollbar.container).css('display', 'block');
        } else {
            $(this.scrollbar.container).css('display', 'none');

            return;
        }

        this.toScroll = this.requestRealHeight() - this.requestExplanationHeight();
        $(this.explanation).children().each(function () {
            $(this).css('transform', '');
        });

        this.listen();
    }

    scrolling(deltaY) {

        if (deltaY > 0)
            this.scrollUp();
        else
            this.scrollDown();

        this.moveScrollbar();
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
    }

    requestRealHeight() {
        var height = 0;

        $(this.explanation).children().each(function () {
            // DEBUG($(this).outerHeight(true), false);
            height += $(this).outerHeight(true);
            // DEBUG(height, false);
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

var indexes = [];
var scrollerContainer = [];

function checkIndexes(elem) {

    if (indexes.includes($(elem).attr('id'))) {
        return indexes.indexOf($(elem).attr('id'));
    } else {
        var length = indexes.push($(elem).attr('id'));
        return length - 1;
    }
}

function initScrollbar(e) {
    var index = checkIndexes(e.data.active);

    if (scrollerContainer.indexOf(index) < 0) {

        scrollerContainer[index] = new Scroller(
            $(e.data.active).children('.innerPage').children('.explanation'),
            new Scrollbar($(e.data.active).children('.innerPage').children('.scrollbar'), $(e.data.active).children('.innerPage').children('.scrollbar').children('.move')),
            Boolean($(e.data.active).data('active'))
        );
    }

    DEBUG(indexes,false);
    DEBUG(scrollerContainer, false);

    scrollerContainer[index].init();
}

$(window).on('load', {active : $('#explanationList .page[data-active="1"]')}, function (e) { initScrollbar(e); });
$(window).on('resize', {active : $('#explanationList .page[data-active="1"]')}, function (e) { initScrollbar(e); });

$('#pageMenu a').each(function () {
   $(this).on('click', {active : $($(this).attr('href'))}, function (e) {
       initScrollbar(e);

   });
});