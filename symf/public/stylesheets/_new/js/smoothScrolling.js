function DEBUG(value, THROW = true) {
    console.log(value);
    if (THROW)
        throw {};
}

class Slide {
    constructor(link, explanation) {
        this.link = link;
        this.explanation = explanation;
    }
}

class Slider {
    constructor() {
        this.sliders = [];
        this.current = 1;
    }

    addSlider(slider) { this.sliders.push(slider); }

    init() {
        this.showActive();
        this.listen();
    }

    showActive() {
        this.sliders.forEach(function (slide) {
            if(!$(slide.explanation).data('active')) {
                slide.explanation.css('display', 'none');
                slide.explanation.attr('aria-hidden', 'true');
            } else {
                $(slide.explanation).attr('aria-hidden', 'false');
            }
        });
    }

    clearAll() {
        this.sliders.forEach(function (slide) {
            slide.explanation.css('display', 'none');
            slide.explanation.attr('aria-hidden', 'true');
        })
    }

    slide(explanation, direction) {
        $(explanation).effect('slide', {direction: direction});
    }

    listen() {
        this.sliders.forEach(function (slide) {
            $(slide.link).on('click', {sliders : this}, function (e) {

                var slideDirection = (parseInt(e.currentTarget.dataset.order) > e.data.sliders.current) ? 'right' : 'left';

                e.data.sliders.clearAll();
                e.data.sliders.slide($($(e.currentTarget).attr('href')), slideDirection);
                e.data.sliders.current = parseInt(e.currentTarget.dataset.order);
            });
        }, this);
    }
}

var sliderContainer = new Slider();

$('#pageMenu a').each(function () {
    sliderContainer.addSlider(new Slide($(this), $($(this).attr('href'))));


});

sliderContainer.init();