<{if $allocationlist_sort|default:''}>
    <div class='col-sm-12 col-sm-12'>
        <div class='panel list-sort-panel'>
            <h3><{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS_LIST}></h3>
            <div class='panel-body list-sort-panelbody'>
                <input type="checkbox" name="collapse_all" id="collapse_all" class="wgsa-collapse-all" title="<{$smarty.const._MA_WGSIMPLEACC_COLLAPSE_ALL}>" value="0"><{$smarty.const._MA_WGSIMPLEACC_COLLAPSE_ALL}>
                <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded list-sort-ol">
                    <{$allocationlist_sort}>
                </ol>
                <p class='center'>
                    <a class='btn btn-secondary wgg-btn' href='allocations.php' title='<{$smarty.const._MA_WGSIMPLEACC_REFRESH}>'>
                        <img class='wgg-btn-icon' src='<{$wgsimpleacc_icons_url_16}>reset.png' alt='<{$smarty.const._MA_WGSIMPLEACC_REFRESH}>'><{$smarty.const._MA_WGSIMPLEACC_REFRESH}></a>
                    <{if $allocations_submit|default:''}>
                        <a class='btn btn-secondary wgg-btn' href='allocations.php?op=new&all_pid=<{$allpid|default:0 }>' title='<{$smarty.const._ADD}>'>
                            <img class='wgg-btn-icon' src='<{$wgsimpleacc_icons_url_16}>add.png' alt='<{$smarty.const._ADD}>'><{$smarty.const._ADD}></a>
                    <{/if}>
                </p>
            </div>
        </div>
    </div>
<{/if}>
<{if $allocationsCount|default:0 == 0}>
    <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_ALLOCATIONS}>
<{/if}>

<{if $compare_list|default:''}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS_COMPARE}></h3>
    <table class='table table-bordered'>
        <thead>
        <tr class='head'>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_ID}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_NAME}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_ONLINE}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATION_ACCOUNTS}> (<{$smarty.const._MA_WGSIMPLEACC_ONLINE}>)</th>
            <th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
        </tr>
        </thead>
        <{if $allocations_count}>
        <tbody>
        <{foreach item=allocation from=$compare_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$allocation.id}></td>
                <td class='center'><{$allocation.name}></td>
                <td class='center'>
                    <img class="wgsa-img-online wgsa-img-online-small" src="<{$smarty.const.WGSIMPLEACC_ICONS_URL}>/32/<{$allocation.all_online}>.png" title="<{$allocation.online_text}>" alt="<{$allocation.online_text}>">
                </td>
                <td class='center'><{$allocation.tracount}></td>
                <td class='left'>
                    <{if $allocation.accounts|default:false}>
                    <ul>
                        <{foreach item=account from=$allocation.accounts|default:false}>
                        <li>
                            <{$account.name}>
                            <img class="wgsa-img-online wgsa-img-online-small" src="<{$smarty.const.WGSIMPLEACC_ICONS_URL}>/32/<{$account.online}>.png" title="<{$account.online_text}>" alt="<{$account.online_text}>">
                        </li>
                        <{/foreach}>
                    </ul>
                    <{/if}>
                </td>
                <td class="center  width5">
                    <a href="allocations.php?op=edit&amp;all_id=<{$allocation.id}>&amp;redir=compare_accounts&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> allocations"></a>
                    <a href="allocations.php?op=delete&amp;all_id=<{$allocation.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> allocations"></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
<{/if}>