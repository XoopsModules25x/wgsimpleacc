
<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>

<h3><{$header_balances_line}></h3>
<div id="canvas-holder2" class="canvas-balances" style="width:100%">
	<canvas id="chart-balances-line"></canvas>
</div>

<script>
	var configLine = {
		type: 'line',
		data: {
			labels: [<{$line_labels}>],
			datasets: [
                <{foreach item=balance from=$line_balances}>
					{
						label: '<{$balance.name}>',
						backgroundColor: window.chartColors.<{$balance.color}>,
						borderColor: window.chartColors.<{$balance.color}>,
						data: [<{$balance.data}>],
						fill: false,
                       	pointRadius: 10,
						pointHoverRadius:10
					},
            	<{/foreach}>
				],
		},
		options: {
			responsive: true,
			title: {
				display: false,
				text: 'Chart.js Line Chart'
			},
			tooltips: {
				mode: 'index',
				intersect: false,
			},
			hover: {
				mode: 'nearest',
				intersect: true
			},
			scales: {
				xAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: '<{$smarty.const._MA_WGSIMPLEACC_CHART_PERIOD}>'
					}
				}],
				yAxes: [{
					display: true,
					scaleLabel: {
						display: true,
						labelString: '<{$smarty.const._MA_WGSIMPLEACC_CHART_AMOUNT}>'
					}
				}]
			}
		}
	};


    var ctx_line = document.getElementById('chart-balances-line').getContext('2d');
    window.myLine = new Chart(ctx_line, configLine);

</script>