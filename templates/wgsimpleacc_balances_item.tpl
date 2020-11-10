<i id='balId_<{$balance.bal_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$balance.from}></span>
	<span class='col-sm-9 justify'><{$balance.to}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem}>
			<a class='btn btn-success right' href='balances.php?op=list&amp;#balId_<{$balance.bal_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_BALANCES_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_BALANCES_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='balances.php?op=show&amp;bal_id=<{$balance.bal_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
		<{/if}>
		<{if $permEdit}>
			<a class='btn btn-primary right' href='balances.php?op=edit&amp;bal_id=<{$balance.bal_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='balances.php?op=delete&amp;bal_id=<{$balance.bal_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
