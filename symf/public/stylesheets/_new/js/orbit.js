function initOrbit(ident, container) {
    var explanationHeight; var bulletsHeight; var orbitHeight;
    var currentPage = $(ident);

    container.retrieveOrbit(ident);

    explanationHeight = parseInt($(currentPage).find('.explanation').outerHeight(false));
    bulletsHeight = parseInt($(currentPage).find('.orbit-bullets').outerHeight(true));
    orbitHeight = explanationHeight - bulletsHeight - 10;

    $(currentPage).find('.orbit-container').css('height', orbitHeight + 'px');
    $(currentPage).find('.orbit-slide').each(function () {
       $(this).css('height', '100%');
       $(this).find('.orbit-figure').css('height', 'inherit');
    });
}

class OrbitContainer {
    constructor() {
        this.identContainer = [];
        this.orbitContainer = [];
        this.opts = {
            animInFromLeft  : 'fade-in',
            animInFromRight : 'fade-in',
            animOutToLeft   : 'fade-out',
            animOutToRight  : 'fade-out',
            autoPlay        :  false
        };
        this.init();
    }

    init() {
        var container = this.identContainer;

        $('#explanationList .page').each(function (index) {
            container.push('#' + $($('#explanationList .page')[index]).attr('id'));
        });
    }

    retrieveOrbit(ident) {
        var index = (this.identContainer.indexOf(ident) >= 0)
                    ? this.identContainer.indexOf(ident)
                    : (this.identContainer.push(ident)) - 1;

        if (index > (this.orbitContainer.length - 1) || this.orbitContainer[index] == null)
            this.orbitContainer[index] = this.createOrbit(ident);

        return this.orbitContainer[index];
    }

    createOrbit(ident) {
        return new Foundation.Orbit($(ident).find('.illustration'), this.opts);
    }
}

var container = new OrbitContainer();

$(window).on('load', function () {  initOrbit($('#pageMenu li[data-active="true"] a').attr('href'), container);  });
$('#pageMenu a').each(function () { $(this).on('click', function (e) { initOrbit($(e.currentTarget).attr('href'), container); }); });
