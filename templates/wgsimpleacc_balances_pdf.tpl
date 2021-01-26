
<!-- tcpdf does not accept style="padding:10px" -->
<!-- therefore let cellpadding in -->

<table style="width:100%;">
    <tr>
        <td style="width:50%;border-bottom:1px solid #ccc;"><img src="<{$logo.src}>" style="height:<{$logo.height}>"></td>
        <td style="text-align:right;width:50%;border-bottom:1px solid #ccc;"><br><h3><{$header_title}></h3><p><{$header_string}></p></td>
    </tr>
</table>

<{if $balancesCount|default:0 > 0}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_BALANCES_LIST}></h3>
    <div>
        <table style="width:100%;" cellspacing="2" cellpadding="5">
            <thead>
            <tr class='head'>
                <th style="<{$pdfStyleTh}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_ASID}></th>
                <th style="<{$pdfStyleThC}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_FROM}></th>
                <th style="<{$pdfStyleThC}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_TO}></th>
                <th style="<{$pdfStyleThC}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_CURID}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTSTART}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTEND}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_DIFFERENCE}></th>
                <th style="<{$pdfStyleThC}>"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
            </tr>
            </thead>
            <tbody>
                <{foreach item=balance from=$balances}>
                    <tr>
                        <td style="<{$pdfStyleTd}>"><span style="margin-right:10px;padding:5px 10px;width:20px;background-color:<{$balance.color}>"></span><{$balance.asset}></td>
                        <td style="<{$pdfStyleTdC}>"><{$balance.from}></td>
                        <td style="<{$pdfStyleTdC}>"><{$balance.to}></td>
                        <td style="<{$pdfStyleTdC}>"><{$balance.curid}></td>
                        <td style="<{$pdfStyleTdR}>"><{$balance.amountstart}></td>
                        <td style="<{$pdfStyleTdR}>"><{$balance.amountend}></td>
                        <td style="<{$pdfStyleTdR}>"><{$balance.difference}></td>
                        <td style="<{$pdfStyleTdC}>"><{$balance.datecreated}></td>
                    </tr>
                <{/foreach}>
                <tr>
                    <td style="<{$pdfStyleTd}>" colspan="4" ><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_SUMS}></td>
                    <td style="<{$pdfStyleTdR}>"><{$balancesAmountIn}></td>
                    <td style="<{$pdfStyleTdR}>"><{$balancesAmountOut}></td>
                    <td style="<{$pdfStyleTdR}>"><{$balancesTotal}></td>
                    <td colspan="2" style="<{$pdfStyleTdR}>"></td>
                </tr>
            </tbody>
        </table>
    </div>
<{/if}>
<{if $accountsCount|default:0 > 0}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS_LIST}></h3>
    <div>
        <table style="width:100%;" cellspacing="2" cellpadding="5">
            <thead>
            <tr class='head'>
                <th style="<{$pdfStyleTh}>"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_NAME}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_TOTAL}></th>
            </tr>
            </thead>
            <tbody>
            <{foreach item=account from=$accounts}>
                <tr>
                    <td style="<{$pdfStyleTd}>"><span style="margin-right:10px;padding:5px 10px;width:20px;background-color:<{$account.color}>"></span><{$account.name}></td>
                    <td style="<{$pdfStyleTdR}>"><{$account.amountin}></td>
                    <td style="<{$pdfStyleTdR}>"><{$account.amountout}></td>
                    <td style="<{$pdfStyleTdR}>"><{$account.total}></td>
                </tr>
                <{/foreach}>
                <tr>
                    <td style="<{$pdfStyleTd}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_SUMS}></td>
                    <td style="<{$pdfStyleTdR}>"><{$accountsAmountIn}></td>
                    <td style="<{$pdfStyleTdR}>"><{$accountsAmountOut}></td>
                    <td style="<{$pdfStyleTdR}>"><{$accountsTotal}></td>
                </tr>
            </tbody>
        </table>
    </div>
<{/if}>
<{if $allocationsCount|default:0 > 0}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS_LIST}></h3>
    <div>
        <table style="width:100%;" cellspacing="2" cellpadding="5">
            <thead>
            <tr class='head'>
                <th style="<{$pdfStyleTh}>"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_NAME}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT}></th>
                <th style="<{$pdfStyleThR}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_TOTAL}></th>
            </tr>
            </thead>
            <tbody>
            <{foreach item=allocation from=$allocations}>
                <tr>
                    <td style="<{$pdfStyleTd}>"><{$allocation.name}></td>
                    <td style="<{$pdfStyleTdR}>"><{$allocation.amountin}></td>
                    <td style="<{$pdfStyleTdR}>"><{$allocation.amountout}></td>
                    <td style="<{$pdfStyleTdR}>"><{$allocation.total}></td>
                </tr>
                <{/foreach}>
            <tr >
                <td style="<{$pdfStyleTd}>"><{$smarty.const._MA_WGSIMPLEACC_BALANCES_OUT_SUMS}></td>
                <td style="<{$pdfStyleTdR}>"><{$allocationsAmountIn}></td>
                <td style="<{$pdfStyleTdR}>"><{$allocationsAmountOut}></td>
                <td style="<{$pdfStyleTdR}>"><{$allocationsTotal}></td>
            </tr>
            </tbody>
        </table>
    </div>
<{/if}>