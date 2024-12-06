<{if $transactions_total|default:0}>
    <div class="wgsa-index-tratotal">
        <table>
            <tbody>
                <tr>
                    <td><span id="incomes1"></span><span id="incomes2"></span>&nbsp</td>
                    <td><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_INCOMES}>:</td>
                    <td class="wgsa-index-tratotal-amount"><{$transactions_total_in}></td>
                    <{if $indexTraInExPie|default:0 > 0}>
                        <td rowspan="3" class="center"><{include file='db:wgsimpleacc_chart_transactions_inexpie.tpl'}></td>
                    <{/if}>
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
</script>
