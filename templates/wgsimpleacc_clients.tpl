<{if $showList|default:''}>
	<{if $clientsCount|default:0 > 0}>
		<h3><{$smarty.const._MA_WGSIMPLEACC_CLIENTS_LIST}></h3>
		<div class='table-responsive'>
			<table class='table table-striped'>
				<thead>
					<tr>
						<th><{$smarty.const._MA_WGSIMPLEACC_CLIENT_NAME}></th>
						<th><{$smarty.const._MA_WGSIMPLEACC_CLIENT_FULLADDRESS}></th>
						<th><{$smarty.const._MA_WGSIMPLEACC_CLIENT_PHONE}></th>
						<th><{$smarty.const._MA_WGSIMPLEACC_CLIENT_VAT}></th>
						<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_CREDITOR}></th>
						<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_DEBTOR}></th>
						<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_ONLINE}></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<{foreach item=client from=$clients name=client}>
						<{include file='db:wgsimpleacc_clients_list.tpl' }>
					<{/foreach}>
				</tbody>
			</table>
		</div>
	<{else}>
		<{$smarty.const._MA_WGSIMPLEACC_THEREARENT_CLIENTS}>
	<{/if}>
<{/if}>
