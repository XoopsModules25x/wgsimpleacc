<tr id='tplId_<{$template.ttpl_id}>'>
	<td><{$template.name}></td>
	<td><{$template.desc}></td>
	<td><{$template.accid}></td>
	<td><{$template.allid}></td>
	<td><{$template.asid}></td>
	<td><{$template.amountin}></td>
	<td><{$template.amountout}></td>
	<td><{$template.online}></td>
	<td class="center">
		<{if $permSubmit && $template.edit}>
		<a class='btn btn-primary right' href='tratemplates.php?op=edit&amp;ttpl_id=<{$template.ttpl_id}><{$tplOp}>' title='<{$smarty.const._EDIT}>'><i class="fa fa-edit fa-fw"></i></a>
		<a class='btn btn-danger right' href='tratemplates.php?op=delete&amp;ttpl_id=<{$template.ttpl_id}>' title='<{$smarty.const._DELETE}>'><i class="fa fa-trash fa-fw"></i></a>
		<{/if}>
	</td>
</tr>