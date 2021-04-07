<i id='cliId_<{$client.cli_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$client.name}></span>
	<span class='col-sm-9 justify'><{$client.postal}></span>
	<span class='col-sm-9 justify'><{$client.city}></span>
	<span class='col-sm-9 justify'><{$client.address}></span>
	<span class='col-sm-9 justify'><{$client.ctry}></span>
	<span class='col-sm-9 justify'><{$client.phone}></span>
	<span class='col-sm-9 justify'><{$client.vat}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem|default:''}>
			<a class='btn btn-success right' href='clients.php?op=list&amp;#cliId_<{$client.cli_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_CLIENTS_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_CLIENTS_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='clients.php?op=show&amp;cli_id=<{$client.cli_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
		<{/if}>
		<{if $permEdit|default:''}>
			<a class='btn btn-primary right' href='clients.php?op=edit&amp;cli_id=<{$client.cli_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='clients.php?op=delete&amp;cli_id=<{$client.cli_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
