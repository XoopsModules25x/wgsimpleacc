<{include file='db:wgsimpleacc_header.tpl' }>

<div class="wgsa-content">
    <div class="wgsa-startmincontent">
        <{if $formLogin|default:''}>
            <div class="clear"></div>
            <div class="row">
                <div class="hidden-xs col-sm-4">&nbsp;</div>
                <div class="col-xs-12 col-sm-4">
                    <div class="errorMsg"><strong><{$errorPerm|default:'no permission'}></strong></div>
                    <{include file='db:system_block_login.tpl'}>
                </div>
                <div class="hidden-xs col-sm-4">&nbsp;</div>
            </div>
        <{else}>
            <{if $show_breadcrumbs|default:''}>
                <div class="row">
                    <{include file='db:wgsimpleacc_breadcrumbs.tpl'}>
                </div>
            <{/if}>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 wgsa-maincontent">
                    <{include file=$template_sub}>
                    <{if !empty($error)}>
                        <div class="errorMsg"><strong><{$error}></strong></div>
                    <{/if}>
                    <{if !empty($form)}>
                        <{$form}>
                    <{/if}>
                </div>
            </div>
        <{/if}>
    </div>
</div>


<{if $adv|default:''}>
    <div class="row">
        <div class="col-sm-12"><{$adv}></div>
    </div>
<{/if}>

<{include file='db:wgsimpleacc_footer.tpl' }>
