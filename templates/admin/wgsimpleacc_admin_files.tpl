<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $files_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_ID}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_TRAID}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_NAME}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_TYPE}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_DESC}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_IP}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $files_count}>
		<tbody>
			<{foreach item=file from=$files_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$file.id}></td>
				<td class='center'><{$file.traid}></td>
				<td class='center'><{$file.name}></td>
				<td class='center'><{$file.type}></td>
				<td class='center'><{$file.desc_short}></td>
				<td class='center'><{$file.ip}></td>
				<td class='center'><{$file.datecreated}></td>
				<td class='center'><{$file.submitter}></td>
				<td class="center  width5">
					<a href="files.php?op=edit&amp;fil_id=<{$file.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> files" /></a>
					<a href="files.php?op=delete&amp;fil_id=<{$file.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> files" /></a>
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
