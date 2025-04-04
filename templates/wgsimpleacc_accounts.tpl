<{if $accountlist_collapsible|default:''}>
    <style>
        .list-group.list-group-root {
            padding: 0;
        }
        .list-group.list-group-root .list-group {
            margin-bottom: 0;
        }
        .list-group.list-group-root .list-group-item {}
        .list-group.list-group-root > .list-group-item:first-child {}
        .list-group.list-group-root .list-group {
            padding-left:30px;
        }
        .list-group.list-group-root .list-group .list-group-item {
            width:100%;
        }
        .list-group.list-group-root .list-group .list-group-item {
            border:1px solid #ccc;
            border-radius:5px;
        }
        .list-group-item .fa {
            margin-right: 5px;
        }
    </style>

    <h3><{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS_LIST}></h3>
    <div class="list-group list-group-root well">
        <{include file='db:wgsimpleacc_accounts_listcoll.tpl' list_collapsible=$accountlist_collapsible}>
    </div>
    <div class="clear"></div>
    <div class='col-12' style="margin:auto">
        <p class="pull-right wgsa-btn-list">
            <a class='btn btn-warning wgsa-btn' href='accounts.php' title='<{$smarty.const._MA_WGSIMPLEACC_REFRESH}>'><{$smarty.const._MA_WGSIMPLEACC_REFRESH}></a>
            <{if $accounts_submit|default:''}>
            <a class='btn btn-primary wgsa-btn' href='accounts.php?op=new&all_pid=<{$allpid|default:0 }>' title='<{$smarty.const._ADD}>'><{$smarty.const._ADD}></a>
            <{/if}>
        </p>
    </div>

    <script>
        $(function() {
            $('.collapseme').on('click', function() {
                $('.fa', this)
                    .toggleClass('fa-chevron-right')
                    .toggleClass('fa-chevron-down');
            });
        });
    </script>
<{/if}>
<{if $accountlist_sort|default:''}>
    <div class='col-sm-12 col-sm-12'>
        <div class='panel list-sort-panel'>
            <h3><{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS_LIST}></h3>
            <div class='panel-body list-sort-panelbody'>
                <input type="checkbox" name="collapse_all" id="collapse_all" class="wgsa-collapse-all" title="<{$smarty.const._MA_WGSIMPLEACC_COLLAPSE_ALL}>" value="0"><{$smarty.const._MA_WGSIMPLEACC_COLLAPSE_ALL}>
                <ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded list-sort-ol">
                    <{$accountlist_sort}>
                </ol>
                <p class='center'>
                    <a class='btn btn-secondary wgg-btn' href='accounts.php' title='<{$smarty.const._MA_WGSIMPLEACC_REFRESH}>'>
                        <img class='wgg-btn-icon' src='<{$wgsimpleacc_icons_url_16}>reset.png' alt='<{$smarty.const._MA_WGSIMPLEACC_REFRESH}>'><{$smarty.const._MA_WGSIMPLEACC_REFRESH}></a>
                    <{if $accounts_submit}>
                        <a class='btn btn-secondary wgg-btn' href='accounts.php?op=new&all_pid=<{$allpid|default:0 }>' title='<{$smarty.const._ADD}>'>
                            <img class='wgg-btn-icon' src='<{$wgsimpleacc_icons_url_16}>add.png' alt='<{$smarty.const._ADD}>'><{$smarty.const._ADD}></a>
                    <{/if}>
                </p>
            </div>
        </div>
    </div>
<{/if}>

<{if $compare_list|default:''}>
    <table class='table table-bordered'>
        <thead>
        <tr class='head'>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_ID}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_KEY}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_NAME}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ALLOCATIONS}> (<{$smarty.const._MA_WGSIMPLEACC_ONLINE}>)</th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
        </tr>
        </thead>
        <{if $accounts_count}>
            <tbody>
                <{foreach item=account from=$compare_list}>
                    <tr class='<{cycle values='odd, even'}>'>
                        <td class='center'><{$account.id}></td>
                        <td class='center'><{$account.key}></td>
                        <td class='center'><{$account.name}></td>
                        <td class='center'>
                            <{if $account.allocations|default:false}>
                                <ul>
                                    <{foreach item=alloc from=$account.allocations|default:false}>
                                    <li>
                                        <{$alloc.name}>
                                        <img class="wgsa-img-online wgsa-img-online-small" src="<{$smarty.const.WGSIMPLEACC_ICONS_URL}>/32/<{$alloc.online}>.png" title="<{$alloc.online_text}>" alt="<{$alloc.online_text}>">
                                    </li>
                                    <{/foreach}>
                                </ul>
                            <{/if}>
                        </td>
                        <td class='center'><{$account.datecreated}></td>
                        <td class='center'><{$account.submitter}></td>
                    </tr>
                <{/foreach}>
            </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
<{/if}>

<{if $accountsCount|default:0 == 0}>
    <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_ACCOUNTS}>
<{/if}>
        