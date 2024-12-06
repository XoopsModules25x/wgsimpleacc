<i id='cliId_<{$client.cli_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_NAME}></div><div class='col-sm-10'><{$client.name|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_POSTAL}></div><div class='col-sm-10'><{$client.postal|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_CITY}></div><div class='col-sm-10'><{$client.city|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_ADDRESS}></div><div class='col-sm-10'><{$client.address|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_CTRY}></div><div class='col-sm-10'><{$client.ctry|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_PHONE}></div><div class='col-sm-10'><{$client.phone|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_VAT}></div><div class='col-sm-10'><{$client.vat|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_CREDITOR}></div><div class='col-sm-10'><{$client.creditor|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_DEBTOR}></div><div class='col-sm-10'><{$client.debtor|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_CLIENT_ONLINE}></div><div class='col-sm-10'><{$client.online|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></div><div class='col-sm-10'><{$client.datecreated|default:' '}></div><div class='clear'></div>
    <div class='col-sm-2'><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></div><div class='col-sm-10'><{$client.submitter|default:' '}></div><div class='clear'></div>
</div>
<div class='panel-foot'>
    <div class='col-sm-12 right'>
        <a class='btn btn-success right' href='clients.php?op=list<{$cliOp|default:''}>' title='<{$smarty.const._MA_WGSIMPLEACC_CLIENTS_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_CLIENTS_LIST}></a>
        <{if $client.editable|default:''}>
            <a class='btn btn-primary right' href='clients.php?op=edit&amp;cli_id=<{$client.cli_id}><{$cliOp|default:''}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
            <a class='btn btn-danger right' href='clients.php?op=delete&amp;cli_id=<{$client.cli_id}><{$cliOp|default:''}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
        <{/if}>
    </div>
</div>
