<!doctype html>
<html lang="<{$xoops_langcode}>">
<head>
<{assign var=theme_name value=$xoTheme->folderName}>
    <meta charset="<{$xoops_charset}>">
    <meta name="keywords" content="<{$xoops_meta_keywords}>">
    <meta name="description" content="<{$xoops_meta_description}>">
    <meta name="robots" content="<{$xoops_meta_robots}>">
    <meta name="rating" content="<{$xoops_meta_rating}>">
    <meta name="author" content="<{$xoops_meta_author}>">
    <meta name="copyright" content="<{$xoops_meta_copyright}>">
    <meta name="generator" content="XOOPS">
    <!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="<{$xoops_url}>/favicon.ico" rel="shortcut icon">

    <link rel="stylesheet" type="text/css" href="<{xoImgUrl}>css/xoops.css">
    <link rel="stylesheet" type="text/css" href="<{xoImgUrl}>css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<{xoImgUrl}>css/cookieconsent.css">

    <script src="<{$xoops_url}>/browse.php?Frameworks/jquery/jquery.js"></script>
    <script src="<{xoImgUrl}>js/bootstrap.bundle.min.js"></script>
    <{include file="$theme_name/tpl/cookieConsent.tpl"}>
    <{if !empty($xoops_isadmin)}>
    <script src="<{xoImgUrl}>js/js.cookie.min.js"></script>
    <{/if}>
    <link rel="alternate" type="application/rss+xml" title="" href="<{xoAppUrl 'backend.php'}>">

    <title><{if $xoops_dirname == "system"}><{$xoops_sitename}><{if $xoops_pagetitle !=''}> - <{$xoops_pagetitle}><{/if}><{else}><{if $xoops_pagetitle !=''}><{$xoops_pagetitle}> - <{$xoops_sitename}><{/if}><{/if}></title>

<{$xoops_module_header}>
    <link rel="stylesheet" type="text/css" media="all" href="<{$xoops_themecss}>">
</head>

<body id="<{$xoops_dirname}>">

<{* un-comment to enable navbar top
<{include file="$theme_name/tpl/nav-menu.tpl"}>
*}>

<{* un-comment to enable slider
<{if $xoops_page == "index"}>
    <{include file="$theme_name/tpl/slider.tpl"}>
<{/if}>
*}>

<div class="container-fluid maincontainer">

<{* un-comment to enable jumbotron
<{if $xoops_page == "index"}>
    <{include file="$theme_name/tpl/jumbotron.tpl"}>
<{/if}>
*}>

<div class="container-fluid">
    <div class="row">
        <{include file="$theme_name/tpl/leftBlock.tpl"}>
        <{include file="$theme_name/tpl/rightBlock.tpl"}>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <{include file="$theme_name/tpl/centerBlock.tpl"}>
        <{include file="$theme_name/tpl/centerLeft.tpl"}>
        <{include file="$theme_name/tpl/centerRight.tpl"}>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <{if $xoops_contents|default:false}>
            <{$xoops_contents}>
        <{/if}>
    </div>
</div>

</div><!-- .maincontainer -->

<{if $xoBlocks.page_bottomcenter || $xoBlocks.page_bottomright || $xoBlocks.page_bottomleft}>
    <div class="bottom-blocks">
        <div class="container-fluid">
            <{if $xoBlocks.page_bottomcenter}>
            <div class="row">
                <{include file="$theme_name/tpl/centerBottom.tpl"}>
            </div>
            <{/if}>
            <{if $xoBlocks.page_bottomright || $xoBlocks.page_bottomleft}>
            <div class="row">
                <{include file="$theme_name/tpl/leftBottom.tpl"}>

                <{include file="$theme_name/tpl/rightBottom.tpl"}>
            </div>
        </div>
        <{/if}>
    </div><!-- .bottom-blocks -->
<{/if}>

<{if $xoBlocks.footer_center || $xoBlocks.footer_right || $xoBlocks.footer_left}>
    <div class="footer-blocks">
        <div class="container-fluid">
            <div class="row">
                <{include file="$theme_name/tpl/leftFooter.tpl"}>

                <{include file="$theme_name/tpl/centerFooter.tpl"}>

                <{include file="$theme_name/tpl/rightFooter.tpl"}>
            </div>
        </div>
    </div><!-- .footer-blocks -->
<{/if}>

<footer class="footer">
    <h3>
        <{$xoops_footer}>
        <a href="http://xoops.org" title="Design by: XOOPS UI/UX Team" target="_blank" class="credits d-none d-sm-block">
            <img src="<{xoImgUrl}>images/favicon.png" alt="Design by: XOOPS UI/UX Team">
        </a>
    </h3>
</footer>
<div class="aligncenter comments-nav d-block d-sm-none">
    <a href="http://xoops.org" title="Design by: XOOPS UI/UX Team" target="_blank">
        <img src="<{xoImgUrl}>images/favicon.png" alt="Design by: XOOPS UI/UX Team">
    </a>
</div>
</body>
</html>
