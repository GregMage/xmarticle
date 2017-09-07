<script type="text/javascript">
    IMG_ON = '<{xoAdminIcons success.png}>';
    IMG_OFF = '<{xoAdminIcons cancel.png}>';
</script>
<div>
    <{$renderbutton}>
</div>
<{if $error_message != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<div>
    <{$form}>
</div>
<{if $category_count != 0}>
    <table id="xo-xmcontact-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_CATEGORY_LOGO}></th>
            <th class="txtleft width15"><{$smarty.const._MA_XMARTICLE_CATEGORY_NAME}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_CATEGORY_REFERENCE}></th>
            <th class="txtleft"><{$smarty.const._MA_XMARTICLE_CATEGORY_DESC}></th>            
            <th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_CATEGORY_WEIGHT}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_STATUS}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=category from=$category}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtcenter"><{$category.logo}></td>
                <td class="txtleft"><{$category.name}></td>
                <td class="txtcenter"><{$category.reference}></td>
                <td class="txtleft"><{$category.description}></td>                
                <td class="txtcenter"><{$category.weight}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$category.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"><img class="cursorpointer tooltip" id="sml<{$category.id}>"
                    onclick="system_setStatus( { op: 'category_update_status', category_id: <{$category.id}> }, 'sml<{$category.id}>', 'category.php' )"
                    src="<{if $category.status}><{xoAdminIcons success.png}><{else}><{xoAdminIcons cancel.png}><{/if}>"
                    alt="<{if $category.status}><{$smarty.const._MA_XMARTICLE_STATUS_NA}><{else}><{$smarty.const._MA_XMARTICLE_STATUS_A}><{/if}>"
                    title="<{if $category.status}><{$smarty.const._MA_XMARTICLE_STATUS_NA}><{else}><{$smarty.const._MA_XMARTICLE_STATUS_A}><{/if}>">
                </td>
                <td class="xo-actions txtcenter">
                    <a class="tooltip" href="category.php?op=edit&amp;category_id=<{$category.id}>" title="<{$smarty.const._MA_XMARTICLE_EDIT}>">
                        <img src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._MA_XMARTICLE_EDIT}>">
                    </a>
                    <a class="tooltip" href="category.php?op=del&amp;category_id=<{$category.id}>" title="<{$smarty.const._MA_XMARTICLE_DEL}>">
                        <img src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._MA_XMARTICLE_DEL}>">
                    </a>
                </td>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>


