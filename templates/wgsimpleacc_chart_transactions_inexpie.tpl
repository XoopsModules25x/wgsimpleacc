
<canvas id="chart-transactions-inexpie" style="position: relative; height:100px"></canvas>

<script>
	$(function () {
		var ctxPieInEx = document.getElementById("chart-transactions-inexpie").getContext('2d');
		var dataPieInEx = {
			datasets: [{
				data: [<{$transactions_total_in_val}>, <{$transactions_total_out_val}>],
					backgroundColor: [
						window.chartColors.green,
						window.chartColors.red
					],
					label: 'Dataset Transactions Pie'
			}],
			labels: ['<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_INCOMES}>', '<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES}>']
		};
		var myDoughnutChart = new Chart(ctxPieInEx, {
			type: 'doughnut',
			data: dataPieInEx,
			options: {
				responsive: false,
				maintainAspectRatio: false,
				legend: {
					display: false
				}
			}
		});
	});
</script>