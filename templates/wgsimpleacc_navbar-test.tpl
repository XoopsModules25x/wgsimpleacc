<!-- Navigation Startmin Theme-->
<{if $permGlobalView}>
    <nav class="navbar" role="navigation">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <form class="navbar-form" role="search" action="<{xoAppUrl search.php}>" method="get">
                            <div class="form-group">
                                <input type="text" name="query" style='width:75%' class="form-control" placeholder="<{$smarty.const.THEME_SEARCH_TEXT}>"><button class="btn btn-primary" type="submit"><i class="fa fa-search fa-fw"></i></button>
                                <input type="hidden" name="action" value="results">
                            </div>
                        </form>
                    </li>
                    <{foreach item=nav_item1 from=$nav_items1}>
                    <li>
                        <a href="<{$nav_item1.href}>" class="<{$nav_item1.aclass}>"><{$nav_item1.icon}> <{$nav_item1.label}></a>
                        <{if $nav_item1.sub_items2}>
                            <ul class="nav nav-second-level">
                                <{foreach item=sub_item2 from=$nav_item1.sub_items2}>
                                    <li>
                                        <a href="<{$sub_item2.href}>" class="<{$sub_item2.aclass}>"><{$sub_item2.icon}> <{$sub_item2.label}></a>
                                        <{if $sub_item2.sub_items3}>
                                            <ul class="nav nav-second-level">
                                                <{foreach item=sub_item3 from=$sub_item2.sub_items3}>
                                                    <li>
                                                        <a href="<{$sub_item3.href}>" class="<{$sub_item3.aclass}>"><{$sub_item3.icon}> <{$sub_item3.label}></a>
                                                    </li>
                                                <{/foreach}>
                                            </ul>
                                        <{/if}>
                                    </li>
                                <{/foreach}>
                            </ul>
                        <{/if}>
                    </li>
                    <{/foreach}>
                </ul>
            </div>
        </div>
    </nav>
<{/if}>
