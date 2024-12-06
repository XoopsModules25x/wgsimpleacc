<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $balances_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_ID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_FROM}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_TO}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_ASID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_CURID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTSTART}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_AMOUNTEND}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_BALANCE_STATUS}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $balances_count|default:0}>
            <tbody>
                <{foreach item=balance from=$balances_list}>
                    <tr class='<{cycle values='odd, even'}>'>
                        <td class='center'><{$balance.id}></td>
                        <td class='center'><{$balance.from}></td>
                        <td class='center'><{$balance.to}></td>
                        <td class='center'><{$balance.asset}></td>
                        <td class='center'><{$balance.curid}></td>
                        <td class='center'><{$balance.amountstart}></td>
                        <td class='center'><{$balance.amountend}></td>
                        <td class='center'><img src="<{$modPathIcon16}>status<{$balance.status}>.png" alt="<{$balance.status_text}>" title="<{$balance.status_text}>"> <{$balance.type_text}></td>
                        <td class='center'><{$balance.datecreated}></td>
                        <td class='center'><{$balance.submitter}></td>
                        <td class="center  width5">
                            <a href="balances.php?op=edit&amp;bal_id=<{$balance.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> balances"></a>
                            <a href="balances.php?op=delete&amp;bal_id=<{$balance.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> balances"></a>
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
