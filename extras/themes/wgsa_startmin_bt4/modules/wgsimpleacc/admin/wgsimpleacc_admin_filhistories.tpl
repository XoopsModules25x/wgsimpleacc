<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $filhistories_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_FILES_HISTID}></th>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_FILES_HISTTYPE}></th>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_FILES_HISTDATE}></th>
                <th class="center"><{$smarty.const._AM_WGSIMPLEACC_FILES_HISTSUBMITTER}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_ID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_TRAID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_NAME}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_TYPE}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_DESC}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_FILE_IP}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $filhistories_count|default:''}>
        <tbody>
            <{foreach item=filhistory from=$filhistories_list}>
            <tr class='<{cycle values='odd, even'}>'>
                <td class='center'><{$filhistory.histid}></td>
                <td class='center'><{$filhistory.histtype}></td>
                <td class='center'><{$filhistory.histdate}></td>
                <td class='center'><{$filhistory.histsubmitter}></td>
                <td class='center'><{$filhistory.id}></td>
                <td class='center'><{$filhistory.traid}></td>
                <td class='center'><{$filhistory.name}></td>
                <td class='center'><{$filhistory.type}></td>
                <td class='center'><{$filhistory.desc_short}></td>
                <td class='center'><{$filhistory.ip}></td>
                <td class='center'><{$filhistory.datecreated}></td>
                <td class='center'><{$filhistory.submitter}></td>
                <td class="center  width5">
                    <a href="filhistories.php?op=delete&amp;hist_id=<{$filhistory.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> filhistories"></a>
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
