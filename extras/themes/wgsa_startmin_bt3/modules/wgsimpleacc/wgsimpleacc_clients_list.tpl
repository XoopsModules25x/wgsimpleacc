<tr id='cliId_<{$client.cli_id}>'>
    <td class="wgsa-client-td"><{$client.name}></td>
    <td class="wgsa-client-td"><{$client.fulladdress}></td>
    <td class="wgsa-client-td"><{$client.phone}></td>
    <td class="wgsa-client-td"><{$client.vat}></td>
    <td class="wgsa-client-td center">
        <{if $permSubmit && $client.editable}>
            <{if $client.cli_creditor|default:0 == 1}>
                <a href="clients.php?op=change_yn&amp;field=cli_creditor&amp;value=0&amp;cli_id=<{$client.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._MA_WGSIMPLEACC_ACTIVE}>">
                    <img src="<{$wgsimpleacc_icons_url_32}>1.png" alt="<{$smarty.const._MA_WGSIMPLEACC_ACTIVE}>"></a>
            <{else}>
                <a href="clients.php?op=change_yn&amp;field=cli_creditor&amp;value=1&amp;cli_id=<{$client.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._MA_WGSIMPLEACC_NONACTIVE}>">
                    <img src="<{$wgsimpleacc_icons_url_32}>0.png" alt="<{$smarty.const._MA_WGSIMPLEACC_NONACTIVE}>"></a>
            <{/if}>
        <{else}>
            <img src="<{$wgsimpleacc_icons_url_32}><{$client.cli_creditor}>.png" alt="<{$smarty.const._MA_WGSIMPLEACC_CLIENT_CREDITOR}>">
        <{/if}>
    </td>
    <td class="wgsa-client-td center">
        <{if $permSubmit && $client.editable}>
            <{if $client.cli_debtor|default:0 == 1}>
            <a href="clients.php?op=change_yn&amp;field=cli_debtor&amp;value=0&amp;cli_id=<{$client.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._MA_WGSIMPLEACC_ACTIVE}>">
                <img src="<{$wgsimpleacc_icons_url_32}>1.png" alt="<{$smarty.const._MA_WGSIMPLEACC_ACTIVE}>"></a>
            <{else}>
            <a href="clients.php?op=change_yn&amp;field=cli_debtor&amp;value=1&amp;cli_id=<{$client.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._MA_WGSIMPLEACC_NONACTIVE}>">
                <img src="<{$wgsimpleacc_icons_url_32}>0.png" alt="<{$smarty.const._MA_WGSIMPLEACC_NONACTIVE}>"></a>
            <{/if}>
        <{else}>
            <img src="<{$wgsimpleacc_icons_url_32}><{$client.cli_debtor}>.png" alt="<{$smarty.const._MA_WGSIMPLEACC_CLIENT_DEBTOR}>">
        <{/if}>
    </td>
    <td class="wgsa-client-td center">
        <{if $permSubmit && $client.editable}>
        <{if $client.cli_online|default:0 == 1}>
        <a href="clients.php?op=change_yn&amp;field=cli_online&amp;value=0&amp;cli_id=<{$client.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._MA_WGSIMPLEACC_ACTIVE}>">
            <img src="<{$wgsimpleacc_icons_url_32}>1.png" alt="<{$smarty.const._MA_WGSIMPLEACC_ACTIVE}>"></a>
        <{else}>
        <a href="clients.php?op=change_yn&amp;field=cli_online&amp;value=1&amp;cli_id=<{$client.id}>&amp;start=<{$start}>&amp;limit=<{$limit}>" title="<{$smarty.const._MA_WGSIMPLEACC_NONACTIVE}>">
            <img src="<{$wgsimpleacc_icons_url_32}>0.png" alt="<{$smarty.const._MA_WGSIMPLEACC_NONACTIVE}>"></a>
        <{/if}>
        <{else}>
    <img src="<{$wgsimpleacc_icons_url_32}><{$client.cli_creditor}>.png" alt="<{$smarty.const._MA_WGSIMPLEACC_CLIENT_CREDITOR}>">
        <{/if}>
    </td>
    <td class="wgsa-client-td center">
        <a class='btn btn-success right' href='clients.php?op=show&amp;cli_id=<{$client.cli_id}><{$cliOp|default:''}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><i class="fa fa-search fa-fw"></i></a>
        <{if $permSubmit && $client.editable}>
            <a class='btn btn-primary right' href='clients.php?op=edit&amp;cli_id=<{$client.cli_id}><{$cliOp|default:''}>' title='<{$smarty.const._EDIT}>'><i class="fa fa-edit fa-fw"></i></a>
            <{if $client.deletable}>
                <a class='btn btn-danger right' href='clients.php?op=delete&amp;cli_id=<{$client.cli_id}>' title='<{$smarty.const._DELETE}>'><i class="fa fa-trash fa-fw"></i></a>
            <{else}>
                <a class="btn btn-default wgsa-btn-list" href="transactions.php?op=list&amp;displayfilter=1&amp;cli_id=<{$client.id}>" title="<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}>"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS}></a>
            <{/if}>
        <{/if}>
    </td>
</tr>
