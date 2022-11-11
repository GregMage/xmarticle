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
<{if $warning_message|default:'' != ''}>
    <div class="xm-warning-msg xo-actions">
        <{$warning_message}>
		<a class="tooltip" href="article.php?article_status=2" title="<{$smarty.const._MA_XMARTICLE_VIEW}>">
			<img src="<{xoAdminIcons view.png}>" alt="<{$smarty.const._MA_XMARTICLE_VIEW}>">
		</a>
    </div>
<{/if}>
<{if $form|default:''}>
    <div>
        <{$form}>
    </div>
<{/if}>
<{if $filter|default:false}>
	<div align="right">
		<form id="form_article_tri" name="form_article_tri" method="get" action="article.php">
			<{$smarty.const._MA_XMARTICLE_ARTICLE_CATEGORY}>
			<select name="article_filter" id="article_filter" onchange="location='article.php?start=<{$start}>&article_status=<{$article_status}>&article_cid='+this.options[this.selectedIndex].value">
				<{$article_cid_options}>
			<select>
			<{$smarty.const._MA_XMARTICLE_STATUS}>
			<select name="article_filter" id="article_filter" onchange="location='article.php?start=<{$start}>&article_cid=<{$article_cid}>&article_status='+this.options[this.selectedIndex].value">
				<{$article_status_options}>
			<select>
		</form>
	</div>
<{/if}>
<{if $article_count|default:0 != 0}>
    <table id="xo-xmcontact-sorter" cellspacing="1" class="outer tablesorter">
        <thead>
        <tr>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_ARTICLE_LOGO}></th>
            <th class="txtleft width20"><{$smarty.const._MA_XMARTICLE_ARTICLE_CATEGORY}></th>
            <th class="txtleft width15"><{$smarty.const._MA_XMARTICLE_ARTICLE_NAME}></th>
            <th class="txtleft width10"><{$smarty.const._MA_XMARTICLE_ARTICLE_REFERENCE}></th>
            <th class="txtleft"><{$smarty.const._MA_XMARTICLE_ARTICLE_DESC}></th>
            <th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_STATUS}></th>
            <th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_ACTION}></th>
        </tr>
        </thead>
        <tbody>
        <{foreach item=article from=$article}>
            <tr class="<{cycle values='even,odd'}> alignmiddle">
                <td class="txtcenter"><img src="<{$article.logo}>" alt="<{$article.name}>" style="max-width:150px"></td>
                <td class="txtleft"><a href="../viewcat.php?category_id=<{$article.cid}>" title="<{$article.category}>"><{$article.category}></a></td>
                <td class="txtleft"><a href="../viewarticle.php?category_id=<{$article.cid}>&article_id=<{$article.id}>" title="<{$article.name}>"><{$article.name}></a></td>
                <td class="txtleft"><{$article.reference}></td>
                <td class="txtleft"><{$article.description}></td>
                <td class="xo-actions txtcenter">
                    <img id="loading_sml<{$article.id}>" src="../assets/images/spinner.gif" style="display:none;" title="<{$smarty.const._AM_SYSTEM_LOADING}>"
                    alt="<{$smarty.const._AM_SYSTEM_LOADING}>"><img class="cursorpointer tooltip" id="sml<{$article.id}>"
                    onclick="system_setStatus( { op: 'article_update_status', article_id: <{$article.id}>, article_status: <{$article.status}> }, 'sml<{$article.id}>', 'article.php' )"
                    src="<{if $article.status == 1}><{xoAdminIcons success.png}><{/if}><{if $article.status == 0}><{xoAdminIcons cancel.png}><{/if}><{if $article.status == 2}><{xoAdminIcons messagebox_warning.png}><{/if}>"
                    alt="<{if $article.status == 1}><{$smarty.const._MA_XMARTICLE_STATUS_NA}><{/if}><{if $article.status == 0 || $article.status == 2}><{$smarty.const._MA_XMARTICLE_STATUS_A}><{/if}>"
                    title="<{if $article.status == 1}><{$smarty.const._MA_XMARTICLE_STATUS_NA}><{/if}><{if $article.status == 0 || $article.status == 2}><{$smarty.const._MA_XMARTICLE_STATUS_A}><{/if}>">
                </td>
                <td class="xo-actions txtcenter">
					<a class="tooltip" href="../viewarticle.php?category_id=<{$article.cid}>&amp;article_id=<{$article.id}>" title="<{$smarty.const._MA_XMARTICLE_VIEW}>">
                        <img src="<{xoAdminIcons view.png}>" alt="<{$smarty.const._MA_XMARTICLE_VIEW}>"></a>
					<a class="tooltip" href="article.php?op=clone&amp;article_id=<{$article.id}>" title="<{$smarty.const._MA_XMARTICLE_CLONE}>">
                        <img src="<{xoAdminIcons clone.png}>" alt="<{$smarty.const._MA_XMARTICLE_CLONE}>"></a>
                    <a class="tooltip" href="article.php?op=edit&amp;article_id=<{$article.id}>" title="<{$smarty.const._MA_XMARTICLE_EDIT}>">
                        <img src="<{xoAdminIcons edit.png}>" alt="<{$smarty.const._MA_XMARTICLE_EDIT}>"></a>
                    <a class="tooltip" href="article.php?op=del&amp;article_id=<{$article.id}>" title="<{$smarty.const._MA_XMARTICLE_DEL}>">
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