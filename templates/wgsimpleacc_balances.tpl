<{if $balancesList}>
    <{if $balancesCount > 0}>
        <h3><{$smarty.const._MA_WGSIMPLEACC_BALANCES_LIST}></h3>
        <div class='table-responsive'>
            <table class='table table-<{$table_type}>'>
                <thead>
                    <tr class='head'>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_FROM}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_TO}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_ASID}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_CURID}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTSTART}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTEND}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                    </tr>
                </thead>
                <tbody>
                    <{foreach item=balance from=$balances}>
                        <tr>
                            <td><{$balance.from}></td>
                            <td><{$balance.to}></td>
                            <td><{$balance.asset}></td>
                            <td><{$balance.curid}></td>
                            <td><{$balance.amountstart}></td>
                            <td><{$balance.amountend}></td>
                            <td><{$balance.datecreated}></td>
                            <td><{$balance.submitter}></td>
                        </tr>
                    <{/foreach}>
                </tbody>
            </table>
        </div>
    <{else}>
        <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_BALANCES}>
    <{/if}>
<{/if}>
<{if $balancesCalc}>
    <h3><{$calc_info}></h3>
    <table class='table table-<{$table_type}>'>
        <thead>
            <tr class='head'>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_NAME}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_DATE}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_VALUESTART}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_VALUEEND}></th>
                <th>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <{foreach item=balance from=$balances_calc}>
                <tr>
                    <td><{$balance.name}></td>
                    <td><{if $balance.date > 0}><{$balance.date}><{/if}></td>
                    <td><{$balance.amount_start}></td>
                    <td><{$balance.amount_end}></td>
                    <td class="center">
                        <a class='btn btn-success right' href='transactions.php?op=list&amp;asId=<{$balance.id}><{$trafilter}>' target='_blank' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
                    </td>
                </tr>
            <{/foreach}>
        </tbody>
        <tfoot>
            <tr>
                <td class="center" colspan="5">
                    <a class='btn btn-primary' href='balances.php?op=save<{$balfilter}>' title='<{$smarty.const._MA_WGSIMPLEACC_BALANCE_CREATE_FINAL}>'><{$smarty.const._MA_WGSIMPLEACC_BALANCE_CREATE_FINAL}></a>
                </td>
            </tr>
        </tfoot>
    </table>
<{/if}>
