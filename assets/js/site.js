$(document).ready(function () {
	var viewportHeight = $(window).height();
	var menuHeight = $('#menu').height();
	$('#masthead').height(viewportHeight - menuHeight);
});
