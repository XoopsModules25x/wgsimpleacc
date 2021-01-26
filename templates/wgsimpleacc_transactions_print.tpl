<!-- Header -->
<{include file='db:wgsimpleacc_header.tpl' }>

<table class='table table-bordered'>
    <thead class="outer">
    <tr class='head'>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ID}></th>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}></th>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLID}></th>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}></th>
        <{if $useCurrencies}>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CURID}></th>
        <{/if}>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN}></th>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT}></th>
        <{if $useTaxes|default:''}>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
        <{/if}>
        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_STATUS}></th>
    </tr>
    </thead>
    <tbody>
    <{foreach item=transaction from=$transactions_list}>
        <tr class='<{cycle values='odd, even'}>'>
            <td class='center'><{$transaction.id}></td>
            <td class='center'><{$transaction.desc_short}></td>
            <td class='center'><{$transaction.reference}></td>
            <td class='center'><{$transaction.accid}></td>
            <td class='center'><{$transaction.allid}></td>
            <td class='center'><{$transaction.date}></td>
            <{if $useCurrencies}>
                <td class='center'><{$transaction.currid}></td>
            <{/if}>
            <td class='center'><{$transaction.amountin}></td>
            <td class='center'><{$transaction.amountout}></td>
            <{if $useTaxes|default:''}>
                <td class='center'><{$transaction.taxid}></td>
            <{/if}>
            <td class='center'><{$transaction.status_text}></td>
        </tr>
        <{/foreach}>
    </tbody>
</table>

