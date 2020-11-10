
<div class='table-responsive'>
	<table class='table table-striped'>
		<tbody>
			<tr>
				<th class="col-sm-2"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_YEARNB}></th>
				<td class="col-sm-10"><{$transaction.year}>/<{$transaction.nb}></td>
			</tr>
			<tr>
				<th class="col-sm-2"><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_DESC}></th>
				<td class="col-sm-10"><{$transaction.desc}></td>
			</tr>
			<tr>
				<th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_REFERENCE}></th>
				<td><{$transaction.reference}></td>
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
				<th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_AMOUNT}></th>
				<td><{$transaction.curid}> <{$transaction.amount}></td>
			</tr>
			<{if $showAssets}>
				<tr>
					<th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_ASID}></th>
					<td><{$transaction.curid}> <{$transaction.asset}></td>
				</tr>
			<{/if}>
			<{if $useTaxes}>
			<tr>
				<th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_TAXID}></th>
				<td><{$transaction.taxrate}></td>
			</tr>
			<{/if}>
			<{if $useFiles}>
				<{if $transaction.nbfiles > 0}>
					<tr>
						<th><{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_FILES}></th>
						<td>
							<{foreach item=file from=$transaction.files}>
							<{if $file.image}>
								<img class="wgsa-transaction-img-list" src="<{$wgsimpleacc_upload_files_url}>/<{$file.name}>" alt="<{$file.name}>" title="<{$file.name}>">
							<{else}>
								<{$file.name}>
							<{/if}>
							<{/foreach}>
							<{if $permSubmit && $transaction.edit}>
								<a class='btn btn-primary right' href='files.php?op=list&amp;fil_traid=<{$transaction.tra_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_FILE_ADD}>'>+</a>
							<{/if}>
						</td>
					</tr>
				<{/if}>
			<{/if}>
		</tbody>
		<tfoot>
			<tr>
				<td class="center" colspan="2">
					<a class='btn btn-success right' href='transactions.php?op=list<{$traOp}>#traId_<{$transaction.tra_id}>' title='<{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_LIST}>'><{$smarty.const._MA_WGSIMPLEACC_TRANSACTIONS_LIST}></a>
					<{if $permSubmit && $transaction.edit}>
						<a class='btn btn-primary right' href='transactions.php?op=edit&amp;tra_id=<{$transaction.tra_id}>' title='<{$smarty.const._EDIT}>'><{$smarty.const._EDIT}></a>
						<a class='btn btn-danger right' href='transactions.php?op=delete&amp;tra_id=<{$transaction.tra_id}>' title='<{$smarty.const._DELETE}>'><{$smarty.const._DELETE}></a>
					<{/if}>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
