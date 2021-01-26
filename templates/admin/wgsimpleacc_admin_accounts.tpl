<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $accounts_list|default:''}>
	<table class='table table-bordered'>
		<thead>
			<tr class='head'>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_ID}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_PID}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_KEY}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_NAME}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_DESC}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_CLASSIFICATION}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_COLOR}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_IECALC}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_ONLINE}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_LEVEL}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_ACCOUNT_WEIGHT}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
				<th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
				<th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
			</tr>
		</thead>
		<{if $accounts_count}>
		<tbody>
			<{foreach item=account from=$accounts_list}>
			<tr class='<{cycle values='odd, even'}>'>
				<td class='center'><{$account.id}></td>
				<td class='center'><{$account.pid}></td>
				<td class='center'><{$account.key}></td>
				<td class='center'><{$account.name}></td>
				<td class='center'><{$account.desc_short}></td>
				<td class='center'><{$account.classification}></td>
				<td class='center'>
                    <{foreach item=color from=$colors}>
                        <{if $color.code == $account.color}>
                            <span style="background-color:<{$account.color}>;border:3px double #000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <{else}>
                            <a href="accounts.php?op=savecolor&amp;acc_id=<{$account.id}>&amp;acc_color=<{$color.code|substr:1}>" title="<{$color.name}>">
                                <span style="background-color:<{$color.code}>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            </a>
                        <{/if}>
                    <{/foreach}>
                </td>
				<td class='center'><{$account.iecalc}></td>
				<td class='center'><{$account.online}></td>
				<td class='center'><{$account.level}></td>
				<td class='center'><{$account.weight}></td>
				<td class='center'><{$account.datecreated}></td>
				<td class='center'><{$account.submitter}></td>
				<td class="center  width5">
					<a href="accounts.php?op=edit&amp;acc_id=<{$account.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 edit.png}>" alt="<{$smarty.const._EDIT}> accounts" /></a>
					<a href="accounts.php?op=delete&amp;acc_id=<{$account.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 delete.png}>" alt="<{$smarty.const._DELETE}> accounts" /></a>
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
