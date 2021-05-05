
<{include file='db:wgsimpleacc_header.tpl' }>

<div class="container-fluid">
    <div class="row">
        <div class="col-2"><a class="" href="index.php"><img class="img-fluid" src="<{xoImgUrl}>images/logo.png" alt="Logo"></a></div>
        <{if $indexHeader|default:''}>
            <div class="col-5"><h3><{$indexHeader}></h3></div>
            <div class="col-5 right">
        <{else}>
            <div class="col-10 right">
        <{/if}>
        <{if $xoops_isuser|default:false}>
            <{if $xoops_isadmin|default:false}>
                <a class="wgsa-startminheader-link" href="<{$xoops_url}>/admin.php"><span class="fa fa-wrench" alt="<{$smarty.const._MA_WGSIMPLEACC_MENUADMIN}>" title="<{$smarty.const._MA_WGSIMPLEACC_MENUADMIN}>"></span></a>
            <{/if}>
            <a class="wgsa-startminheader-link" href="<{$xoops_url}>/user.php"><span class="fa fa-user-o" alt="<{$smarty.const._MA_WGSIMPLEACC_MENUUSER}>" title="<{$smarty.const._MA_WGSIMPLEACC_MENUUSER}>"> <{$currentUser}></span></a>
            <a class="wgsa-startminheader-link" href="<{$xoops_url}>/notifications.php"><span class="fa fa-info-circle" alt="<{$smarty.const._MA_WGSIMPLEACC_MENUNOTIF}>" title="<{$smarty.const._MA_WGSIMPLEACC_MENUNOTIF}>"></span></a>
                <{xoInboxCount assign="unreadCount"}> <a class="wgsa-startminheader-link <{if $unreadCount > 0}>wgsa-startminheader-link-important<{/if}>" href="<{$xoops_url}>/viewpmsg.php"><span class="fa fa-envelope" alt="<{$smarty.const._MA_WGSIMPLEACC_MENUINBOX}>" title="<{$smarty.const._MA_WGSIMPLEACC_MENUINBOX}>"></span> <{if $unreadCount > 0}><span class="badge wgsa-startminheader-bagde"><{$unreadCount}></span><{/if}></a>
            <a class="wgsa-startminheader-link" href="<{$xoops_url}>/user.php?op=logout"><span class="fa fa-sign-out" alt="<{$smarty.const._LOGOUT}>" title="<{$smarty.const._LOGOUT}>"></span></a>
        <{else}>
            <a class="wgsa-startminheader-link" href="<{$xoops_url}>/user.php"><span class="fa fa-sign-in" alt="<{$smarty.const._LOGIN}>" title="<{$smarty.const._LOGIN}>"></span></a>
        <{/if}>
        </div>
    </div>
</div>

<div class="w-100"></div>

<{if $show_breadcrumbs|default:''}>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12"><{include file='db:wgsimpleacc_breadcrumbs.tpl'}></div>
        </div>
    </div>
    <div class="w-100"></div>
<{/if}>

<{if $formLogin|default:''}>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="errorMsg"><strong><{$errorPerm|default:'no permission'}></strong></div>
                <{include file='db:system_block_login.tpl'}>
            </div>
        </div>
    </div>
    <div class="w-100"></div>
<{/if}>

<{if $template_sub|default:''}>
    <div class="container-fluid">
        <div class="row">
            <div class="col-4 col-lg-2 col-xl-2 wgsa-mainnav"><{include file='db:wgsimpleacc_navbar.tpl'}></div>
            <div class="col-8 col-lg-10 col-xl-10 wgsa-maincontent">
                <{include file=$template_sub}>
                <{if $error|default:''}>
                    <div class="errorMsg"><strong><{$error}></strong></div>
                <{/if}>
                <{if $form|default:''}>
                    <{$form}>
                <{/if}>
            </div>
        </div>
    </div>
    <div class="w-100"></div>
<{/if}>

<{if $adv|default:''}>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12"><{$adv}></div>
        </div>
    </div>
<{/if}>

<{include file='db:wgsimpleacc_footer.tpl' }>
