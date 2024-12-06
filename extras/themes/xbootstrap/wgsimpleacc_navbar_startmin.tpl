<!-- Navigation Startmin Theme-->
<{if $permGlobalView|default:false}>
    <nav class="navbar wgsa-navbar" role="navigation">
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <form class="navbar-form" role="search" action="<{xoAppUrl 'search.php'}>" method="get">
                            <div class="form-group">
                                <input type="text" name="query" style='width:75%' class="form-control" placeholder="<{$smarty.const.THEME_SEARCH_TEXT}>"><button class="btn btn-primary" type="submit"><i class="fa fa-search fa-fw"></i></button>
                                <input type="hidden" name="action" value="results">
                            </div>
                        </form>
                    </li>
                    <{foreach item=nav_item1 from=$nav_items1}>
                    <li style="width:100%">
                        <a href="<{$nav_item1.href|default:''}>" class="<{$nav_item1.aclass|default:''}>"><{$nav_item1.icon|default:''}> <{$nav_item1.label|default:''}>
                            <{if $nav_item1.sub_items2|default:false}><span class="fa arrow"></span><{/if}></a>
                        <{if $nav_item1.sub_items2|default:false}>
                            <ul class="nav nav-second-level">
                                <{foreach item=sub_item2 from=$nav_item1.sub_items2}>
                                    <li style="width:100%">
                                        <a href="<{$sub_item2.href|default:''}>" class="<{$sub_item2.aclass|default:''}>"><{$sub_item2.icon|default:''}> <{$sub_item2.label|default:''}>
                                            <{if $sub_item2.sub_items3|default:false}><span class="fa arrow"></span><{/if}></a>
                                        <{if $sub_item2.sub_items3|default:false}>
                                            <ul class="nav nav-third-level">
                                                <{foreach item=sub_item3 from=$sub_item2.sub_items3}>
                                                    <li style="width:100%">
                                                        <a href="<{$sub_item3.href|default:''}>" class="<{$sub_item3.aclass|default:''}>"><{$sub_item3.icon|default:''}> <{$sub_item3.label|default:''}></a>
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
