<script src="<{$wgsimpleacc_url}>/assets/chartjs/dist/Chart.min.js"></script>
<script>
    window.chartColors = {
        <{foreach item=color from=$colors}>
            <{$color.name}>:'<{$color.code}>',
        <{/foreach}>
    };
</script>

<{if $transactionsCount > 0}>
    <div class="col-sm-12 col-md-12 col-lg-6">
        <{include file='db:wgsimpleacc_chart_transactions_hbar.tpl'}>
    </div>
<{/if}>

<{if $assetsCount > 0}>
    <div class="col-sm-12 col-md-12 col-lg-6">
        <h3><{$header_assets_pie}></h3>
        <{include file='db:wgsimpleacc_chart_assets_pie.tpl'}>
        <div class="row wgsa-index-assets">
            <{foreach item=asset from=$assetList}>
            <div class="row wgsa-statistics-assets-row" style="margin:5px 0">
                <div class="hidden-xs hidden-sm col-md-1 col-lg-3 left"></div>
                <div class="col-xs-6 col-sm-6 col-md-5 col-lg-4 left"><span style="display:inline-block;width:20px;background-color:<{$asset.color}>">&nbsp;</span> <{$asset.name}>:</div>
                <div class="col-xs-6 col-sm-6 col-md-5 col-lg-2 right"><{$asset.amount}></div>
                <div class="hidden-xs hidden-sm col-md-1 col-lg-3 left"></div>
            </div>
            <{/foreach}>
        </div>
        </div>
    </div>
<{/if}>
<{if $error}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>


