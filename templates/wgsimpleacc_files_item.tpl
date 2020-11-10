<i id='filId_<{$file.fil_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
	<span class='col-sm-9 justify'><{$file.traid}></span>
	<span class='col-sm-9 justify'><{$file.name}></span>
	<span class='col-sm-9 justify'><{$file.type}></span>
	<span class='col-sm-9 justify'><{$file.desc}></span>
	<span class='col-sm-9 justify'><{$file.datecreated}></span>
	<span class='col-sm-9 justify'><{$file.submitter}></span>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
		<{if $showItem}>
			<a class='btn btn-success right' href='files.php?op=list&amp;#filId_<{$file.fil_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_FILES_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_FILES_LIST}></a>
		<{else}>
			<a class='btn btn-success right' href='files.php?op=show&amp;fil_id=<{$file.fil_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
		<{/if}>
		<{if $permEdit}>
			<a class='btn btn-primary right' href='files.php?op=edit&amp;fil_id=<{$file.fil_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='files.php?op=delete&amp;fil_id=<{$file.fil_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
