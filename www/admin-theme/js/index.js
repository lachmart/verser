function resizeMethodListContainer() {
	var viewportH = $(window).height();
	var viewportW = $(window).width();

	diffH = viewportH - 585;
	diffHinner = diffH + 380;
	diffH += 440;
	$('.method-list-wrapper').css('max-height', diffH + 'px');
	$('.method-list-inner').css('max-height', diffHinner + 'px');

	diffW = viewportW * 0.27;
	$('.method-list-wrapper').css('max-width', diffW + 'px');
	console.log('max-width: ' + diffW);
}

jQuery(document).ready(function () {
	resizeMethodListContainer();
});
jQuery(window).resize(function() {
	resizeMethodListContainer();
});