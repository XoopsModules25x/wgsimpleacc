<{if $showList}>
    <{if $tratemplatesCount > 0}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATES_LIST}></h3>
    <div class='table-responsive'>
        <table class='table table-striped'>
            <thead>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_NAME}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_DESC}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_ACCID}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_ALLID}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_ASID}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_AMOUNTIN}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_AMOUNTOUT}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRATEMPLATE_ONLINE}></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <{foreach item=template from=$tratemplates}>
                <{include file='db:wgsimpleacc_tratemplates_list.tpl' }>
                <{/foreach}>
            </tbody>
            <tfoot><tr><td>&nbsp;</td></tr></tfoot>
        </table>
    </div>
    <{else}>
    <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_TRATEMPLATES}>
    <{/if}>
<{/if}>
