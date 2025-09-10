<{foreach item=listitem from=$list_collapsible name=listitem}>
    <{if $listitem.childs|default:0 > 0}>
        <div href="#item-<{$listitem.id}>" class="list-group-item" data-bs-toggle="collapse">
            <span class="collapseme">
                <i class="fa fa-chevron-right"></i>
                <{if $listitem.color|default:false}>
                    <span style="background-color:<{$listitem.color}>">&nbsp;&nbsp;&nbsp;</span>
                <{/if}>
                <{$listitem.name}>
            </span>
            <span class="pull-right">
                <{if $listitem.income|default:false}>
                    <img class="wgsa-img" src="<{$wgsimpleacc_icon_url}>/32/incomes.png" title="<{$smarty.const._MA_WGSIMPLEACC_CLASS_INCOME}>" alt="<{$smarty.const._MA_WGSIMPLEACC_CLASS_INCOME}>">
                <{/if}>
                <{if $listitem.expenses|default:false}>
                    <img class="wgsa-img" src="<{$wgsimpleacc_icon_url}>/32/expenses.png" title="<{$smarty.const._MA_WGSIMPLEACC_CLASS_EXPENSES}>" alt="<{$smarty.const._MA_WGSIMPLEACC_CLASS_EXPENSES}>">
                <{/if}>
                <img class="wgsa-img-online" src="<{$wgsimpleacc_icon_url}>/32/<{$listitem.online}>.png" title="<{$listitem.online_text}>" alt="<{$listitem.online_text}>">
                <button class="btn btn btn-outline-primary wgsa-btn-list<{if $listitem.tracount == 0}> disabled<{/if}>"
                        onclick="location.href='transactions.php?op=list&displayfilter=1&amp;acc_id=<{$listitem.id}>&amp;dateFrom=<{$dateFrom}>&amp;dateTo=<{$dateTo}>'" target="_blank" type="button">( <{$listitem.tracount}> ) <{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}></button>
                <button class="btn btn btn-primary wgsa-btn-list"
                        onclick="location.href='accounts.php?op=edit&amp;acc_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._EDIT}></button>
                <button class="btn btn btn-danger wgsa-btn-list<{if $listitem.tracount > 0 || $listitem.childs > 0}> disabled<{/if}>"
                        onclick="location.href='accounts.php?op=delete&amp;acc_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._DELETE}></button>
                <button class="btn btn btn-primary wgsa-btn-list"
                        onclick="location.href='accounts.php?op=new&amp;acc_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._ADD}></button>
            </span>
        </div>
        <div class="list-group collapse" id="item-<{$listitem.id}>">
            <{include file='db:wgsimpleacc_accounts_listcoll.tpl' list_collapsible=$listitem.child}>
        </div>
    <{else}>
        <div href="#item-<{$listitem.id}>" class="list-group-item" data-bs-toggle="collapse">
            <span class="collapseme">
                <{if $listitem.color|default:false}>
                    <span style="background-color:<{$listitem.color}>">&nbsp;&nbsp;&nbsp;</span>
                <{/if}>
                <{$listitem.name}>
            </span>
            <span class="pull-right">
                <{if $listitem.income|default:false}>
                    <img class="wgsa-img" src="<{$wgsimpleacc_icon_url}>/32/incomes.png" title="<{$smarty.const._MA_WGSIMPLEACC_CLASS_INCOME}>" alt="<{$smarty.const._MA_WGSIMPLEACC_CLASS_INCOME}>">
                <{/if}>
                <{if $listitem.expenses|default:false}>
                    <img class="wgsa-img" src="<{$wgsimpleacc_icon_url}>/32/expenses.png" title="<{$smarty.const._MA_WGSIMPLEACC_CLASS_EXPENSES}>" alt="<{$smarty.const._MA_WGSIMPLEACC_CLASS_EXPENSES}>">
                <{/if}>
                <img class="wgsa-img-online" src="<{$wgsimpleacc_icon_url}>/32/<{$listitem.online}>.png" title="<{$listitem.online_text}>" alt="<{$listitem.online_text}>">
                <button class="btn btn btn-outline-primary wgsa-btn-list<{if $listitem.tracount == 0}> disabled<{/if}>"
                        onclick="location.href='transactions.php?op=list&displayfilter=1&amp;acc_id=<{$listitem.id}>&amp;dateFrom=<{$dateFrom}>&amp;dateTo=<{$dateTo}>'" target="_blank" type="button">( <{$listitem.tracount}> ) <{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}></button>
                <button class="btn btn btn-primary wgsa-btn-list"
                        onclick="location.href='accounts.php?op=edit&amp;acc_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._EDIT}></button>
                <button class="btn btn btn-danger wgsa-btn-list<{if $listitem.tracount > 0 || $listitem.childs > 0}> disabled<{/if}>"
                        onclick="location.href='accounts.php?op=delete&amp;acc_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._DELETE}></button>
                <button class="btn btn btn-primary wgsa-btn-list"
                        onclick="location.href='accounts.php?op=new&amp;acc_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._ADD}></button>
            </span></div>
    <{/if}>
<{/foreach}>
