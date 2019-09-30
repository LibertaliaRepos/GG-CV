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

        var orbit = new Foundation.Orbit($(this.orbit), OrbitContainer.Orbit_Options());

        var zoom = this;

        setTimeout(function(){
            zoom.resize();
        }, 100);

        this.zoomInListen();

        $(this.container).find('.orbit').on('mouseenter', {zoom : this}, function (e) {
            console.log('enter');
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