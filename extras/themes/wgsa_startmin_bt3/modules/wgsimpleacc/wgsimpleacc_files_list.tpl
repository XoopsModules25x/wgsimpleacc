<tr>
    <td scope="col"><{$file.name}></td>
    <td scope="col"><{$file.desc}></td>
    <td scope="col"><{$file.type}></td>
    <td scope="col">
        <{if $file.image}>
            <img class="wgsa-files-preview" src="<{$wgsimpleacc_upload_files_url}>/<{$file.name}>" alt="<{$file.name}>" title="<{$file.name}>">
        <{/if}>
    </td>
    <td scope="col"><{$file.datecreated}></td>
    <td scope="col"><{$file.submitter}></td>
    <td scope="col">
        <{if $file.image}>
            <a class='btn btn-secondary' href='#' data-toggle="modal" data-target="#imgModal" data-title="<{$file.name}>" data-info="<{$wgsimpleacc_upload_files_url}>/<{$file.name}>" title='<{$file.name}>'><i class="fa fa-eye fa-fw"></i></a>
        <{elseif $file.pdf}>
            <a class='btn btn-secondary' href='#' data-toggle="modal" data-target="#pdfModal" data-title="<{$file.name}>" data-info="<{$wgsimpleacc_upload_files_url}>/<{$file.name}>" title='<{$file.name}>'><i class="fa fa-eye fa-fw"></i></a>
        <{else}>
            <a class='btn btn-secondary' href='files.php?op=showfile&amp;fil_id=<{$file.id}><{$traOp}>' target="_blank" title='<{$file.name}>'><i class="fa fa-download fa-fw"></i></a>
        <{/if}>
        <a class='btn btn-success right' href='files.php?op=show&amp;fil_id=<{$file.fil_id}>&amp;fil_traid=<{$file.fil_traid}><{$traOp}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
        <a class='btn btn-success right' onclick="printFile('<{$wgsimpleacc_upload_files_url}>/<{$file.name}>')" href='#' title='<{$smarty.const._MA_WGSIMPLEACC_PRINT}>'><{$smarty.const._MA_WGSIMPLEACC_PRINT}></a>
        <a class='btn btn-primary right' href='files.php?op=edit&amp;fil_id=<{$file.fil_id}><{$traOp}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
        <a class='btn btn-danger right' href='files.php?op=delete&amp;fil_id=<{$file.fil_id}><{$traOp}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
    </td>
</tr>

