<tr id='cliId_<{$client.cli_id}>'>
    <td><{$client.name}></td>
    <td><{$client.fulladdress}></td>
    <td><{$client.phone}></td>
    <td><{$client.vat}></td>
    <td class="center">
        <img src="<{$wgsimpleacc_icon_url_32}><{$client.cli_creditor}>.png" alt="<{$smarty.const._MA_WGSIMPLEACC_CLIENT_CREDITOR}>">
    </td>
    <td class="center">
        <img src="<{$wgsimpleacc_icon_url_32}><{$client.cli_debtor}>.png" alt="<{$smarty.const._MA_WGSIMPLEACC_CLIENT_DEBTOR}>">
    </td>
    <td class="center">
        <{if $permSubmit && $client.editable}>
        <a class='btn btn-primary right' href='clients.php?op=edit&amp;cli_id=<{$client.cli_id}><{$cliOp|default:''}>' title='<{$smarty.const._EDIT}>'><i class="fa fa-edit fa-fw"></i></a>
        <a class='btn btn-danger right' href='clients.php?op=delete&amp;cli_id=<{$client.cli_id}>' title='<{$smarty.const._DELETE}>'><i class="fa fa-trash fa-fw"></i></a>
        <{/if}>
    </td>
</tr>
