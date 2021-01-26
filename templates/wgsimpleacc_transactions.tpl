<script>
	$(document).ready(function(){
		$("#toggleFormFilter").click(function(){
			$("#formFilter").toggle(1000);
			if (document.getElementById("toggleFormFilter").innerText == "<{$smarty.const._MA_WGSIMPLEACC_FILTER_HIDE}>")
			{
				document.getElementById("toggleFormFilter").innerText = "<{$smarty.const._MA_WGSIMPLEACC_FILTER_SHOW}>";
			}
			else
			{
				document.getElementById("toggleFormFilter").innerText = "<{$smarty.const._MA_WGSIMPLEACC_FILTER_HIDE}>";
			}
		});
	});
</script>

<{if $showList|default:''}>
    <{if $transactionsCount|default:0 > 0}>
        <{if $showItem|default:false}>
            <h3><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DETAILS}></h3>
            <{foreach item=transaction from=$transactions}>
                <{include file='db:wgsimpleacc_transactions_item.tpl' }>
            <{/foreach}>
        <{else}>
            <div class="col-sm-12">
                <a id="toggleFormFilter" class='btn btn-default pull-right' href='#' title='<{$btnfilter}>'><{$btnfilter}></a>
            </div>
            <{if $formFilter|default:''}>
            <div id="formFilter" class="row" style="display:<{$displayfilter}>">
                <div class="col-sm-12">
                    <{$formFilter}>
                </div>
            </div>
            <{/if}>
            <h3><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_LIST}></h3>
            <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_YEARNB}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLID}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}></th>
                            <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNT}></th>
                            <{if $showAssets|default:''}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
                            <{/if}>
                            <{if $useTaxes|default:''}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
                            <{/if}>
                            <{if $useFiles|default:''}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_FILES}></th>
                            <{/if}>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <{foreach item=transaction from=$transactions}>
                            <{include file='db:wgsimpleacc_transactions_list.tpl' }>
                        <{/foreach}>
                    </tbody>
                </table>
            </div>
        <{/if}>
    <{else}>
        <{$smarty.const._MA_WGSIMPLEACC_THEREARENT_TRANSACTIONS}>
    <{/if}>
<{/if}>

<{if $showHist|default:''}>
    <h3><{$smarty.const._MA_WGSIMPLEACC_TRAHISTORY_LIST}></h3>
    <div class='table-responsive'>
        <table class='table table-striped'>
            <thead>
            <tr>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_HIST}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_YEARNB}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REMARKS}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLID}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNT}></th>
                <{if $showAssets|default:''}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
                <{/if}>
                <{if $useTaxes|default:''}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
                <{/if}>
                <{if $useFiles|default:''}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_FILES}></th>
                <{/if}>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_STATUS}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
            </tr>
            </thead>
            <tbody>
            <{foreach item=transaction from=$historyTransactions}>
                <{include file='db:wgsimpleacc_transactions_hist.tpl' }>
                <{/foreach}>
            </tbody>
            <tfoot>
                <tr>
                    <td class="center" colspan="15">
                        <a class='btn btn-success right' href='javascript:history.back()' title='<{$smarty.const._BACK}>'><{$smarty.const._BACK}></a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
<{/if}>

<div class="clear"></div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="infoModalLabel">Default Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="<{$smarty.const._CLOSE}>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><{$smarty.const._CLOSE}></button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#infoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var info = button.data('info');
        var title = button.data('title');
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find('.modal-body').html(info);
    })
</script>

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
                <img id="modalimg" class="modal-img" src="" alt="" title="">
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
    })
</script>