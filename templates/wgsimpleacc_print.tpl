<{include file="db:wgsimpleacc_header.tpl"}>
<table class="wgsimpleacc">
    <thead class="outer">
        <tr class="head">
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_IMG_ID}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_IMG_TRAID}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_IMG_NAME}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_IMG_TYPE}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_IMG_DESC}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_IMG_IP}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_IMG_DATECREATED}></th>
            <th class="center"><{$smarty.const._MA_WGSIMPLEACC_IMG_SUBMITTER}></th>
        </tr>
    </thead>
    <tbody>
        <{foreach item=list from=$images}>
            <tr class="<{cycle values='odd, even'}>">
                <td class="center"><{$list.id}></td>
                <td class="center"><{$list.traid}></td>
                <td class="center"><img src="<{$wgsimpleacc_upload_url}>/images/images/<{$list.name}>" alt="images"></td>
                <td class="center"><{$list.type}></td>
                <td class="center"><{$list.desc}></td>
                <td class="center"><{$list.ip}></td>
                <td class="center"><{$list.datecreated}></td>
                <td class="center"><{$list.submitter}></td>
            </tr>
        <{/foreach}>
    </tbody>
</table>
<{include file="db:wgsimpleacc_footer.tpl"}>