<i id='filId_<{$file.fil_id}>'></i>
<h3><{$smarty.const._MA_WGSIMPLEACC_FILE_DETAILS}></h3>
<div class='panel-body'>
    <{foreach item=file from=$files}>                              
        <div class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_FILE_TRAID}></div><div class='col-sm-9'><{$file.traid}></div>
        <div class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_FILE_NAME}></div><div class='col-sm-9'><{$file.name}></div>
        <div class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_FILE_TYPE}></div><div class='col-sm-9'><{$file.type}></div>
        <{if $file.image}>
            <div class='col-sm-3 left'></div><div class='col-sm-9 left'><img class="img-responsive" src="<{$wgsimpleacc_upload_files_url}>/<{$file.name}>" alt="<{$file.name}>" title="<{$file.name}>"></div>
        <{/if}>
        <div class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_FILE_DESC}></div><div class='col-sm-9'><{$file.desc}>&nbsp;</div>
        <div class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></div><div class='col-sm-9'><{$file.datecreated}></div>
        <div class='col-sm-3 left'><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></div><div class='col-sm-9'><{$file.submitter}></div>
        
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
