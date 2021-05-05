<tr class="row-class-<{$transaction.tra_class}>" id='traId_<{$transaction.tra_id}>'>
	<td><{$transaction.year}>/<{$transaction.nb}></td>
	<{if $useClients|default:''}>
		<td><{$transaction.client}></td>
	<{/if}>
	<td>
		<{if $transaction.remarks}>
		<span class="wgsa-modal" data-toggle="modal" data-target="#infoModal" data-title="<{$transaction.modaltitle}>" data-info="<{$transaction.remarks}>">
		<{/if}>
		<{$transaction.desc}>
		<{if $transaction.remarks}>
			<span class="badge wgsa-files-badge">i</span>
		<{/if}>
		<{if $transaction.remarks}>
		</span>
		<{/if}>
	</td>
	<td><{$transaction.reference}></td>
	<td><{$transaction.account}></td>
	<td><{$transaction.allocation}></td>
	<td><{$transaction.date}></td>
	<td>
		<{if $useCurrencies}>
		<{$transaction.curid}>&nbsp;
		<{/if}>
		<{$transaction.amount}>
	</td>
	<{if $showAssets|default:''}>
		<td><{$transaction.asset}></td>
	<{/if}>
	<{if $useTaxes|default:''}>
		<td><{$transaction.taxrate}></td>
	<{/if}>
	<{if $useFiles|default:''}>
		<td>
			<{if $permSubmit && $transaction.editable}>
				<a class='btn btn-default btn-sm right' href='files.php?op=list&amp;fil_traid=<{$transaction.tra_id}><{$traOp}>' title='<{$smarty.const._MA_WGSIMPLEACC_FILE_ADD}>' role='button'>
					<i class="fa fa-plus fa-fw"></i>
					<{if $transaction.nbfiles > 0}><span class="badge wgsa-files-badge"><{$transaction.nbfiles}></span><{/if}>
				</a>
			<{/if}>
		</td>
	<{/if}>
	<td class="center">
		<{if $transaction.waiting|default:''}>
			<{if $permApprove}>
				<a class='btn btn-warning right' href='transactions.php?op=approve&amp;tra_id=<{$transaction.tra_id}><{$traOp}>' title='<{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_STATUS_WAITING}>'><i class="fa fa-hourglass fa-fw"></i></a>
			<{else}>
				<a class='btn btn-warning disabled right' href='transactions.php?op=approve&amp;tra_id=<{$transaction.tra_id}><{$traOp}>' title='<{$smarty.const._MA_WGSIMPLEACC_TRANSACTION_STATUS_WAITING}>'><i class="fa fa-hourglass fa-fw"></i></a>
			<{/if}>
		<{/if}>
		<a class='btn btn-success right' href='transactions.php?op=show&amp;tra_id=<{$transaction.tra_id}><{$traOp}>' title='<{$smarty.const._MA_WGSIMPLEACC_DETAILS}>'><i class="fa fa-search fa-fw"></i></a>
		<{if $permSubmit && $transaction.editable}>
			<a class='btn btn-primary right' href='transactions.php?op=edit&amp;tra_id=<{$transaction.tra_id}><{$traOp}>' title='<{$smarty.const._EDIT}>'><i class="fa fa-edit fa-fw"></i></a>
			<{if $permDelete|default:0}>
				<a class='btn btn-danger right' href='transactions.php?op=delete&amp;tra_id=<{$transaction.tra_id}>' title='<{$smarty.const._DELETE}>'><i class="fa fa-trash fa-fw"></i></a>
			<{/if}>
		<{/if}>
		<{if $transaction.outputTpls|default:false}>
			<{if $transaction.outputTpls|@count > 1}>
				<a class='btn btn-default right' id="dropdown<{$transaction.tra_id}>" onClick="myDDToggle('myDD<{$transaction.tra_id}>')" title='<{$smarty.const._MA_WGSIMPLEACC_DOWNLOAD}>'><i class="fa fa-download fa-fw dd-down-1"></i><i class="fa fa-sort-down fa-fw dd-down-2"></i></a>
				<div id="myDD<{$transaction.tra_id}>" class="dropdown-content">
					<{foreach item=outputTpl from=$transaction.outputTpls}>
						<a href='<{$outputTpl.href}>' title='<{$outputTpl.title}>'><img src="<{$modPathIcon32}>otpltype<{$outputTpl.type}>.png" style="height:16px"></img>&nbsp;<{$outputTpl.caption}></a>
					<{/foreach}>
				</div>
			<{elseif $transaction.outputTpls|@count > 0}>
				<{foreach item=outputTpl from=$transaction.outputTpls}>
					<a class='btn btn-default dropdown-link' href='<{$outputTpl.href}>' title='<{$outputTpl.title}>'><img src="<{$modPathIcon32}>otpltype<{$outputTpl.type}>.png" style="height:16px"></img></a>
				<{/foreach}>
			<{/if}>
		<{/if}>
	</td>
</tr>
