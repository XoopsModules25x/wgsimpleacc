
<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>

<h3><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_OVERVIEW}></h3>

<{if $formFilter|default:''}>
    <{$formFilter}>
 <{/if}>
<{if $tra_allocs_level > 2}>
	<a class='btn btn-default ' href='index.php?op=list&amp;all_pid=0&amp;level=1<{$filter}>' title='<{$alloc.all_name}>'>...
	</a>
<{/if}>
<{foreach item=alloc from=$tra_allocs_list}>
	<a class='btn btn-default <{if $alloc.allSubs == 1}>disabled<{/if}>' href='index.php?op=list&amp;all_pid=<{$alloc.all_id}>&amp;level=<{$tra_allocs_level}><{$filter}>' title='<{$alloc.all_name}>'>
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
        "data": [<{$transactions_dataout}>]
      }, {
        "label": "<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_INCOMES}>",
        "yAxisID": "A",
        "backgroundColor": window.chartColors.green,
        "borderColor": window.chartColors.darkgreen,
        "borderWidth": 1,
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