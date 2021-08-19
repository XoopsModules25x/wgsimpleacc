
<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>

<h3><{$header_accounts_line}></h3>
<p>
	<{if $level|default:0 == 1}>
		<a class="btn btn-default disabled" href="statistics.php?op=accounts&amp;level=1" title="<{$smarty.const._MA_WGSIMPLEACC_SHOW_TOP}>"><{$smarty.const._MA_WGSIMPLEACC_SHOW_TOP}></a>
		<a class="btn btn-default"href="statistics.php?op=accounts&amp;level=2" title="<{$smarty.const._MA_WGSIMPLEACC_SHOW_ALL}>"><{$smarty.const._MA_WGSIMPLEACC_SHOW_ALL}></a>
	<{else}>
		<a class="btn btn-default" href="statistics.php?op=accounts&amp;level=1" title="<{$smarty.const._MA_WGSIMPLEACC_SHOW_TOP}>"><{$smarty.const._MA_WGSIMPLEACC_SHOW_TOP}></a>
		<a class="btn btn-default disabled" href="statistics.php?op=accounts&amp;level=2" title="<{$smarty.const._MA_WGSIMPLEACC_SHOW_ALL}>"><{$smarty.const._MA_WGSIMPLEACC_SHOW_ALL}></a>
	<{/if}>
</p>
<div id="canvas-holder2" class="canvas-accounts" style="width:100%">
	<canvas id="chart-accounts-line"></canvas>
</div>

<script>
	var configLine = {
		type: 'line',
		data: {
			labels: [<{$line_labels}>],
			datasets: [
                <{foreach item=account from=$line_accounts}>
					{
						label: '<{$account.name}>',
						backgroundColor: window.chartColors.<{$account.color}>,
						borderColor: window.chartColors.<{$account.color}>,
						data: [<{$account.data}>],
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


    var ctx_line = document.getElementById('chart-accounts-line').getContext('2d');
    window.myLine = new Chart(ctx_line, configLine);

</script>