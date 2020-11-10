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

<{if $showList}>
    <{if $transactionsCount > 0}>
        <{if $showItem}>
            <{foreach item=transaction from=$transactions}>
                <{include file='db:wgsimpleacc_transactions_item.tpl' }>
            <{/foreach}>
        <{else}>
            <div class="col-sm-12">
                <a id="toggleFormFilter" class='btn btn-default pull-right' href='#' title='<{$btnfilter}>'><{$btnfilter}></a>
            </div>
            <{if $formFilter}>
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
                            <{if $showAssets}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
                            <{/if}>
                            <{if $useTaxes}>
                                <th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
                            <{/if}>
                            <{if $useFiles}>
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
