<h3><{$header_fileslist|default:''}></h3>
<!-- start code for show files non-related to transactions -->
<{if $filedir|default:false}>
    <{if $filedirCount|default:0 > 0}>
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
    <div class="clear"></div>
    <{/if}>
<{if $formFilesDir|default:''}>
    <{$formFilesDir}>
    <div class="clear"></div>
<{/if}>

<!-- end code for show files non-related to transactions -->
<!-- start code for show files related to transactions -->
<{if $formFilesUpload|default:''}>
    <div id='filehandler' class='col-xs-12 col-sm-12'>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><{$smarty.const._MA_WGSIMPLEACC_FILES_CURRENT}></button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="upload_file-tab" data-bs-toggle="tab" data-bs-target="#upload_file" type="button" role="tab" aria-controls="upload_file" aria-selected="false"><{$smarty.const._MA_WGSIMPLEACC_FILES_UPLOAD}></button>
            </li>
            <{if $upload_by_app|default:''}>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="upload_temp-tab" data-bs-toggle="tab" data-bs-target="#upload_temp" type="button" role="tab" aria-controls="upload_temp" aria-selected="false"><{$smarty.const._MA_WGSIMPLEACC_FILES_TEMP}></button>
                </li>
            <{/if}>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <!-- *************** Basic Tab ***************-->
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
                <a class='btn btn-danger right' href='transactions.php?op=list<{$traOp}>' title='<{$smarty.const._BACK}>'><{$smarty.const._BACK}></a>
            </div>
            <div class="tab-pane fade" id="upload_file" role="tabpanel" aria-labelledby="upload_file-tab">
                <!-- *************** Tab for upload files ***************-->
                <{if $formFilesUpload|default:''}>
                    <{$formFilesUpload}>
                <{/if}>
            </div>
            <{if $upload_by_app|default:''}>
                <div class="tab-pane fade" id="upload_temp" role="tabpanel" aria-labelledby="upload_temp-tab">
                    <!-- ***************Tab for select uploaded files ***************-->
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
<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="imgModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="imgModalLabel">Default Title</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="<{$smarty.const._CLOSE}>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id="modalimg" class="modal-img img-fluid" src="assets/images/blank.gif" alt="blank" title="blank">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><{$smarty.const._CLOSE}></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="pdfModalLabel">Default Title</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="<{$smarty.const._CLOSE}>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <embed id="embedPdf" class="embedPdf" src="assets/images/blank.gif"
                       frameborder="0" width="100%" height="400px">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><{$smarty.const._CLOSE}></button>
            </div>
        </div>
    </div>
</div>

<script>
    const imgModal = document.getElementById('imgModal')
    if (imgModal) {
        imgModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const info = button.getAttribute('data-bs-info')
            const title = button.getAttribute('data-bs-title')
            // Update the modal's content.
            const modalTitle = imgModal.querySelector('.modal-title')
            const modalImg = imgModal.querySelector('.modal-img')

            modalTitle.textContent = title
            modalImg.src = info
        })
    }
    const pdfModal = document.getElementById('pdfModal')
    if (pdfModal) {
        pdfModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget
            // Extract info from data-bs-* attributes
            const info = button.getAttribute('data-bs-info')
            const title = button.getAttribute('data-bs-title')
            // Update the modal's content.
            const modalTitle = document.getElementById('pdfModalLabel')
            const modalpdf = document.getElementById("embedPdf");
            modalpdf.src = info;

            modalTitle.textContent = title

        })
    }

    window.onload = function() {
        var btnDel = document.getElementById('delete_filtemp');
        btnDel.classList.add("btn-danger");
        btnDel.classList.add("hidden");
    };
    function showBtnDel() {
        var btnDel = document.getElementById('delete_filtemp');
        btnDel.classList.remove("hidden");
    }

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

<!-- ----------------------------- -->
<!-- Start code for checking multiple dots in file name -->
<!-- ----------------------------- -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.getElementById('fil_name');

        if (uploadInput) {
            uploadInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const filename = file.name;
                    const dotCount = (filename.match(/\./g) || []).length;

                    if (dotCount > 1) {
                        alert("<{$smarty.const._MA_WGSIMPLEACC_FORM_UPLOAD_MULTIDOTS}>");
                    }
                }
            });
        }
    });
</script>
<!-- End code for checking multiple dots in file name -->
