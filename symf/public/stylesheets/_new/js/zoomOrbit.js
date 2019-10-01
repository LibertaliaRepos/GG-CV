class Zoom {
    constructor(ident) {
        this.reliatifOrbit = $('#' + ident);
        this.orbit = $('#' + ident).clone().attr('id', uniqueId('orbit'));
        this.container = $('#orbitZoomed');

        this.listen();
    }

    zoomIn() {
        this.cleanContainer();

        $(this.container).append(this.orbit);
        $(this.container).css('display', 'flex');
        $(this.container).attr('aria-hidden', 'false');

        this.sortOrbit();

        this.zoomInListen();

        var orbit = new Foundation.Orbit($(this.orbit), OrbitContainer.Orbit_Options());

        var zoom = this;

        setTimeout(function(){
            zoom.resize();
        }, 100);

        $(this.container).find('.orbit').on('mouseenter', {zoom : this}, function (e) {
            $(e.data.zoom.container).off('click');
        });

        $(this.container).find('.orbit').on('mouseleave', {zoom : this}, function (e) {
           $(e.data.zoom.zoomInListen());
        });


    }

    zoomOut() {
        $(this.container).css('display', '');
        $(this.container).attr('aria-hidden', 'true');
        this.cleanContainer();
    }

    cleanContainer() {
        $(this.container).empty();
    }

    resize() {
        var heights = {
            window : $(window).outerHeight(),
            bullets : $(this.orbit).find('.orbit-bullets').outerHeight(true),
            marge : 100
        };

        var controlWidth = $(this.orbit).find('.orbit-controls button:first').outerWidth(true);

        var cssHeight = parseInt(heights.window - heights.bullets - heights.marge);
        var padding = parseInt((heights.window - cssHeight) / 2);
        var figurePadding = $(this.orbit).find('.orbit-figure').css('padding', '0 ' + controlWidth + 'px');

        $(this.orbit).find('.orbit-container').css('height', cssHeight + 'px');
        $(this.orbit).css('margin-top', padding + 'px');
        $(this.orbit).css('margin-bottom', padding + 'px');
    }

    sortOrbit() {
        var activeIndex;
        var reindexer;
        var realCounter;
        var sorted = [];
        var result = [];

        $(this.reliatifOrbit).find('.orbit-slide').each(function () {
            var active = ($(this).css('display') != 'none') ? true : false;

            sorted.push(active);
        });

        activeIndex = sorted.indexOf(true);
        reindexer = (activeIndex == 1 && sorted.length == 3) ? activeIndex + 1 : activeIndex;
        realCounter = 0;

        DEBUG(sorted, false);

        for (var i = -activeIndex; i <= sorted.length - (activeIndex + 1); ++i) {
            if (sorted[realCounter])
                i = 0;

            sorted[realCounter] = (i < 0)
                ? sorted.length + i
                : i
            ;

            realCounter++;
        }

        sorted.forEach(function(value, index) {
            result[index] = $($(this.reliatifOrbit).find('.orbit-slide')[value]).clone();
            DEBUG(result[index], false);
        }, this);

        $(this.orbit).find('.orbit-container').empty();

        result.forEach(function (value, index) {
            $(value).attr('data-slide', '');
            $(this.orbit).find('.orbit-container').append(result[sorted.indexOf(index)]);
        }, this);
    }

    listen() {
        $(this.reliatifOrbit.find('.orbit-container')).on('click', {zoom : this}, function (e) {
            e.data.zoom.zoomIn();
        });
    }

    zoomInListen() {
        $(this.container).on('click', {zoom : this}, function (e) { e.data.zoom.zoomOut(); });
        $(window).on('resize', {zoom : this}, function (e) {
           e.data.zoom.resize();
        });

        $(window).on('error', function(e) { e.preventDefault(); });
    }
}

class ZoomContainer {
    constructor() {
        this.identContainer = [];
        this.zoomContainer = [];

        this.init();
    }

    init() {
        var obj = this;


        $('.illustration.orbit').each(function () {
            var ident = $(this).attr('id');

            obj.identContainer.push(ident);
            obj.retrieveZoom(ident);
        });
    }

    retrieveZoom(ident) {
        var index = (this.identContainer.indexOf(ident) >= 0)
            ? this.identContainer.indexOf(ident)
            : (this.identContainer.push(ident)) - 1;

        if (index > (this.zoomContainer.length - 1) || this.zoomContainer[index] == null)
            this.zoomContainer[index] = ZoomContainer.createZoom(ident);

        return this.zoomContainer[index];
    }

    static createZoom(ident) {
        return new Zoom(ident);
    }

    addZoom(ident, zoom) {
        var index = (this.identContainer.push(ident)) - 1;

        this.zoomContainer[index] = zoom;
    }
}