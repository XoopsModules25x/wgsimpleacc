<{if $formFilter}>
    <div id="formFilter" class="row" style="display:<{$displayfilter}>">
        <div class="col-sm-12">
            <{$formFilter}>
        </div>
    </div>
<{/if}>
<{if $displayBalOutput}>
    <{if $balancesCount > 0}>
        <h3><{$smarty.const._MA_WGSIMPLEACC_BALANCES_LIST}></h3>
        <div class='table-responsive'>
            <table class='table table-<{$table_type}>'>
                <thead>
                <tr class='head'>
                    <td class="left"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_ASID}></th>
                    <td class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_FROM}></th>
                    <td class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_TO}></th>
                    <td class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_CURID}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTSTART}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTEND}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_DIFFERENCE}></th>
                    <td class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                    <td class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                </tr>
                </thead>
                <tbody>
                    <{foreach item=balance from=$balances}>
                        <tr>
                            <td class="left"><span style="margin-right:10px;padding:5px 10px;width:20px;background-color:<{$balance.color}>"></span><{$balance.asset}></td>
                            <td class="center"><{$balance.from}></td>
                            <td class="center"><{$balance.to}></td>
                            <td class="center"><{$balance.curid}></td>
                            <td class="right"><{$balance.amountstart}></td>
                            <td class="right"><{$balance.amountend}></td>
                            <td class="right"><{$balance.difference}></td>
                            <td class="center"><{$balance.datecreated}></td>
                            <td class="center"><{$balance.submitter}></td>
                        </tr>
                    <{/foreach}>
                    <tr class="wgsa-output-sum">
                        <td colspan="4" class="col-xs-6 col-sm-4 left"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_SUMS}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$balancesAmountIn}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$balancesAmountOut}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$balancesTotal}></td>
                        <td colspan="2" class="col-xs-6 col-sm-2 right"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <{/if}>
    <{if $accountsCount > 0}>
        <h3><{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS_LIST}></h3>
        <div class='table-responsive'>
            <table class='table table-<{$table_type}>'>
                <thead>
                <tr class='head'>
                    <td class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_NAME}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_TOTAL}></th>
                </tr>
                </thead>
                <tbody>
                <{foreach item=account from=$accounts}>
                    <tr>
                        <td class="col-xs-6 col-sm-4 left"><span style="margin-right:10px;padding:5px 10px;width:20px;background-color:<{$account.color}>"></span><{$account.name}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$account.amountin}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$account.amountout}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$account.total}></td>
                    </tr>
                    <{/foreach}>
                    <tr class="wgsa-output-sum">
                        <td class="col-xs-6 col-sm-4 left"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_SUMS}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$accountsAmountIn}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$accountsAmountOut}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$accountsTotal}></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <{/if}>
    <{if $allocationsCount > 0}>
        <h3><{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS_LIST}></h3>
        <div class='table-responsive'>
            <table class='table table-<{$table_type}>'>
                <thead>
                <tr class='head'>
                    <td class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_NAME}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT}></th>
                    <td class="right"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_TOTAL}></th>
                </tr>
                </thead>
                <tbody>
                <{foreach item=allocation from=$allocations}>
                    <tr>
                        <td class="col-xs-6 col-sm-4 left"><{$allocation.name}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$allocation.amountin}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$allocation.amountout}></td>
                        <td class="col-xs-6 col-sm-2 right"><{$allocation.total}></td>
                    </tr>
                    <{/foreach}>
                <tr class="wgsa-output-sum">
                    <td class="col-xs-6 col-sm-4 left"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_SUMS}></td>
                    <td class="col-xs-6 col-sm-2 right"><{$allocationsAmountIn}></td>
                    <td class="col-xs-6 col-sm-2 right"><{$allocationsAmountOut}></td>
                    <td class="col-xs-6 col-sm-2 right"><{$allocationsTotal}></td>
                </tr>
                </tbody>
            </table>
        </div>
    <{/if}>
<{/if}>
                