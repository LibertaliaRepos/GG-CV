var orbitContainer = new OrbitContainer();
$(function () { new ZoomContainer(); });

$(window).on('load', function () {
   initOrbit($('#pageMenu li[data-active="true"] a').attr('href'), orbitContainer);
});
$(window).on('resize', function () {  initOrbit($('#pageMenu li[data-active="true"] a').attr('href'), orbitContainer);  });
$('#pageMenu a').each(function () { $(this).on('click', function (e) { initOrbit($(e.currentTarget).attr('href'), orbitContainer); }); });

