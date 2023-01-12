<h3><{$header_fileslist|default:''}></h3>
<{if $formFilesUpload|default:''}>
    <div id='filehandler' class='col-xs-12 col-sm-12'>
        <ul class='nav nav-tabs'>
            <li class='active'><a id='navtab_main' href='#1' data-toggle='tab'><{$smarty.const._MA_WGSIMPLEACC_FILES_CURRENT}></a></li>
            <li><a id='navtab_upload_file' href='#2' data-toggle='tab'><{$smarty.const._MA_WGSIMPLEACC_FILES_UPLOAD}></a></li>
            <{if $upload_by_app|default:''}>
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
                    <div style="padding:20px"><{$smarty.const._MA_WGSIMPLEACC_THEREARENT_FILES}></div>
                <{/if}>
                <a class='btn btn-danger right' href='transactions.php?op=list&amp;start=<{$start}>&amp;limit=<{$limit}>' title='<{$smarty.const._BACK}>'><{$smarty.const._BACK}></a>
            </div>
            <!-- *************** Tab for upload files ***************-->
            <div class='tab-pane' id='2'>
                <{if $formFilesUpload|default:''}>
                    <{$formFilesUpload}>
                <{/if}>
            </div>
            <{if $upload_by_app}>
                <!-- ***************Tab for select uploaded files ***************-->
                <div class='tab-pane' id='3' >
                    <{if $formFilesTemp|default:''}>
                        <{$formFilesTemp}>
                    <{/if}>
                </div>
            <{/if}>
        </div>
    </div>
<{/if}>
<{if $formFilesEdit|default:''}>
    <{$formFilesEdit}>
<{/if}>

<div class="clear"></div>

<!-- ---------------------------------- -->
<!-- Start code for show files as modal -->
<!-- ---------------------------------- -->
<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="pdfModalLabel">Default Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<{$smarty.const._CLOSE}>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <embed id="embedPdf" src="assets/images/blank.gif"
                       frameborder="0" width="100%" height="400px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><{$smarty.const._CLOSE}></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="imgModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="imgModalLabel">Default Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<{$smarty.const._CLOSE}>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalimg" class="modal-img" src="assets/images/blank.gif" alt="blank" title="blank">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><{$smarty.const._CLOSE}></button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#imgModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var info = button.data('info');
        var title = button.data('title');
        var modal = $(this);
        modal.find('.modal-title').text(title);
        var modalimg = document.getElementById("modalimg");
        modalimg.src = info;
        var width = modalimg.naturalWidth;
        modal.find(".modal-dialog").css("width", width + 100);
    });
    window.onload = function() {
        var btnDel = document.getElementById('delete_filtemp');
        btnDel.classList.add("btn-danger");
        btnDel.classList.add("hidden");
    };
    function showBtnDel() {
        var btnDel = document.getElementById('delete_filtemp');
        btnDel.classList.remove("hidden");
    }
    $('#pdfModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var info = button.data('info');
        var title = button.data('title');
        var modal = $(this);
        modal.find('.modal-title').text(title);
        var modalpdf = document.getElementById("embedPdf");
        modalpdf.src = info;
        var width = modalpdf.naturalWidth;
        modal.find(".modal-dialog").css("width", width + 100);
    });
</script>
<!-- End code for show files as modal-->

<!-- ----------------------------- -->
<!-- Start code for printing files -->
<!-- ----------------------------- -->
<script>
    function printFile(url) {
        const iframe = document.createElement('iframe');
        iframe.src = url;
        iframe.style.display = 'none';
        document.body.appendChild(iframe);

        // Use onload to make pdf preview work on firefox
        iframe.onload = () => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        };
    }
</script>
<style>
    @media print,
    @print {
        .navigation {
            visibility: hidden;
        }
        @page
        {
            size: auto;
            margin: 0;
        }
        @page :footer {
            display: none
        }
        @page :header {
            display: none
        }
    }
</style>
<!-- End code for printing files -->
