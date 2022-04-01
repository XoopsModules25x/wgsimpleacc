
<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>

<h3><{$header_accounts_bar}></h3>

<{if $formTraFilter|default:''}>
    <{$formTraFilter}>
<{/if}>
<{foreach item=account from=$tra_accounts_list}>
    <a class='btn btn-default <{if $account.accSubs == 1}>disabled<{/if}>' href='<{$account.href}>' title='<{$account.acc_name}>'>
        <{$account.acc_name}>
        <{if $account.accSubs > 1}>
            <i class="fa fa-angle-double-down"></i>
        <{/if}>
    </a>
<{/foreach}>

<div id="canvas-holder" class="canvas-assets" style="width:100%">
    <canvas id="chart-transactions"></canvas>
</div>

<script>
    var horizontalBarChartData = {
        labels: [<{$transactions_labels}>],
        datasets: [{
            label: '<{$label_datain1}>',
            backgroundColor: window.chartColors.green,
            borderColor: window.chartColors.darkgreen,
            borderWidth: 1,
            stack: 0,
            maxBarThickness: 60,
            data: [<{$transactions_datain1}>]
        },
        <{if $transactions_datain2|default:''}>
        {
            label: '<{$label_datain2}>',
            backgroundColor: window.chartColors.lightgreen,
            borderColor: window.chartColors.green,
            borderWidth: 2,
            stack: 0,
            maxBarThickness: 60,
            data: [<{$transactions_datain2}>]
        },
        <{/if}>
        {
            label: '<{$label_dataout1}>',
            backgroundColor: window.chartColors.red,
            borderColor: window.chartColors.darkred,
            borderWidth: 1,
            stack: 1,
            maxBarThickness: 60,
            data: [<{$transactions_dataout1}>]
        },
        <{if $transactions_datain2|default:''}>
            {
            label: '<{$label_dataout2|default:''}>',
            backgroundColor: window.chartColors.lightred,
            borderColor: window.chartColors.red,
            borderWidth: 2,
            stack: 1,
            maxBarThickness: 60,
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
