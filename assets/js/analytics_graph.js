$(function () {

	$.getJSON("/admin/analytics/get_graph_data", 
		function (r) {
			var ctx = $('#test_graph').get(0).getContext('2d');
			var labels = [];
			var data = [];
			var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

			for (i = 0; i < r.length; i++) {
				labels.push(months[(Number(r[i].month) + 1) % 12] + ' ' + r[i].year);
				data.push(Number(r[i].total));
			}
			console.log(data);


			var chartData = {
				labels: labels,
				datasets: [
					{
						label: "Test Data",
						data: data
					}
				]};


			var lineChart = new Chart(ctx).Line(chartData);

			console.log(chartData);
		}
	);




	

});
