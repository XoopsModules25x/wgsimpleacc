<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $allocations_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_ID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_PID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_NAME}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_DESC}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_ONLINE}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_LEVEL}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_WEIGHT}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $allocations_count}>
        <tbody>
            <{foreach item=allocation from=$allocations_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$allocation.id}></td>
                <td class='center'><{$allocation.pid}></td>
                <td class='center'><{$allocation.name}></td>
                <td class='center'><{$allocation.desc_short}></td>
                <td class='center'><{$allocation.online}></td>
                <td class='left'>
                    <{if $allocation.accounts|default:false}>
                        <ul>
                            <{foreach item=account from=$allocation.accounts|default:false}>
                                <li><{$account}></li>
                            <{/foreach}>
                        </ul>
                    <{/if}>
                </td>
                <td class='center'><{$allocation.level}></td>
                <td class='center'><{$allocation.weight}></td>
                <td class='center'><{$allocation.datecreated}></td>
                <td class='center'><{$allocation.submitter}></td>
                <td class="center  width5">
                    <a href="allocations.php?op=edit&amp;all_id=<{$allocation.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> allocations"></a>
                    <a href="allocations.php?op=delete&amp;all_id=<{$allocation.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> allocations"></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if $pagenav|default:''}>
        <div class="xo-pagenav floatright"><{$pagenav}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if $form|default:''}>
    <{$form}>
<{/if}>
<{if $error|default:''}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgsimpleacc_admin_footer.tpl' }>
