<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $currencies_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CURRENCY_ID}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CURRENCY_SYMBOL}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CURRENCY_CODE}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CURRENCY_NAME}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CURRENCY_PRIMARY}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CURRENCY_ONLINE}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $currencies_count}>
		<tbody>
			<{foreach item=currency from=$currencies_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$currency.id}></td>
				<td class='center'><{$currency.symbol}></td>
				<td class='center'><{$currency.code}></td>
				<td class='center'><{$currency.name}></td>
				<td class='center'><{$currency.primary}></td>
				<td class='center'><{$currency.online}></td>
				<td class='center'><{$currency.datecreated}></td>
				<td class='center'><{$currency.submitter}></td>
				<td class="center  width5">
					<a href="currencies.php?op=edit&amp;cur_id=<{$currency.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> currencies" /></a>
					<a href="currencies.php?op=delete&amp;cur_id=<{$currency.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> currencies" /></a>
				</td>
			</tr>
			<{/foreach}>
		</tbody>
		<{/if}>
	</table>
	<div class="clear">&nbsp;</div>
	<{if $pagenav}>
		<div class="xo-pagenav floatright"><{$pagenav}></div>
		<div class="clear spacer"></div>
	<{/if}>
<{/if}>
<{if $form}>
	<{$form}>
<{/if}>
<{if $error}>
	<div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgsimpleacc_admin_footer.tpl' }>
