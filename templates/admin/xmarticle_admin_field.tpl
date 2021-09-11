<script type="text/javascript">
    IMG_ON = '<{xoAdminIcons success.png}>';
    IMG_OFF = '<{xoAdminIcons cancel.png}>';
</script>
<div>
    <{$renderbutton|default:''}>
</div>
<{if $error_message|default:'' != ''}>
    <div class="errorMsg" style="text-align: left;">
        <{$error_message}>
    </div>
<{/if}>
<div>
    <{$form|default:''}>
</div>
<{if $field_count|default:0 != 0}>
    <table id="xo-xmcontact-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtcenter width15"><{$smarty.const._MA_XMARTICLE_FIELD_TYPE}></th>
            <th class="txtleft"><{$smarty.const._MA_XMARTICLE_FIELD_NAME}></th>
            <th class="txtleft width20"><{$smarty.const._MA_XMARTICLE_FIELD_DESC}></th>    
            <th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_FIELD_TITLEWEIGHT}></th>             
            <th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_FIELD_TITLEREQUIRED}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_FIELD_TITLESEARCH}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_STATUS}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=field from=$field}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtcenter"><{$field.type}></td>
                <td class="txtleft"><{$field.name}></td>
                <td class="txtleft"><{$field.description}></td>
                <td class="txtcenter"><{$field.weight}></td>
                <{if $field.required == 0}>
                    <td class="txtcenter"><span style="color: red; font-weight:bold;"><{$smarty.const._NO}><span></td>
                <{else}>
                    <td class="txtcenter"><span style="color: green; font-weight:bold;"><{$smarty.const._YES}><span></td>
                <{/if}>
                <{if $field.search == 0}>
                    <td class="txtcenter"><span style="color: red; font-weight:bold;"><{$smarty.const._NO}><span></td>
                <{else}>
                    <td class="txtcenter"><span style="color: green; font-weight:bold;"><{$smarty.const._YES}><span></td>
                <{/if}>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$field.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"><img class="cursorpointer tooltip" id="sml<{$field.id}>"
                    onclick="system_setStatus( { op: 'field_update_status', field_id: <{$field.id}> }, 'sml<{$field.id}>', 'field.php' )"
                    src="<{if $field.status}><{xoAdminIcons success.png}><{else}><{xoAdminIcons cancel.png}><{/if}>"
                    alt="<{if $field.status}><{$smarty.const._MA_XMARTICLE_STATUS_NA}><{else}><{$smarty.const._MA_XMARTICLE_STATUS_A}><{/if}>"
                    title="<{if $field.status}><{$smarty.const._MA_XMARTICLE_STATUS_NA}><{else}><{$smarty.const._MA_XMARTICLE_STATUS_A}><{/if}>">
                </td>
                <td class="xo-actions txtcenter">
                    <a class="tooltip" href="field.php?op=edit&amp;field_id=<{$field.id}>" title="<{$smarty.const._MA_XMARTICLE_EDIT}>">
                        <img src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._MA_XMARTICLE_EDIT}>"></a>
                    <a class="tooltip" href="field.php?op=del&amp;field_id=<{$field.id}>" title="<{$smarty.const._MA_XMARTICLE_DEL}>">
                        <img src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._MA_XMARTICLE_DEL}>"></a>
                </td>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <div class="clear spacer"></div>
    <{if $nav_menu|default:false}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
<{/if}>


