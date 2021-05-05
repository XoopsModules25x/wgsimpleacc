<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $clients_list|default:''}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_ID}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_NAME}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_POSTAL}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_CITY}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_ADDRESS}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_CTRY}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_PHONE}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_VAT}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_CREDITOR}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_CLIENT_DEBTOR}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $clients_count|default:''}>
		<tbody>
			<{foreach item=client from=$clients_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$client.id}></td>
				<td class='center'><{$client.name_short}></td>
				<td class='center'><{$client.postal}></td>
				<td class='center'><{$client.city}></td>
				<td class='center'><{$client.address_short}></td>
				<td class='center'><{$client.ctry}></td>
				<td class='center'><{$client.phone}></td>
				<td class='center'><{$client.vat}></td>
				<td class='center'><{$client.creditor}></td>
				<td class='center'><{$client.debtor}></td>
				<td class='center'><{$client.datecreated}></td>
				<td class='center'><{$client.submitter}></td>
				<td class="center  width5">
					<a href="clients.php?op=edit&amp;cli_id=<{$client.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> clients"></a>
					<a href="clients.php?op=delete&amp;cli_id=<{$client.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> clients"></a>
				</td>
			</tr>
			<{/foreach}>
		</tbody>
		<{/if}>
	</table>
	<div class="clear">&nbsp;</div>
	<{if $pagenav|default:''}>
		<div class="xo-pagenav floatright"><{$pagenav}></div>
		<div class="clear spacer"></div>
	<{/if}>
<{/if}>
<{if $form|default:''}>
	<{$form}>
<{/if}>
<{if $error|default:''}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgsimpleacc_admin_footer.tpl' }>
