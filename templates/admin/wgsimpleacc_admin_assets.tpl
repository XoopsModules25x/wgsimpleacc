<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $assets_list}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_ID}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_NAME}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_REFERENCE}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_DESCR}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_COLOR}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_ONLINE}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ASSET_PRIMARY}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $assets_count}>
		<tbody>
			<{foreach item=asset from=$assets_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$asset.id}></td>
				<td class='center'><{$asset.name}></td>
				<td class='center'><{$asset.reference}></td>
				<td class='center'><{$asset.descr_short}></td>
                <td class='center'>
                    <{foreach item=color from=$colors}>
                        <{if $color.code == $asset.color}>
                            <span style="background-color:<{$asset.color}>;border:3px double #000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <{else}>
                            <a href="assets.php?op=savecolor&amp;as_id=<{$asset.id}>&amp;as_color=<{$color.code|substr:1}>" title="<{$color.name}>">
                                <span style="background-color:<{$color.code}>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </a>
                        <{/if}>
                    <{/foreach}>
                </td>
				<td class='center'><{$asset.online}></td>
				<td class='center'><{$asset.primary}></td>
				<td class='center'><{$asset.datecreated}></td>
				<td class='center'><{$asset.submitter}></td>
				<td class="center  width5">
					<a href="assets.php?op=edit&amp;as_id=<{$asset.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> assets" /></a>
					<a href="assets.php?op=delete&amp;as_id=<{$asset.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> assets" /></a>
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
