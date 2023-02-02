<script src="<{$wgsimpleacc_url}>/assets/chartjs/dist/Chart.min.js"></script>
<script>
    window.chartColors = {
        <{foreach item=color from=$colors}>
        <{$color.name}>:'<{$color.code}>',
    <{/foreach}>
    };
</script>

<{if $transactionsCount|default:0 > 0}>
    <h3><{$header_allocs_bar}></h3>
    <div class="col-xs-12 col-sm-12">
        <{include file='db:wgsimpleacc_chart_transactions_hbar.tpl'}>
    </div>
<{/if}>
<{if $assetsCount|default:0 > 0}>
    <h3><{$header_assets_pie}></h3>
    <div class="wgsa-statistics-assets">
        <div class="col-xs-12 col-sm-5 wgsa-statistics-assets">
            <{foreach item=asset from=$assetList}>
            <div class="row wgsa-statistics-assets-row" style="margin:5px 0">
                <div class="col-sm-6 col-md-6 left"><span style="display:inline-block;width:20px;background-color:<{$asset.color}>">&nbsp;</span> <{$asset.name}>:</div>
                <div class="col-sm-4 col-md-4 right"><{$asset.amount}></div>
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
<{if $accountsBarCount|default:0 > 0}>
    <div class="col-xs-12 col-sm-12">
        <{include file='db:wgsimpleacc_chart_accounts_hbar.tpl'}>
    </div>
<{/if}>
<{if $accountsCount|default:0 > 0}>
    <div class="col-xs-12 col-sm-12">
        <{include file='db:wgsimpleacc_chart_accounts_line.tpl'}>
    </div>
<{/if}>
<{if $balancesCount|default:0 > 0}>
<div class="col-xs-12 col-sm-12">
    <{include file='db:wgsimpleacc_chart_balances_line.tpl'}>
</div>
<{/if}>
<{if $formFilter|default:false}>
    <{$formFilter}>
<{/if}>

<script>
    $('li :checkbox').on('click', function () {
        var $chk = $(this), $li = $chk.closest('li'), $ul, $parent;
        if ($li.has('ul')) {
            $li.find(':checkbox').not(this).prop('checked', this.checked)
        }
        do {
            $ul = $li.parent();
            $parent = $ul.siblings(':checkbox');
            if ($chk.is(':checked')) {
                $parent.prop('checked', $ul.has(':checkbox:not(:checked)').length == 0)
            } else {
                $parent.prop('checked', false)
            }
            $chk = $parent;
            $li = $chk.closest('li');
        } while ($ul.is(':not(.someclass)'));
    });
</script>
        