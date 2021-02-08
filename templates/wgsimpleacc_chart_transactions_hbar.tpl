
<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>

<h3><{$header_transactions}></h3>

<{if $formTraFilter|default:''}>
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

<{if $transactions_total|default:0}>
    <div class="wgsa-index-tratotal">
        <table>
            <tbody>
                <tr>
                    <td><span id="incomes1"></span><span id="incomes2"></span>&nbsp</td>
                    <td><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_INCOMES}>:</td>
                    <td class="wgsa-index-tratotal-amount"><{$transactions_total_in}></td>
                </tr>
                <tr>
                    <td><span id="expenses1"></span><span id="expenses2"></span>&nbsp</td>
                    <td><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_EXPENSES}>:</td>
                    <td class="wgsa-index-tratotal-amount"><{$transactions_total_out}></td>
                </tr>
                <tr class="wgsa-index-tratotal-sum">
                    <td></td>
                    <td><{$smarty.const._MA_WGSIMPLEACC_CHART_BALANCE}>:</td>
                    <td class="wgsa-index-tratotal-amount"><{$transactions_total}></td>
                </tr>
            </tbody>
        </table>
    </div>
<{/if}>

<script>
    document.getElementById('incomes1').style.backgroundColor = window.chartColors.green;
    document.getElementById('incomes1').style.border = '1px solid ' + window.chartColors.darkgreen;
    document.getElementById('incomes2').style.backgroundColor = window.chartColors.lightgreen;
    document.getElementById('incomes2').style.border = '1px solid ' + window.chartColors.green;
    document.getElementById('expenses1').style.backgroundColor = window.chartColors.red;
    document.getElementById('expenses1').style.border = '1px solid ' + window.chartColors.darkred;
    document.getElementById('expenses2').style.backgroundColor = window.chartColors.lightred;
    document.getElementById('expenses2').style.border = '1px solid ' + window.chartColors.red;

    var horizontalBarChartData = {
        labels: [<{$transactions_labels}>],
        datasets: [{
            label: '<{$label_datain1}>',
            backgroundColor: window.chartColors.green,
            borderColor: window.chartColors.darkgreen,
            borderWidth: 1,
            stack: 0,
            data: [<{$transactions_datain1}>]
        },
        <{if $transactions_datain2|default:''}>
        {
            label: '<{$label_datain2}>',
            backgroundColor: window.chartColors.lightgreen,
            borderColor: window.chartColors.green,
            borderWidth: 2,
            stack: 0,
            data: [<{$transactions_datain2}>]
        },
        <{/if}>
        {
            label: '<{$label_dataout1}>',
            backgroundColor: window.chartColors.red,
            borderColor: window.chartColors.darkred,
            borderWidth: 1,
            stack: 1,
            data: [<{$transactions_dataout1}>]
        },
        <{if $transactions_datain2|default:''}>
            {
            label: '<{$label_dataout2|default:''}>',
            backgroundColor: window.chartColors.lightred,
            borderColor: window.chartColors.red,
            borderWidth: 2,
            stack: 1,
            data: [<{$transactions_dataout2}>]
        }
        <{/if}>
        ]

    };
    var ctxHbar1 = document.getElementById('chart-transactions').getContext('2d');
    window.myHorizontalBar = new Chart(ctxHbar1, {
        type: 'horizontalBar',
        data: horizontalBarChartData,
        options: {
            responsive: true,
            legend: {
                position: 'bottom',
                labels: {boxWidth: 12}
            }
        }
    });
</script>
