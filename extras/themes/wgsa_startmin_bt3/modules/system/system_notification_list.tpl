<h4><{$lang_activenotifications}></h4>
<form name="notificationlist" action="notifications.php" method="post">
    <table class="table table-striped table-responsive">
        <thead>
        <tr class="info">
            <th><input name="allbox" id="allbox" onclick="xoopsCheckAll('notificationlist', 'allbox');" type="checkbox" value="<{$lang_checkall}>"/>
            </th>
            <th><{$lang_event}></th>
            <th><{$lang_category}></th>
            <th><{$lang_itemid}></th>
            <th><{$lang_itemname}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=module from=$modules}>
            <tr class="warning">
                <th class="head"><input name="del_mod[<{$module.id}>]" id="del_mod[]"
                                        onclick="xoopsCheckGroup('notificationlist', 'del_mod[<{$module.id}>]', 'del_not[<{$module.id}>][]');"
                                        type="checkbox" value="<{$module.id}>"/></th>
                <th class="head" colspan="4"><{$lang_module}>: <{$module.name}></th>
            </tr>
            <{foreach item=category from=$module.categories}>
            <{foreach item=item from=$category.items}>
            <{foreach item=notification from=$item.notifications}>
            <tr>
                <td><input type="checkbox" name="del_not[<{$module.id}>][]" id="del_not[<{$module.id}>]" value="<{$notification.id}>"/>
                </td>
                <td><{$notification.event_title}></td>
                <td><{$notification.category_title}></td>
                <td><{if $item.id != 0}><{$item.id}><{/if}></td>
                <td><{if $item.id != 0}><{if $item.url != ''}><a href="<{$item.url}>" title="<{$item.name}>"><{/if}><{$item.name}><{if
                    $item.url != ''}></a><{/if}><{/if}>
                </td>
            </tr>
            <{/foreach}>
            <{/foreach}>
            <{/foreach}>
            <{/foreach}>
        </tbody>
    </table>
    <input class="btn btn-default" type="submit" name="delete_cancel" value="<{$lang_cancel}>"/>
    <input class="btn btn-default" type="reset" name="delete_reset" value="<{$lang_clear}>"/>
    <input class="btn btn-default" type="submit" name="delete" value="<{$lang_delete}>"/>
    <input type="hidden" name="XOOPS_TOKEN_REQUEST" value="<{$notification_token}>"/>
</form>
