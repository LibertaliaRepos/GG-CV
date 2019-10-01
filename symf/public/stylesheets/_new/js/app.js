function uniqueId(prefix) { return prefix + '_' + Math.random().toString(36).substr(2, 9); }


$(document).foundation();

function readURL() {
    var anchor = window.location.hash;

    if(anchor.length <= 0)
        return;

    $('#pageMenu li[data-active]').each(function () {
        var href = $(this).children('a').attr('href');

        var page = ($(this).children('a').attr('href') == anchor)
            ? page = {link: 'true', explanation: '1'}
            : page = {link: 'false', explanation: '0'};

        $(this).attr('data-active', page.link);
        $(href).attr('data-active', page.explanation)
    });
}

Array.array_flip = function ( trans )  {
    var key, tmp_ar = {};

    for ( key in trans )  {
        if ( trans.hasOwnProperty( key ) ) {
            tmp_ar[trans[key]] = key;
        }
    }

    return Object.keys(tmp_ar).map(function(key) {
            return tmp_ar[key];
        });
};