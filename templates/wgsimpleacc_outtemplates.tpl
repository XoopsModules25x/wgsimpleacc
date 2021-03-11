<{if $showList|default:''}>
	<{if $outtemplatesCount|default:0 > 0}>
		<h3><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATES_LIST}></h3>
		<div class='table-responsive'>
			<table class='table table-<{$table_type}>'>
				<thead>
				<tr class='head'>
					<th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_NAME}></th>
					<th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_TYPE}></th>
					<th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_ALLID}></th>
					<th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_ONLINE}></th>
					<th class="center"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
				</tr>
				</thead>
				<tbody>
					<{foreach item=template from=$outtemplates}>
						<{include file='db:wgsimpleacc_outtemplates_list.tpl' }>
					<{/foreach}>
				</tbody>
			</table>
		</div>
	<{else}>
		<{$smarty.const._MA_WGSIMPLEACC_THEREARENT_OUTTEMPLATES}>
	<{/if}>
<{/if}>
<{if $outputText|default:''}>
	<div class="wgsa_outtemplate"><{$outputText}></div>
	<div class="wgsa_outtemplate_footer center">
		<a href="#" class="btn btn-warning" onclick="history.go(-1);return true;"><{$smarty.const._BACK}></a>
	</div>
<{/if}>
