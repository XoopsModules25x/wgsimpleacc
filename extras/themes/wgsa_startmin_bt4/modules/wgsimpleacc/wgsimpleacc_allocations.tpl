<{if $allocationlist_sort|default:''}>
    <div class='col-sm-12 col-sm-12'>
        <div class='panel list-sort-panel'>
            <h3><{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS_LIST}></h3>
            <div class='panel-body list-sort-panelbody'>
                <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded list-sort-ol">
                    <{$allocationlist_sort}>
                </ol>
                <p class='center'>
                    <a class='btn btn-default wgg-btn' href='allocations.php' title='<{$smarty.const._MA_WGSIMPLEACC_REFRESH}>'>
                        <img class='wgg-btn-icon' src='<{$wgsimpleacc_icon_url_16}>reset.png' alt='<{$smarty.const._MA_WGSIMPLEACC_REFRESH}>'><{$smarty.const._MA_WGSIMPLEACC_REFRESH}></a>
                    <{if $allocations_submit|default:''}>
                        <a class='btn btn-default wgg-btn' href='allocations.php?op=new&all_pid=<{$allpid|default:0 }>' title='<{$smarty.const._ADD}>'>
                            <img class='wgg-btn-icon' src='<{$wgsimpleacc_icon_url_16}>add.png' alt='<{$smarty.const._ADD}>'><{$smarty.const._ADD}></a>
                    <{/if}>
                </p>
            </div>
        </div>
    </div>
<{/if}>
<{if $allocationsCount|default:0 == 0}>
    <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_ALLOCATIONS}>
<{/if}>