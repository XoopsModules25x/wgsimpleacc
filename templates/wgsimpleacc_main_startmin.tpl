<{include file='db:wgsimpleacc_header.tpl' }>

<div class="container-fluid">
	<div class="row wgsa-content">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="col-sm-4 col-md-4 col-lg-2 col-xl-2">
                <div class=""><a class="navbar-brand" href="index.php">wgSimpleAcc</a></div>
            </div>
            <div class="col-sm-8 col-md-8 col-lg-10 col-xl-10">
                <{if $indexHeader|default:''}><h3 class="pull-left"><{$indexHeader}></h3><{/if}>
                <div class="pull-right">
                    <{if $xoops_isuser|default:false}>
                        <{if $xoops_isadmin|default:false}>
                            <a class="wgsa-startminheader-link" href="<{$xoops_url}>/admin.php"><span class="glyphicon glyphicon-wrench" alt="<{$smarty.const._MA_WGSIMPLEACC_MENUADMIN}>" title="<{$smarty.const._MA_WGSIMPLEACC_MENUADMIN}>"></span></a>
                        <{/if}>
                        <a class="wgsa-startminheader-link" href="<{$xoops_url}>/user.php"><span class="glyphicon glyphicon-user" alt="<{$smarty.const._MA_WGSIMPLEACC_MENUUSER}>" title="<{$smarty.const._MA_WGSIMPLEACC_MENUUSER}>"> <{$currentUser}></span></a>
                        <a class="wgsa-startminheader-link" href="<{$xoops_url}>/notifications.php"><span class="glyphicon glyphicon-info-sign" alt="<{$smarty.const._MA_WGSIMPLEACC_MENUNOTIF}>" title="<{$smarty.const._MA_WGSIMPLEACC_MENUNOTIF}>"></span></a>
                        <{xoInboxCount assign="unreadCount"}> <a class="wgsa-startminheader-link <{if $unreadCount > 0}>wgsa-startminheader-link-important<{/if}>" href="<{$xoops_url}>/viewpmsg.php"><span class="glyphicon glyphicon-envelope" alt="<{$smarty.const._MA_WGSIMPLEACC_MENUINBOX}>" title="<{$smarty.const._MA_WGSIMPLEACC_MENUINBOX}>"></span> <{if $unreadCount > 0}><span class="badge wgsa-startminheader-bagde"><{$unreadCount}></span><{/if}></a>
                        <a class="wgsa-startminheader-link" href="<{$xoops_url}>/user.php?op=logout"><span class="glyphicon glyphicon-off" alt="<{$smarty.const._LOGOUT}>" title="<{$smarty.const._LOGOUT}>"></span></a>
                    <{else}>
                        <a href="<{$xoops_url}>/user.php?xoops_redirect=<{$xoops_requesturi}>"><span class="glyphicon glyphicon-on" alt="<{$smarty.const._LOGIN}>" title="<{$smarty.const._LOGIN}>"></span></a>
                    <{/if}>
                </div>
            </div>
        </div>
        <div class="clear"></div>
		<div class="col-sm-4 col-md-4 col-lg-2 col-xl-2"><{include file='db:wgsimpleacc_navbar.tpl'}></div>
		<div class="col-sm-8 col-md-8 col-lg-10 col-xl-10">
            <{include file=$template_sub}>
            <{if $form|default:''}>
				<{$form}>
			<{/if}>
			<{if $error|default:''}>
				<{$error}>
			<{/if}>
        </div>
	</div>
	<{if $adv|default:''}>
        <div class="row">
            <div class="col-sm-12"><{$adv}></div>
        </div>
	<{/if}>
</div>

<{include file='db:wgsimpleacc_footer.tpl' }>
