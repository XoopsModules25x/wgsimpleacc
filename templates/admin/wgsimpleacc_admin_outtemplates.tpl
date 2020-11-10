<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $outtemplates_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_ID}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_NAME}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_CONTENT}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_ONLINE}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $outtemplates_count}>
		<tbody>
			<{foreach item=outtemplate from=$outtemplates_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$outtemplate.id}></td>
				<td class='center'><{$outtemplate.name}></td>
				<td class='center'><{$outtemplate.content_short}></td>
				<td class='center'><{$outtemplate.online}></td>
				<td class='center'><{$outtemplate.datecreated}></td>
				<td class='center'><{$outtemplate.submitter}></td>
				<td class="center  width5">
					<a href="outtemplates.php?op=edit&amp;otpl_id=<{$outtemplate.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> outtemplates" /></a>
					<a href="outtemplates.php?op=delete&amp;otpl_id=<{$outtemplate.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> outtemplates" /></a>
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