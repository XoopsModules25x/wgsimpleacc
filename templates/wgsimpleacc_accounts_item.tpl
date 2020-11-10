<i id='accId_<{$account.acc_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$account.key}></span>
	<span class='col-sm-9 justify'><{$account.desc}></span>
	<span class='col-sm-9 justify'><{$account.pid}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem}>
			<a class='btn btn-success right' href='accounts.php?op=list&amp;#accId_<{$account.acc_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_ACCOUNTS_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='accounts.php?op=show&amp;acc_id=<{$account.acc_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
		<{/if}>
		<{if $permEdit}>
			<a class='btn btn-primary right' href='accounts.php?op=edit&amp;acc_id=<{$account.acc_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='accounts.php?op=delete&amp;acc_id=<{$account.acc_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
		<a class='btn btn-warning right' href='accounts.php?op=broken&amp;acc_id=<{$account.acc_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_BROKEN}>'><{$smarty.const._MA_WGSIMPLEACC_BROKEN}></a>
	</div>
</div>
