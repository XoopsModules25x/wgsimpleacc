<{if $assetsList}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_ASSETS_LIST}></h3>
    <div class='table-responsive'>
        <table class='table table-striped'>
            <thead>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_NAME}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_REFERENCE}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_DESCR}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_COLOR}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_PRIMARY}></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <{foreach item=asset from=$assets}>
                <{include file='db:wgsimpleacc_assets_item.tpl' }>
                <{/foreach}>
            </tbody>
            <tfoot><tr><td>&nbsp;</td></tr></tfoot>
        </table>
    </div>
<{/if}>
<{if $assetsCount == 0}>
    <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_ASSETS}>
<{/if}>