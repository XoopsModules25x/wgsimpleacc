<{include file='db:wgsimpleacc_header.tpl' }>

<{if $imagesCount > 0}>
<div class='table-responsive'>
	<table class='table table-<{$table_type}>'>
		<thead>
			<tr class='head'>
				<th colspan='<{$divideby}>'><{$smarty.const._MA_WGSIMPLEACC_IMAGES_TITLE}></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<{foreach item=image from=$images}>
				<td>
					<div class='panel panel-<{$panel_type}>'>
						<{include file='db:wgsimpleacc_images_item.tpl' }>
					</div>
				</td>
				<{if $image.count is div by $divideby}>
					</tr><tr>
				<{/if}>
				<{/foreach}>
			</tr>
		</tbody>
		<tfoot><tr><td>&nbsp;</td></tr></tfoot>
	</table>
</div>
<{/if}>
<{if $form}>
	<{$form}>
<{/if}>
<{if $error}>
	<{$error}>
<{/if}>

<{include file='db:wgsimpleacc_footer.tpl' }>
