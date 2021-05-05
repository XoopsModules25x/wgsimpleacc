<tr id='oplId_<{$template.otpl_id}>'>
	<td><{$template.name}></td>
	<td class="center"><{$template.type_text}></td>
	<td class="center"><{$template.allid}></td>
	<td class="center"><{$template.accid}></td>
	<td class="center">
		<{if $template.otpl_online|default:0 == 1}>
	<img src="<{$wgsimpleacc_icons_url_32}>/1.png" alt="<{$template.online}>">
		<{else}>
	<img src="<{$wgsimpleacc_icons_url_32}>/0.png" alt="<{$template.online}>">
		<{/if}>
	</td>
	<td class="center">
		<{if $permSubmit && $template.edit}>
		<a class='btn btn-primary right' href='outtemplates.php?op=edit&amp;otpl_id=<{$template.otpl_id}><{$tplOp|default:''}>' title='<{$smarty.const._EDIT}>'><i class="fa fa-edit fa-fw"></i></a>
		<a class='btn btn-danger right' href='outtemplates.php?op=delete&amp;otpl_id=<{$template.otpl_id}>' title='<{$smarty.const._DELETE}>'><i class="fa fa-trash fa-fw"></i></a>
		<{/if}>
	</td>
</tr>