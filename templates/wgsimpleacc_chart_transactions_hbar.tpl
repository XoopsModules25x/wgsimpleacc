
<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>

<h3><{$header_transactions}></h3>

<{if $formTraFilter}>
    <{$formTraFilter}>
 <{/if}>
<{foreach item=alloc from=$tra_allocs_list}>
	<a class='btn btn-default <{if $alloc.allSubs == 1}>disabled<{/if}>' href='<{$alloc.href}>' title='<{$alloc.all_name}>'>
		<{$alloc.all_name}>
		<{if $alloc.allSubs > 1}>
        <i class="fa fa-angle-double-down"></i>
		<{/if}>
	</a>
<{/foreach}>

<div id="canvas-holder" class="canvas-assets" style="width:100%">
	<canvas id="chart-transactions"></canvas>
</div>

<script>
    var data = {
      labels: [<{$transactions_labels}>],
      datasets: [{
        "label": "<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES}>",
        "yAxisID": "A",
        "backgroundColor": window.chartColors.red,
        "borderColor": window.chartColors.darkred,
        "borderWidth": 1,
        "maxBarThickness": 50,
        "data": [<{$transactions_dataout}>]
      }, {
        "label": "<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_INCOMES}>",
        "yAxisID": "A",
        "backgroundColor": window.chartColors.green,
        "borderColor": window.chartColors.darkgreen,
        "borderWidth": 1,
        "maxBarThickness": 50,
        "data": [<{$transactions_datain}>]
      }]
    };

    var options = {
      scales: {
        yAxes: [{
          id: 'A',
          position: 'left'
        }]
      }
    };

    var ctx = document.getElementById("chart-transactions");
    new Chart(ctx, {
      type: "horizontalBar",
      data: data,
      options: options
    });

</script>