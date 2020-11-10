<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $images_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_IMAGE_ID}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_IMAGE_TRAID}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_IMAGE_NAME}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_IMAGE_TYPE}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_IMAGE_DESC}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_IMAGE_IP}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_IMAGE_DATECREATED}></th>
				<th class="center"><{$smarty.const._AM_WGSIMPLEACC_IMAGE_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._AM_WGSIMPLEACC_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $images_count}>
		<tbody>
			<{foreach item=image from=$images_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$image.id}></td>
				<td class='center'><{$image.traid}></td>
				<td class='center'><img src="<{$wgsimpleacc_upload_url}>/images/images/<{$image.name}>" alt="images" style="max-width:100px" /></td>
				<td class='center'><{$image.type}></td>
				<td class='center'><{$image.desc_short}></td>
				<td class='center'><{$image.ip}></td>
				<td class='center'><{$image.datecreated}></td>
				<td class='center'><{$image.submitter}></td>
				<td class="center  width5">
					<a href="images.php?op=edit&amp;img_id=<{$image.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> images" /></a>
					<a href="images.php?op=delete&amp;img_id=<{$image.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> images" /></a>
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
