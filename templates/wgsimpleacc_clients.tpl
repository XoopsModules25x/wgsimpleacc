<{if $showList|default:''}>
    <{if $formFilter|default:''}>
        <div class='right'><{$formFilter}></div>
    <{/if}>
    <{if $clientsCount|default:0 > 0}>
        <{if $showFiltered|default:false}>
            <h3><{$smarty.const._MA_WGSIMPLEACC_CLIENTS_FILTERED}></h3>
        <{else}>
            <h3><{$smarty.const._MA_WGSIMPLEACC_CLIENTS_LIST}></h3>
        <{/if}>
        <div class='table-responsive'>
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>
                            <{$smarty.const._MA_WGSIMPLEACC_CLIENT_NAME}>
                            <a href="clients.php?op=list&amp;orderby=ASC&amp;sortby=cli_name&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._ASCENDING}>">
                                <img src="<{xoModuleIcons16 'up.png'}>" alt="<{$smarty.const._ASCENDING}>"></a>
                            <a href="clients.php?op=list&amp;orderby=DESC&amp;sortby=cli_name&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DESCENDING}>">
                                <img src="<{xoModuleIcons16 'down.png'}>" alt="<{$smarty.const._DESCENDING}>"></a>
                        </th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_CLIENT_FULLADDRESS}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_CLIENT_PHONE}></th>
                        <th><{$smarty.const._MA_WGSIMPLEACC_CLIENT_VAT}></th>
                        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_CREDITOR}></th>
                        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_DEBTOR}></th>
                        <th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_ONLINE}></th>
                        <th class="center">
                            <{$smarty.const._MA_WGSIMPLEACC_DATECREATED}>
                            <a href="clients.php?op=list&amp;orderby=ASC&amp;sortby=cli_datecreated&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._ASCENDING}>">
                                <img src="<{xoModuleIcons16 'up.png'}>" alt="<{$smarty.const._ASCENDING}>"></a>
                            <a href="clients.php?op=list&amp;orderby=DESC&amp;sortby=cli_datecreated&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._DESCENDING}>">
                                <img src="<{xoModuleIcons16 'down.png'}>" alt="<{$smarty.const._DESCENDING}>"></a>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <{foreach item=client from=$clients name=client}>
                        <{include file='db:wgsimpleacc_clients_list.tpl' }>
                    <{/foreach}>
                </tbody>
            </table>
        </div>
    <{else}>
        <{if $showFiltered|default:false}>
            <{$smarty.const._MA_WGSIMPLEACC_CLIENTS_FILTEREDNON}>
        <{else}>
            <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_CLIENTS}>
        <{/if}>
    <{/if}>
<{else}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_CLIENT_DETAILS}></h3>
    <{foreach item=client from=$clients name=client}>
        <{include file='db:wgsimpleacc_clients_item.tpl' }>
    <{/foreach}>
<{/if}>
