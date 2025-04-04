<tr id='tplId_<{$template.ttpl_id}>'>
    <td><{$template.name}></td>
    <td><{$template.desc}></td>
    <td>
        <{$template.allid}>
        <img class="wgsa-img-online wgsa-img-online-small" src="<{$smarty.const.WGSIMPLEACC_ICONS_URL}>/32/<{$template.allonline}>.png" title="<{$template.allonlinetext}>" alt="<{$template.allonlinetext}>">
    </td>
    <td>
        <{$template.accid}> <{$template.accname}>
        <img class="wgsa-img-online wgsa-img-online-small" src="<{$smarty.const.WGSIMPLEACC_ICONS_URL}>/32/<{$template.acconline}>.png" title="<{$template.acconlinetext}>" alt="<{$template.acconlinetext}>">
    </td>
    <td>
        <{$template.asid}>
        <img class="wgsa-img-online wgsa-img-online-small" src="<{$smarty.const.WGSIMPLEACC_ICONS_URL}>/32/<{$template.asonline}>.png" title="<{$template.asonlinetext}>" alt="<{$template.asonlinetext}>">
    </td>
    <{if $useClients|default:''}>
        <td>
            <{if $template.ttpl_cliid|default:0 > 0}>
                <{$template.cliid}>
                <img class="wgsa-img-online wgsa-img-online-small" src="<{$smarty.const.WGSIMPLEACC_ICONS_URL}>/32/<{$template.clionline}>.png" title="<{$template.clionlinetext}>" alt="<{$template.clionlinetext}>">
            <{/if}>
        </td>
    <{/if}>
    <td><{$template.class_text}></td>
    <td><{$template.amountin}></td>
    <td><{$template.amountout}></td>
    <td class="center">
        <{if $template.ttpl_online|default:0 == 1}>
            <img src="<{$wgsimpleacc_icons_url_32}>/1.png" alt="<{$template.online}>">
        <{else}>
            <img src="<{$wgsimpleacc_icons_url_32}>/0.png" alt="<{$template.online}>">
        <{/if}>
    </td>
    <td><{$template.submitter}></td>
    <td class="center">
        <{if $permSubmit || $template.edit}>
        <a class='btn btn-primary right' href='tratemplates.php?op=edit&amp;ttpl_id=<{$template.ttpl_id}><{$tplOp|default:''}>' title='<{$smarty.const._EDIT}>'><i class="fa fa-edit fa-fw"></i></a>
        <a class='btn btn-danger right' href='tratemplates.php?op=delete&amp;ttpl_id=<{$template.ttpl_id}>' title='<{$smarty.const._DELETE}>'><i class="fa fa-trash fa-fw"></i></a>
        <{/if}>
    </td>
</tr>