<i id='filId_<{$file.fil_id}>'></i>
<div class='panel-heading'>
</div>
<div class='panel-body'>
    <{foreach item=file from=$files}>                              
        <span class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_FILE_TRAID}></span><span class='col-sm-9 left'><{$file.traid}></span>
        <span class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_FILE_NAME}></span><span class='col-sm-9 left'><{$file.name}></span>
        <span class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_FILE_TYPE}></span><span class='col-sm-9 left'><{$file.type}></span>
        <{if $file.image}>
            <span class='col-sm-3 left'></span><span class='col-sm-9 left'><img class="img-responsive" src="<{$wgsimpleacc_upload_files_url}>/<{$file.name}>" alt="<{$file.name}>" title="<{$file.name}>"></span>
        <{/if}>
        <span class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_FILE_DESC}></span><span class='col-sm-9 left'><{$file.desc}></span>
        <span class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></span><span class='col-sm-9 left'><{$file.datecreated}></span>
        <span class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></span><span class='col-sm-9 left'><{$file.submitter}></span>
        
    <{/foreach}>
</div>
<div class='panel-foot'>
	<div class='col-sm-12 right'>
        <a class='btn btn-success right' href='files.php?op=list&amp;fil_traid=<{$file.fil_traid}>' title='<{$smarty.const._MA_WGSIMPLEACC_FILES_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_FILES_LIST}></a>
		<{if $permEdit}>
			<a class='btn btn-primary right' href='files.php?op=edit&amp;fil_id=<{$file.fil_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
			<a class='btn btn-danger right' href='files.php?op=delete&amp;fil_id=<{$file.fil_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
		<{/if}>
	</div>
</div>
