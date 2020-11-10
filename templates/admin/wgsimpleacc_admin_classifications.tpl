<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $classifications_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CLASSIFICATION_ID}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CLASSIFICATION_PID}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CLASSIFICATION_NAME}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CLASSIFICATION_STATUS}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CLASSIFICATION_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_CLASSIFICATION_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._AM_WGSIMPLEACC_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $classifications_count}>
		<tbody>
			<{foreach item=classification from=$classifications_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$classification.id}></td>
				<td class='center'><{$classification.pid}></td>
				<td class='center'><{$classification.name}></td>
				<td class='center'><img src="<{$modPathIcon16}>status<{$classification.status}>.png" alt="<{$classification.status_text}>" title="<{$classification.status_text}>" /></td>
				<td class='center'><{$classification.datecreated}></td>
				<td class='center'><{$classification.submitter}></td>
				<td class="center  width5">
					<a href="classifications.php?op=edit&amp;cla_id=<{$classification.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> classifications" /></a>
					<a href="classifications.php?op=delete&amp;cla_id=<{$classification.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> classifications" /></a>
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
