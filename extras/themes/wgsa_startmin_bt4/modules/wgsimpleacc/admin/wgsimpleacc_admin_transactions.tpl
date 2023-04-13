<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $transactions_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_YEARNB}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REMARKS}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CURID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTIN}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNTOUT}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CLIID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_STATUS}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_COMMENTS}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CLASS}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_BALID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_BALIDT}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_HIST}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $transactions_count|default:0}>
            <tbody>
                <{foreach item=transaction from=$transactions_list}>
                    <tr class='<{cycle values='odd, even'}>'>
                        <td class='center'><{$transaction.id}></td>
                        <td class='center'><{$transaction.year}>/<{$transaction.nb}></td>
                        <td class='center'><{$transaction.desc_short}></td>
                        <td class='center'><{$transaction.reference}></td>
                        <td class='center'><{$transaction.remarks_short}></td>
                        <td class='center'><{$transaction.account}></td>
                        <td class='center'><{$transaction.allocation}></td>
                        <td class='center'><{$transaction.date}></td>
                        <td class='center'><{$transaction.curid}></td>
                        <td class='center'><{$transaction.amountin}></td>
                        <td class='center'><{$transaction.amountout}></td>
                        <td class='center'><{$transaction.taxid}></td>
                        <td class='center'><{$transaction.asset}></td>
                        <td class='center'><{$transaction.client}></td>
                        <td class='center'><img src="<{$modPathIcon16}>status<{$transaction.status}>.png" alt="<{$transaction.status_text}>" title="<{$transaction.status_text}>"></td>
                        <td class='center'><{$transaction.comments}></td>
                        <td class='center'><{$transaction.class_text}></td>
                        <td class='center'><{$transaction.balid}></td>
                        <td class='center'><{$transaction.balidt}></td>
                        <td class='center'><{$transaction.hist}></td>
                        <td class='center'><{$transaction.datecreated}></td>
                        <td class='center'><{$transaction.submitter}></td>
                        <td class="center  width5">
                            <a href="transactions.php?op=edit&amp;tra_id=<{$transaction.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> transactions"></a>
                            <a href="transactions.php?op=delete&amp;tra_id=<{$transaction.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> transactions"></a>
                        </td>
                    </tr>
                <{/foreach}>
            </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if !empty($pagenav)}>
        <div class="xo-pagenav floatright"><{$pagenav}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if !empty($form)}>
    <{$form}>
<{/if}>
<{if !empty($error)}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgsimpleacc_admin_footer.tpl' }>
