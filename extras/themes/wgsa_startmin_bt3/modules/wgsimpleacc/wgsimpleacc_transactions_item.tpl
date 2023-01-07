<div class='table-responsive'>
    <table class='table table-striped'>
        <tbody>
            <tr>
                <th class="col-sm-2"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_YEARNB}></th>
                <td class="col-sm-10"><{$transaction.year}>/<{$transaction.nb}></td>
            </tr>
            <{if $useClients|default:''}>
                <tr>
                    <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CLIID}></th>
                    <td><{$transaction.client}></td>
                </tr>
            <{/if}>
            <tr>
                <th class="col-sm-2"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
                <td class="col-sm-10"><{$transaction.desc}></td>
            </tr>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
                <td><{$transaction.reference}></td>
            </tr>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REMARKS}></th>
                <td><{$transaction.remarks}></td>
            </tr>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}></th>
                <td><{$transaction.account}></td>
            </tr>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLID}></th>
                <td><{$transaction.allocation}></td>
            </tr>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}></th>
                <td><{$transaction.date}></td>
            </tr>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_CLASS}></th>
                <td><{$transaction.curid}> <{$transaction.class_text}></td>
            </tr>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNT}></th>
                <td><{$transaction.curid}> <{$transaction.amount}></td>
            </tr>
            <{if $showAssets|default:''}>
                <tr>
                    <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
                    <td><{$transaction.curid}> <{$transaction.asset}></td>
                </tr>
            <{/if}>
            <{if $useTaxes|default:''}>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
                <td><{$transaction.taxrate}></td>
            </tr>
            <{/if}>
            <{if $useFiles|default:''}>
                <{if $transaction.nbfiles > 0}>
                    <tr>
                        <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_FILES}></th>
                        <td>
                            <{foreach item=file from=$transaction.files}>
                            <{if $file.image}>
                                <span class="wgsa-modal" data-toggle="modal" data-target="#imgModal" data-title="<{$file.name}>" data-info="<{$wgsimpleacc_upload_files_url}>/<{$file.name}>">
                                    <img class="wgsa-transaction-img-list" src="<{$wgsimpleacc_upload_files_url}>/<{$file.name}>" alt="<{$file.name}>" title="<{$file.name}>">
                                </span><br>
                            <{else}>
                                <{$file.name}> <a class='btn btn-default' href='files.php?op=showfile&amp;fil_id=<{$file.id}>' title='<{$file.name}>' target="_blank"><i class="fa fa-download fa-fw"></i></a><br>
                            <{/if}>
                            <{/foreach}>
                            <{if $permSubmit && $transaction.edit}>
                                <a class='btn btn-primary right' href='files.php?op=list&amp;fil_traid=<{$transaction.tra_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_FILE_ADD}>'>+</a>
                            <{/if}>
                        </td>
                    </tr>
                <{/if}>
            <{/if}>
            <tr>
                <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_STATUS}></th>
                <td><{$transaction.status_text}></td>
            </tr>
            <{if $transaction.hist}>
                <tr>
                    <th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_HIST}></th>
                    <td>
                        <a class='btn btn-default right' href='transactions.php?op=history&amp;tra_id=<{$transaction.tra_id}><{$traOp}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><{$smarty.const._MA_WGSIMPLEACC_DETAILS}></a>
                    </td>
                </tr>
            <{/if}>
            <tr>
                <th class="col-sm-2"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <td class="col-sm-10"><{$transaction.datetimecreated}></td>
            </tr>
            <tr>
                <th class="col-sm-2"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                <td class="col-sm-10"><{$transaction.submitter}></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="center" colspan="2">
                    <a class='btn btn-success right' href='transactions.php?op=list<{$traOp}>#traId_<{$transaction.tra_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_LIST}></a>
                    <{if $permSubmit && $transaction.editable}>
                        <a class='btn btn-primary right' href='transactions.php?op=edit&amp;tra_id=<{$transaction.tra_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
                        <a class='btn btn-danger right' href='transactions.php?op=delete&amp;tra_id=<{$transaction.tra_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
                    <{/if}>
                    <{if $transaction.tratemplate}>
                        <a class='btn btn-primary right' href='tratemplates.php?op=new&amp;tra_id=<{$transaction.tra_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TRATEMPLATE}>'><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TRATEMPLATE}></a>
                    <{/if}>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
