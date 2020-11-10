<{include file='db:wgsimpleacc_header.tpl' }>


<div class="container-fluid">
	<div class="row wgsa-content">
		<div class="col-sm-4 col-md-4 col-lg-2 col-xl-2"><{include file='db:wgsimpleacc_navbar.tpl'}></div>
		<div class="col-sm-8 col-md-8 col-lg-10 col-xl-10">
			<{if $formFilter}>
			<div class="row">
				<div class="col-sm-12">
					<{$formFilter}>
				</div>
			</div>
			<{/if}>
			<{if $filesCount > 0}>
				<h3><{$smarty.const._MA_WGSIMPLEACC_FILES_LIST}></h3>
				<div class='table-responsive'>
					<table class='table table-striped'>
						<thead>
						<tr>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ACCID}></th>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ALLOCATION}></th>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DATE}></th>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNT}></th>
							<{if $showAssets}>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
							<{/if}>
							<{if $useTaxes}>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
							<{/if}>
							<th scope="col"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_FILES}></th>
							<th scope="col"></th>
						</tr>
						</thead>
						<tbody>
						<{foreach item=transaction from=$transactions}>
							<{include file='db:wgsimpleacc_files_list.tpl' }>
							<{/foreach}>
						</tbody>
					</table>
				</div>
			<{else}>
				<{$smarty.const._MA_WGSIMPLEACC_FILES_THEREARENO}>
			<{/if}>
			<{if $form}>
			<{$form}>
			<{/if}>
			<{if $error}>
			<{$error}>
			<{/if}>
		</div>
	</div>
	<{if $adv}>
	<div class="row">
		<div class="col-sm-12"><{$adv}></div>
	</div>
	<{/if}>
</div>

<{include file='db:wgsimpleacc_footer.tpl' }>
