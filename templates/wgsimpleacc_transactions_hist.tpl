<tr class="row-class-<{$transaction.tra_class}>" id='traId_<{$transaction.tra_id}>'>
	<td>
		<{if $transaction.histid > 0}>
		<{$transaction.histdate}>
		<{/if}>
	</td>
	<td><{$transaction.year}>/<{$transaction.nb}></td>
	<{if $useClients|default:''}>
	<td><{$transaction.client}></td>
	<{/if}>
	<td><{$transaction.desc}></td>
	<td><{$transaction.remarks}></td>
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
		<td><{$transaction.nbfiles}></td>
	<{/if}>
	<td><{$transaction.status_text}></td>
	<td><{$transaction.datetimecreated}></td>
	<td><{$transaction.submitter}></td>
</tr>