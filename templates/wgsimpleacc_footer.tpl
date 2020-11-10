<div class="clear"></div>
<{if $pagenav != ''}>
	<div class='pull-right'><{$pagenav}></div>
<{/if}>
<br>
<{if $xoops_isadmin != ''}>
	<div class='text-center bold'><a href='<{$admin}>'><{$smarty.const._MA_WGSIMPLEACC_ADMIN}></a></div>
<{/if}>
<{if $copyright}>
	<div class="clear"></div>
	<div class='center'><{$copyright}></div>
<{/if}>
<{if $comment_mode}>
	<div class='pad2 marg2'>
		<{if $comment_mode == "flat"}>
			<{include file='db:system_comments_flat.tpl' }>
		<{elseif $comment_mode == "thread"}>
			<{include file='db:system_comments_thread.tpl' }>
		<{elseif $comment_mode == "nest"}>
			<{include file='db:system_comments_nest.tpl' }>
		<{/if}>
	</div>
<{/if}>
<{include file='db:system_notification_select.tpl' }>
