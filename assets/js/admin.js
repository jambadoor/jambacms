/*	Author: Jason Benford
 *	Description: javascript for the ci_template admin side
 */

$(function () {
	//initialize the dropdowns
	$('div.ui.selection.dropdown').dropdown();

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

	//get confirmation of user deletes
	$('.delete.button').click(
		function () {
			var del = window.confirm("Are you sure you want to delete this user?");
			if (!del) {
				this.href='#';
			}
		}
	);


});
