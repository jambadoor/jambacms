/*	Author: Jason Benford
 *	Description: javascript for the ci_template admin side
 */

$(function () {

	//our tab controllers
	$('#home-tab')
		.click(function () {
			//change the tabs
			$('#dashboard-tabs > .item').removeClass('active');
			$(this).addClass('active');

			$('#tab-content').load('/admin/home', function() {

			});

		});
	
	//ajax controllers
	$(document.body).on('click', '#add-user-button', function(){loadAddUserForm(event, this)});

	function loadAddUserForm(event, d) {
		$('#tab-content').load('/admin/users/add', function() {
			$('div.ui.selection.dropdown').dropdown();
			$('#add-user-form').submit(function(event) {
				event.preventDefault();
				var formData = new FormData($(this)[0]);
				var action_url = $(this).attr("action");
				$.ajax({
					url : action_url,
					type : 'POST',
					data : formData,
					success : function() {
						$('#tab-content').load('admin/users', function() {
							$('#message').load('admin/users/add_success', function() {
								$('#message').show();
							});
						});
					},
					cache: false,
					contentType: false,
					processData:false
				});
				$('#tab-content').load('admin/users/uploading', function() {
					//
					});
				});
			});
	}

	
	$('#users-tab')
		.click(function () {
			//change the tabs
			$('#dashboard-tabs > .item').removeClass('active');
			$(this).addClass('active');

			//load up the tab
			$('#tab-content').load('/admin/users/list');

			});

	$('#blog-tab')
		.click(function () {
			//change the tabs
			$('#dashboard-tabs > .item').removeClass('active');
			$(this).addClass('active');

			$('#tab-content').load('/admin/blog', function() {

			});
		});

	$('#forum-tab')
		.click(function () {
			//change the tabs
			$('#dashboard-tabs > .item').removeClass('active');
			$(this).addClass('active');

			$('#tab-content').load('/admin/forum', function() {

			});
		});

	$('#metrics-tab')
		.click(function () {
			//change the tabs
			$('#dashboard-tabs > .item').removeClass('active');
			$(this).addClass('active');

			$('#tab-content').load('/admin/metrics', function() {

			});
		});

	$('#ads-tab')
		.click(function () {
			//change the tabs
			$('#dashboard-tabs > .item').removeClass('active');
			$(this).addClass('active');

			$('#tab-content').load('/admin/ads', function() {

			});
		});

});
