<script src="<{$wgsimpleacc_url}>/assets/chartjs/dist/Chart.min.js"></script>
<script>
    window.chartColors = {
        <{foreach item=color from=$colors}>
        <{$color.name}>:'<{$color.code}>',
    <{/foreach}>
    };
</script>

<{if $transactionsCount > 0}>
    <div class="col-xs-12 col-sm-12">
        <{include file='db:wgsimpleacc_chart_transactions_hbar.tpl'}>
    </div>
<{/if}>
<{if $assetsCount > 0}>
    <h3><{$header_assets_pie}></h3>
    <div class="wgsa-statistics-assets">
        <div class="col-xs-12 col-sm-5 wgsa-statistics-assets">
            <{foreach item=asset from=$assetList}>
            <div class="row wgsa-statistics-assets-row" style="margin:5px 0">
                <div class="col-sm-6 col-md-8"><span style="display:inline-block;width:20px;background-color:<{$asset.color}>">&nbsp;</span> <{$asset.name}>:</div>
                <div class="col-sm-6 col-md-4"><{$asset.amount}></div>
            </div>
            <{/foreach}>
        </div>
        <div class="col-xs-12 col-sm-7">
            <{include file='db:wgsimpleacc_chart_assets_pie.tpl'}>
        </div>

    </div>

    <div class="clear"></div>
    <div class="col-xs-12 col-sm-12">
        <{include file='db:wgsimpleacc_chart_assets_line.tpl'}>
    </div>
<{/if}>
<{if $accountsCount > 0}>
    <div class="col-xs-12 col-sm-12">
        <{include file='db:wgsimpleacc_chart_accounts_line.tpl'}>
    </div>
<{/if}>
<{if $balancesCount > 0}>
<div class="col-xs-12 col-sm-12">
    <{include file='db:wgsimpleacc_chart_balances_line.tpl'}>
</div>
<{/if}>
		