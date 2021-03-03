
<div id="canvas-holder" class="canvas-assets" style="width:100%">
	<canvas id="chart-assets-pie"></canvas>
</div>

<script>
	$(function () {
		var ctxPie1 = document.getElementById("chart-assets-pie").getContext('2d');
		var dataPie1 = {
			datasets: [{
				data: [<{$assets_data}>],
					backgroundColor: [
					<{foreach item=pcolor from=$assets_pcolors}>
						window.chartColors.<{$pcolor}>,
						<{/foreach}>
							],
					label: 'Dataset Pie'
			}],
			labels: [<{$assets_labels}>]
		};
		var myDoughnutChart = new Chart(ctxPie1, {
			type: 'doughnut',
			data: dataPie1,
			options: {
				responsive: true,
				maintainAspectRatio: true,
				legend: {
					display: false,
					position: 'bottom',
					labels: {boxWidth: 12}
				}
			}
		});
	});
</script>