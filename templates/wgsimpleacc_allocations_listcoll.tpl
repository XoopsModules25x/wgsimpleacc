<{foreach item=listitem from=$list_collapsible name=listitem}>
    <{if $listitem.childs|default:0 > 0}>
        <div href="#item-<{$listitem.id}>" class="list-group-item" data-bs-toggle="collapse">
            <span class="collapseme"><i class="fa fa-chevron-right"></i><{$listitem.name}></span>
            <span class="pull-right">
                <img class="wgsa-img-online" src="<{$wgsimpleacc_icon_url}>/32/<{$listitem.online}>.png" title="<{$listitem.online_text}>" alt="<{$listitem.online_text}>">
                <button class="btn btn btn-outline-primary wgsa-btn-list<{if $listitem.tracount == 0}> disabled<{/if}>"
                        onclick="location.href='transactions.php?op=list&displayfilter=1&amp;all_id=<{$listitem.id}>&amp;dateFrom=<{$dateFrom}>&amp;dateTo=<{$dateTo}>'" target="_blank" type="button">( <{$listitem.tracount}> ) <{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}></button>
                <button class="btn btn btn-primary wgsa-btn-list"
                        onclick="location.href='allocations.php?op=edit&amp;all_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._EDIT}></button>
                <button class="btn btn btn-danger wgsa-btn-list<{if $listitem.tracount > 0 || $listitem.childs > 0}> disabled<{/if}>"
                        onclick="location.href='allocations.php?op=delete&amp;all_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._DELETE}></button>
                <button class="btn btn btn-primary wgsa-btn-list"
                        onclick="location.href='allocations.php?op=new&amp;all_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._ADD}></button>
            </span>
        </div>
        <div class="list-group collapse" id="item-<{$listitem.id}>">
            <{include file='db:wgsimpleacc_allocations_listcoll.tpl' list_collapsible=$listitem.child}>
        </div>
    <{else}>
        <div href="#item-<{$listitem.id}>" class="list-group-item" data-bs-toggle="collapse">
            <span class="collapseme"><{$listitem.name}></span>
            <span class="pull-right">
                <img class="wgsa-img-online" src="<{$wgsimpleacc_icon_url}>/32/<{$listitem.online}>.png" title="<{$listitem.online_text}>" alt="<{$listitem.online_text}>">
                <button class="btn btn btn-outline-primary wgsa-btn-list<{if $listitem.tracount == 0}> disabled<{/if}>"
                        onclick="location.href='transactions.php?op=list&displayfilter=1&amp;all_id=<{$listitem.id}>&amp;dateFrom=<{$dateFrom}>&amp;dateTo=<{$dateTo}>'" target="_blank" type="button">( <{$listitem.tracount}> ) <{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}></button>
                <button class="btn btn btn-primary wgsa-btn-list"
                        onclick="location.href='allocations.php?op=edit&amp;all_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._EDIT}></button>
                <button class="btn btn btn-danger wgsa-btn-list<{if $listitem.tracount > 0 || $listitem.childs > 0}> disabled<{/if}>"
                        onclick="location.href='allocations.php?op=delete&amp;all_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._DELETE}></button>
                <button class="btn btn btn-primary wgsa-btn-list"
                        onclick="location.href='allocations.php?op=new&amp;all_id=<{$listitem.id}>'" target="_blank" type="button"><{$smarty.const._ADD}></button>
            </span></div>
    <{/if}>
<{/foreach}>
