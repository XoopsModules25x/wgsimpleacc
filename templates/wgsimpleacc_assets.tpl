<{if $assetsList|default:''}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_ASSETS_LIST}></h3>
    <div class='table-responsive'>
        <table class='table table-striped'>
            <thead>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_NAME}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_REFERENCE}></th>
                <th><{$smarty.const._MA_WGSIMPLEACC_ASSET_DESCR}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_COLOR}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_PRIMARY}></th>
                <{if $permSubmit}>
                    <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_IECALC}></th>
                    <th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_ONLINE}></th>
                <{/if}>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <{foreach item=asset from=$assets}>
                <{include file='db:wgsimpleacc_assets_item.tpl' }>
                <{/foreach}>
            </tbody>
        </table>
    </div>
<{/if}>
<{if $assetsCount|default:0 == 0}>
    <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_ASSETS}>
<{/if}>