<tr id='asId_<{$asset.as_id}>'>
    <td><{$asset.name}></td>
    <td><{$asset.reference}></td>
    <td><{$asset.descr}></td>
    <td><div style="width:50px;background-color:<{$asset.color}>">&nbsp;</div></td>
    <td class="center">
        <{if $asset.as_primary}>
            <img src="<{$wgsimpleacc_icons_url_16}><{$asset.as_primary}>.png" alt="<{$smarty.const._MA_WGSIMPLEACC_ASSET_PRIMARY}>">
        <{/if}>
    </td>
    <{if $permSubmit}>
        <td class="center">
            <{if $asset.as_iecalc|default:0 == 1}>
                <img src="<{$wgsimpleacc_icons_url_32}>/1.png" alt="<{$asset.iecalc}>">
            <{else}>
                <img src="<{$wgsimpleacc_icons_url_32}>/0.png" alt="<{$asset.iecalc}>">
            <{/if}>
        </td>
        <td class="center">
            <{if $asset.as_online|default:0 == 1}>
                <img src="<{$wgsimpleacc_icons_url_32}>/1.png" alt="<{$asset.online}>">
            <{else}>
                <img src="<{$wgsimpleacc_icons_url_32}>/0.png" alt="<{$asset.online}>">
            <{/if}>
        </td>
    <{/if}>
    <td>
        <{if $permSubmit}>
            <a class='btn btn-primary right' href='assets.php?op=edit&amp;as_id=<{$asset.as_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
            <a class='btn btn-danger right' href='assets.php?op=delete&amp;as_id=<{$asset.as_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
        <{/if}>
        <a class="btn btn-secondary wgsa-btn-list" href="transactions.php?op=list&displayfilter=1&amp;as_id=<{$asset.as_id}>&amp;dateFrom=<{$dateFrom}>&amp;dateTo=<{$dateTo}>" title='<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}>'><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}></a>
    </td>
</tr>