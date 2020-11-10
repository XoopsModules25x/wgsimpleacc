<i id='claId_<{$classification.cla_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$classification.pid}></span>
	<span class='col-sm-9 justify'><{$classification.name}></span>
	<span class='col-sm-9 justify'><{$classification.status}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem}>
			<a class='btn btn-success right' href='classifications.php?op=list&amp;#claId_<{$classification.cla_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_CLASSIFICATIONS_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_CLASSIFICATIONS_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='classifications.php?op=show&amp;cla_id=<{$classification.cla_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
		<{/if}>
		<{if $permEdit}>
			<a class='btn btn-primary right' href='classifications.php?op=edit&amp;cla_id=<{$classification.cla_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='classifications.php?op=delete&amp;cla_id=<{$classification.cla_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
		<a class='btn btn-warning right' href='classifications.php?op=broken&amp;cla_id=<{$classification.cla_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_BROKEN}>'><{$smarty.const._MA_WGSIMPLEACC_BROKEN}></a>
	</div>
</div>
