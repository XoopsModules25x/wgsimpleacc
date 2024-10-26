<{if $warnings|default:''}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_BALANCES_WARNING}></h3>
    <div class="alert alert-danger">
    <{foreach item=warning from=$warnings}>
        <p><{$warning}></p>
    <{/foreach}>
    </div>
<{/if}>

<{if $balancesList|default:''}>
    <{if $balancesCount|default:0 > 0}>
        <h3><{$smarty.const._MA_WGSIMPLEACC_BALANCES_LIST}></h3>
        <div class='table-responsive'>
            <table class='table table-<{$table_type|default:''}>'>
                <thead>
                    <tr class='head'>
                        <th>&nbsp;</th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_FROM}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_TO}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTSTART}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTEND}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <{foreach item=balance from=$balances}>
                        <tr>
                            <td>
                                <{if $balance.type|default:0 == $balTypeTemporary}>
                                    <img src="<{$wgsimpleacc_icon_url_32}>/temporary.png" alt="<{$smarty.const._MA_WGSIMPLEACC_BALANCE_TYPE_TEMPORARY}>" title="<{$smarty.const._MA_WGSIMPLEACC_BALANCE_TYPE_TEMPORARY}>">
                                <{elseif $balance.type|default:0 == $balTypeFinal}>
                                    <img src="<{$wgsimpleacc_icon_url_32}>/final.png" alt="<{$smarty.const._MA_WGSIMPLEACC_BALANCE_TYPE_FINAL}>" title="<{$smarty.const._MA_WGSIMPLEACC_BALANCE_TYPE_FINAL}>">
                                <{/if}>
                            </td>
                            <td><{$balance.from}></td>
                            <td><{$balance.to|default:''}></td>
                            <td><{$balance.amountstart}></td>
                            <td><{$balance.amountend}></td>
                            <td><{$balance.datecreated}></td>
                            <td><{$balance.submitter}></td>
                            <td class="center">
                                <a class='btn btn-success right' href='balances.php?op=details&amp;balanceFrom=<{$balance.bal_from}>&amp;balanceTo=<{$balance.bal_to}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
                                <a class='btn btn-primary right' href='outputs.php?op=bal_output&amp;balanceFrom=<{$balance.bal_from}>&amp;balanceTo=<{$balance.bal_to}>' title='<{$smarty.const._MA_WGSIMPLEACC_OUTPUTS}>'><{$smarty.const._MA_WGSIMPLEACC_OUTPUTS}></a>
                                <{if $balance.type|default:0 == $balTypeTemporary && $permBalancesSubmit}>
                                    <a class='btn btn-danger right' href='balances.php?op=delete&amp;balanceFrom=<{$balance.bal_from}>&amp;balanceTo=<{$balance.bal_to}>' title='<{$smarty.const._MA_WGSIMPLEACC_BALANCE_DELETE}>'><{$smarty.const._MA_WGSIMPLEACC_BALANCE_DELETE}></a>
                                <{/if}>
                            </td>
                        </tr>
                    <{/foreach}>
                </tbody>
            </table>
        </div>
    <{else}>
        <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_BALANCES}>
    <{/if}>
<{/if}>
<{if $balanceDetails|default:''}>
    <{if $balancesCount|default:0 > 0}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_BALANCE_DETAILS}></h3>
    <div class='table-responsive'>
        <table class='table table-<{$table_type|default:''}>'>
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
                    <td><{$balance.to|default:''}></td>
                    <td><{$balance.asset|default:''}></td>
                    <td><{$balance.curid|default:''}></td>
                    <td><{$balance.amountstart}></td>
                    <td><{$balance.amountend}></td>
                    <td><{$balance.datecreated|default:''}></td>
                    <td><{$balance.submitter|default:''}></td>
                </tr>
                <{/foreach}>
            <tr>
                <td colspan="8" class="center">
                    <a class='btn btn-success right' href='balances.php?op=list' title='<{$smarty.const._BACK}>'><{$smarty.const._BACK}></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <{else}>
    <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_BALANCES}>
    <{/if}>
<{/if}>

<{if $balancesCalc|default:''}>
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
                        <{if $balance.id > 0}>
                            <a class='btn btn-success right<{if $balance.amount_diff == 0}> disabled<{/if}>' href='transactions.php?op=list&amp;as_id=<{$balance.id}><{$trafilter}>' target='_blank' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
                        <{/if}>
                    </td>
                </tr>
            <{/foreach}>
        </tbody>
        <tfoot>
            <tr>
                <td class="center" colspan="5">
                    <{if $permBalancesSubmit}>
                        <{if $balType|default:0 == $balTypeFinal}>
                            <a class='btn btn-primary' href='balances.php?op=save<{$balfilter}>&amp;bal_type=<{$balTypeFinal}>' title='<{$smarty.const._MA_WGSIMPLEACC_BALANCE_SUBMIT_FINAL}>'><{$smarty.const._MA_WGSIMPLEACC_BALANCE_SUBMIT_FINAL}></a>
                        <{else}>
                            <a class='btn btn-primary' href='balances.php?op=save<{$balfilter}>' title='<{$smarty.const._MA_WGSIMPLEACC_BALANCE_SUBMIT_TEMPORARY}>'><{$smarty.const._MA_WGSIMPLEACC_BALANCE_SUBMIT_TEMPORARY}></a>
                        <{/if}>
                    <{/if}>
                </td>
            </tr>
        </tfoot>
    </table>
<{/if}>
