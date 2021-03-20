<script src="<{$wgsimpleacc_url}>/assets/chartjs/dist/Chart.min.js"></script>
<script>
    window.chartColors = {
        <{foreach item=color from=$colors}>
            <{$color.name}>:'<{$color.code}>',
        <{/foreach}>
    };
</script>

<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }
</style>

<{if $indexTrahbar|default:0 > 0}>
    <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="wgsa-index-panel">
            <h3 class="center"><{$header_transactions}></h3>
            <{include file='db:wgsimpleacc_chart_transactions_hbar.tpl'}>
        </div>
    </div>
<{/if}>

<{if $indexAssetsPie|default:0 > 0}>
    <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="wgsa-index-panel">
            <h3 class="center"><{$assets_header}></h3>
            <{include file='db:wgsimpleacc_chart_assets_pie.tpl'}>
            <div class="row wgsa-index-assets">
                <{foreach item=asset from=$assets_list}>
                <div class="row wgsa-statistics-assets-row" style="margin:5px 0">
                    <div class="hidden-xs hidden-sm col-md-1 col-lg-3 left"></div>
                    <div class="col-xs-6 col-sm-6 col-md-5 col-lg-4 left"><span style="display:inline-block;width:20px;background-color:<{$asset.color}>">&nbsp;</span> <{$asset.name}>:</div>
                    <div class="col-xs-6 col-sm-6 col-md-5 col-lg-2 right"><{$asset.amount_diff}></div>
                    <div class="hidden-xs hidden-sm col-md-1 col-lg-3 left"></div>
                </div>
                <{/foreach}>
            </div>
        </div>
    </div>
<{/if}>

<{if $indexAssetsPieTotal|default:0 > 0}>
    <div class="col-sm-12 col-md-12 col-lg-6">
        <div class="wgsa-index-panel">
            <h3 class="center"><{$assetsTotal_header}></h3>
            <{include file='db:wgsimpleacc_chart_assets_pietotal.tpl'}>
            <div class="row wgsa-index-assets">
                <{foreach item=asset from=$assetsTotal_list}>
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

<{if $indexTraInExSums|default:0 > 0}>
    <div class="col-sm-12 col-md-6 col-lg-6">
        <div class="wgsa-index-panel">
            <h3 class="center"><{$header_transactions_sums}></h3>
            <{include file='db:wgsimpleacc_chart_transactions_inexsums.tpl'}>
        </div>
    </div>
<{/if}>
