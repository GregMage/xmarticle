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
<{if $article_count != 0}>
	<div align="right">
		<form id="form_document_tri" name="form_document_tri" method="get" action="document.php">
			<select name="article_filter" id="article_filter" onchange="location='article.php?start=<{$start}>&article_cid='+this.options[this.selectedIndex].value">
				<{$article_cid_options}>
			<select>
		</form>
	</div>
    <table id="xo-xmcontact-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_ARTICLE_LOGO}></th>
            <th class="txtleft width20"><{$smarty.const._MA_XMARTICLE_ARTICLE_CATEGORY}></th>
            <th class="txtleft width15"><{$smarty.const._MA_XMARTICLE_ARTICLE_NAME}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_ARTICLE_REFERENCE}></th>
            <th class="txtleft"><{$smarty.const._MA_XMARTICLE_ARTICLE_DESC}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_STATUS}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=article from=$article}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtcenter"><{$article.logo}></td>
                <td class="txtleft"><{$article.category}></td>
                <td class="txtleft"><{$article.name}></td>
                <td class="txtcenter"><{$article.reference}></td>
                <td class="txtleft"><{$article.description}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$article.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"/><img class="cursorpointer tooltip" id="sml<{$article.id}>"
                    onclick="system_setStatus( { op: 'article_update_status', article_id: <{$article.id}> }, 'sml<{$article.id}>', 'article.php' )"
                    src="<{if $article.status}><{xoAdminIcons success.png}><{else}><{xoAdminIcons cancel.png}><{/if}>"
                    alt="<{if $article.status}><{$smarty.const._MA_XMARTICLE_STATUS_NA}><{else}><{$smarty.const._MA_XMARTICLE_STATUS_A}><{/if}>"
                    title="<{if $article.status}><{$smarty.const._MA_XMARTICLE_STATUS_NA}><{else}><{$smarty.const._MA_XMARTICLE_STATUS_A}><{/if}>"/>
                </td>
                <td class="xo-actions txtcenter">
					<a class="tooltip" href="../viewarticle.php?category_id=<{$article.cid}>&amp;article_id=<{$article.id}>" title="<{$smarty.const._MA_XMARTICLE_VIEW}>">
                        <img src="<{xoAdminIcons view.png}>" alt="<{$smarty.const._MA_XMARTICLE_VIEW}>"/>
                    </a>
                    <a class="tooltip" href="article.php?op=edit&amp;article_id=<{$article.id}>" title="<{$smarty.const._MA_XMARTICLE_EDIT}>">
                        <img src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._MA_XMARTICLE_EDIT}>"/>
                    </a>
                    <a class="tooltip" href="article.php?op=del&amp;article_id=<{$article.id}>" title="<{$smarty.const._MA_XMARTICLE_DEL}>">
                        <img src="<{xoAdminIcons delete.png}>" alt="<{$smarty.const._MA_XMARTICLE_DEL}>"/>
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


