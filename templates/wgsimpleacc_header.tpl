<{if $show_breadcrumbs|default:''}>
	<{include file='db:wgsimpleacc_breadcrumbs.tpl'}>
<{else}>
	<div class="spacer"></div>
<{/if}>

<{if $ads|default:''}>
	<div class='center'><{$ads}></div>
<{/if}>
