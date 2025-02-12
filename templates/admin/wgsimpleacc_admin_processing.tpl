<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $processing_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_PROCESSING_TEXT}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_PROCESSING_INCOME}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_PROCESSING_EXPENSES}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONLINE}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_PROCESSING_DEFAULT}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_PROCESSING_WEIGHT}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $processing_count|default:''}>
        <tbody>
            <{foreach item=processing from=$processing_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$processing.id}></td>
                <td class='center'><{$processing.text_short}></td>
                <td class='center'>
                    <a href="processing.php?op=set_onoff&amp;param_onoff=income&amp;pro_id=<{$processing.id}>" title="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>">
                        <img class="wgsa-img-online" src="<{$wgsimpleacc_icon_url}>/32/<{$processing.pro_income}>.png" title="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>" alt="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>"></a>
                </td>
                <td class='center'>
                    <a href="processing.php?op=set_onoff&amp;param_onoff=expenses&amp;pro_id=<{$processing.id}>" title="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>">
                        <img class="wgsa-img-online" src="<{$wgsimpleacc_icon_url}>/32/<{$processing.pro_expenses}>.png" title="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>" alt="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>"></a>
                </td>
                <td class='center'>
                    <a href="processing.php?op=set_onoff&amp;param_onoff=online&amp;pro_id=<{$processing.id}>" title="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>">
                        <img class="wgsa-img-online" src="<{$wgsimpleacc_icon_url}>/32/<{$processing.pro_online}>.png" title="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>" alt="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>"></a>
                </td>
                <td class='center'>
                    <a href="processing.php?op=set_onoff&amp;param_onoff=default&amp;pro_id=<{$processing.id}>" title="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>">
                        <img class="wgsa-img-online" src="<{$wgsimpleacc_icon_url}>/32/<{$processing.pro_default}>.png" title="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>" alt="<{$smarty.const._MA_WGSIMPLEACC_PROCESSING_ONOFF}>"></a>
                </td>
                <td class='center'><{$processing.weight}></td>
                <td class='center'><{$processing.datecreated}></td>
                <td class='center'><{$processing.submitter}></td>
                <td class="center  width5">
                    <a href="processing.php?op=edit&amp;pro_id=<{$processing.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> processing"></a>
                    <a href="processing.php?op=delete&amp;pro_id=<{$processing.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> processing"></a>
                </td>
            </tr>
            <{/foreach}>
        </tbody>
        <{/if}>
    </table>
    <div class="clear">&nbsp;</div>
    <{if !empty($pagenav)}>
        <div class="xo-pagenav floatright"><{$pagenav}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>
<{if !empty($form)}>
    <{$form}>
<{/if}>
<{if !empty($error)}>
    <div class="errorMsg"><strong><{$error}></strong></div>
<{/if}>

<!-- Footer -->
<{include file='db:wgsimpleacc_admin_footer.tpl' }>
