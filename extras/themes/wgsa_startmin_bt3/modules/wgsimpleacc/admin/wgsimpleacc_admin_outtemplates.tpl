<!-- Header -->
<{include file='db:wgsimpleacc_admin_header.tpl' }>

<{if $outtemplates_list|default:''}>
    <table class='table table-bordered'>
        <thead>
            <tr class='head'>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_ID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_NAME}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_TYPE}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_ALLID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_ACCID}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_OUTTEMPLATE_ONLINE}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_DATECREATED}></th>
                <th class="center"><{$smarty.const._MA_WGSIMPLEACC_SUBMITTER}></th>
                <th class="center width5"><{$smarty.const._MA_WGSIMPLEACC_FORM_ACTION}></th>
            </tr>
        </thead>
        <{if $outtemplates_count|default:0}>
            <tbody>
                <{foreach item=outtemplate from=$outtemplates_list}>
                    <tr class='<{cycle values='odd, even'}>'>
                        <td class='center'><{$outtemplate.id}></td>
                        <td class='center'><{$outtemplate.name}></td>
                        <td class='center'><{$outtemplate.type_text}></td>
                        <td class="center">
                            <ul>
                                <{foreach item=alloc from=$outtemplate.allocations}>
                                    <li>
                                        <{$alloc.name}>
                                        <{if $alloc.online_text|default:false}>
                                            <img class="wgsa-img-online wgsa-img-online-small" src="<{$wgsimpleacc_icons_url_32}>/<{$alloc.online}>.png" alt="<{$alloc.online_text}>">
                                        <{/if}>
                                    </li>
                                <{/foreach}>
                            </ul>
                        </td>
                        <td class="center">
                            <ul>
                                <{foreach item=account from=$outtemplate.accounts}>
                                    <li>
                                        <{$account.name}>
                                        <{if $account.online_text|default:false}>
                                            <img class="wgsa-img-online wgsa-img-online-small" src="<{$wgsimpleacc_icons_url_32}>/<{$account.online}>.png" alt="<{$account.online_text}>">
                                        <{/if}>
                                    </li>
                                <{/foreach}>
                            </ul>
                        </td>
                        <td class='center'><{$outtemplate.online}></td>
                        <td class='center'><{$outtemplate.datecreated}></td>
                        <td class='center'><{$outtemplate.submitter}></td>
                        <td class="center  width5">
                            <a href="outtemplates.php?op=edit&amp;otpl_id=<{$outtemplate.id}>" title="<{$smarty.const._EDIT}>"><img src="<{xoModuleIcons16 'edit.png'}>" alt="<{$smarty.const._EDIT}> outtemplates"></a>
                            <a href="outtemplates.php?op=clone&amp;otpl_id_clone=<{$outtemplate.id}>" title="<{$smarty.const._CLONE}>"><img src="<{xoModuleIcons16 'editcopy.png'}>" alt="<{$smarty.const._CLONE}> outtemplates"></a>
                            <a href="outtemplates.php?op=delete&amp;otpl_id=<{$outtemplate.id}>" title="<{$smarty.const._DELETE}>"><img src="<{xoModuleIcons16 'delete.png'}>" alt="<{$smarty.const._DELETE}> outtemplates"></a>
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
