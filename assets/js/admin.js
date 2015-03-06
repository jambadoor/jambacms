/*	Author: Jason Benford
 *	Description: javascript for the ci_template admin side
 */

$(function () {
	//initialize the dropdowns
	$('div.ui.selection.dropdown').dropdown();

	//make tinyeditor update textarea before submitting
	//we need to make this more elegant
	$('#edit-content-form').submit(function(event) {
		tinyeditor.post();
	});
	$('#add-content-form').submit(function(event) {
		tinyeditor.post();
	});
	$('#edit-blog-entry-form').submit(function(event) {
		tinyeditor.post();
	});
	$('#add-blog-entry-form').submit(function(event) {
		tinyeditor.post();
	});

});
