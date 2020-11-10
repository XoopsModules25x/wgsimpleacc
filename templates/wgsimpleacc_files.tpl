<h3><{$header_fileslist}></h3>
<{if $formFilesUpload}>
    <div id='filehandler' class='col-xs-12 col-sm-12'>
        <ul class='nav nav-tabs'>
            <li class='active'><a id='navtab_main' href='#1' data-toggle='tab'><{$smarty.const._MA_WGSIMPLEACC_FILES_CURRENT}></a></li>
            <li><a id='navtab_upload_file' href='#2' data-toggle='tab'><{$smarty.const._MA_WGSIMPLEACC_FILES_UPLOAD}></a></li>
            <{if $upload_by_app}>
                <li><a id='navtab_upload_temp' href='#3' data-toggle='tab'><{$smarty.const._MA_WGSIMPLEACC_FILES_TEMP}></a></li>
            <{/if}>
        </ul>
        <div class='tab-content '>
            <!-- *************** Basic Tab ***************-->
            <div class='tab-pane active center' id='1'>
                <{if $filesCount > 0}>
                    <div class='table-responsive'>
                        <table class='table table-striped'>
                            <thead>
                                <tr>
                                    <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_FILE_NAME}></th>
                                    <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_FILE_DESC}></th>
                                    <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_FILE_TYPE}></th>
                                    <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_FILE_PREVIEW}></th>
                                    <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                                    <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <{foreach item=file from=$files}>
                                <{include file='db:wgsimpleacc_files_list.tpl' }>
                                <{/foreach}>
                            </tbody>
                        </table>
                    </div>
                <{else}>
                    <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_FILES}>
                <{/if}>
                <a class='btn btn-danger right' href='transactions.php?op=list&amp;start=<{$start}>&amp;limit=<{$limit}>' title='<{$smarty.const._CANCEL}>'><{$smarty.const._CANCEL}></a>
            </div>
            <!-- *************** Tab for upload files ***************-->
            <div class='tab-pane' id='2'>
                <{if $formFilesUpload}>
                    <{$formFilesUpload}>
                <{/if}>
            </div>
            <{if $upload_by_app}>
                <!-- ***************Tab for select uploaded files ***************-->
                <div class='tab-pane' id='3' >
                    <{if $formFilesTemp}>
                        <{$formFilesTemp}>
                    <{/if}>
                </div>
            <{/if}>
        </div>
    </div>
<{/if}>
<{if $formFilesEdit}>
    <{$formFilesEdit}>
<{/if}>
