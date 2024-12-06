<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $taxes_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_TAX_ID}></th>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_TAX_NAME}></th>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_TAX_RATE}></th>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_TAX_ONLINE}></th>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_TAX_PRIMARY}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $taxes_count|default:0}>
        <tbody>
            <{foreach item=tax from=$taxes_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$tax.id}></td>
                <td class='center'><{$tax.name}></td>
                <td class='center'><{$tax.rate}></td>
                <td class='center'><{$tax.online}></td>
                <td class='center'><{$tax.primary}></td>
                <td class='center'><{$tax.datecreated}></td>
                <td class='center'><{$tax.submitter}></td>
                <td class="center  width5">
                    <a href="taxes.php?op=edit&amp;tax_id=<{$tax.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> taxes"></a>
                    <a href="taxes.php?op=delete&amp;tax_id=<{$tax.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> taxes"></a>
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
