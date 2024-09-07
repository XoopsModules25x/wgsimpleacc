<!-- Navigation Startmin Theme-->
<{if $permGlobalView|default:false}>
    <nav class="navbar wgsa-navbar" role="navigation">
        <div class="navbar-default" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <{foreach item=nav_item1 from=$block}>
                    <li style="width:100%">
                        <a href="<{$wgsimpleacc_url}>/<{$nav_item1.href|default:''}>" class="<{$nav_item1.aclass|default:''}>"><{$nav_item1.icon|default:''}> <{$nav_item1.label|default:''}>
                            <{if $nav_item1.sub_items2|default:false}><span class="fa arrow"></span><{/if}></a>
                        <{if $nav_item1.sub_items2|default:false}>
                        <ul class="nav nav-second-level">
                            <{foreach item=sub_item2 from=$nav_item1.sub_items2}>
                            <li style="width:100%">
                                <a href="<{$wgsimpleacc_url}>/<{$sub_item2.href|default:''}>" class="<{$sub_item2.aclass|default:''}>"><{$sub_item2.icon|default:''}> <{$sub_item2.label|default:''}>
                                    <{if $sub_item2.sub_items3|default:false}><span class="fa arrow"></span><{/if}></a>
                                <{if $sub_item2.sub_items3|default:false}>
                                <ul class="nav nav-third-level">
                                    <{foreach item=sub_item3 from=$sub_item2.sub_items3}>
                                    <li style="width:100%">
                                        <a href="<{$wgsimpleacc_url}>/<{$sub_item3.href|default:''}>" class="<{$sub_item3.aclass|default:''}>"><{$sub_item3.icon|default:''}> <{$sub_item3.label|default:''}></a>
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
