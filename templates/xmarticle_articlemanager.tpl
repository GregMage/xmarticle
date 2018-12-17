<!doctype html>
<html lang="<{$xoops_langcode}>">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>">
    <meta http-equiv="content-language" content="<{$xoops_langcode}>">
    <title><{$xoops_sitename}> <{$lang_imgmanager}></title>
    <{$image_form.javascript}>
    <link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl xoops.css}>">
	<link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl modules/system/css/imagemanager.css}>">
	<link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl modules/system/css/admin.css}>">
    <link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl media/font-awesome/css/font-awesome.min.css}>">
</head>

<body onload="window.resizeTo(<{$xsize|default:800}>, <{$ysize|default:800}>);">
<div class="xmarticle">
	<{if $selected}>
		<h2><{$smarty.const._MA_XMDOC_FORMDOC_SELECTED}></h2>
		<table cellspacing="0" id="imagemain">
			<tr>
			<{foreach item=seldoc from=$seldoc}>			
				<td class="txtcenter"><{$seldoc.name}><br><{$seldoc.logo}></td>
				<{if $seldoc.count is div by 4}>
				</tr>
				<tr>
				<{/if}>
			<{/foreach}>
			</tr>
		</table>
		<form name="selreset" id="selreset" action="articlemanager.php" method="post">
			<input type="hidden" name="selectreset" value="true" />
			<input type='submit' class='formButton' name='subselect'  id='subselect' value='<{$smarty.const._MA_XMDOC_FORMDOC_RESETSELECTED}>' title='<{$smarty.const._MA_XMDOC_FORMDOC_RESETSELECTED}>'  />
			<input value="<{$smarty.const._SUBMIT}>" type="button" onclick="window.close();"/>
		</form>
	<{/if}>
	<{if $form}>
		<div class="xmform">
			<h2><{$smarty.const._MA_XMARTICLE_SEARCH}></h2>
			<{$form}>
		</div>
	<{/if}>
	<div id="addimage" class="txtright">
		<a href="<{$xoops_url}>/modules/xmarticle/action.php?op=add" title="<{$smarty.const._MA_XMARTICLE_DOCUMENT_ADD}>" target="_blank"><{$smarty.const._MA_XMARTICLE_ARTICLE_ADD}></a>
	</div>
	<{if $error_message != ''}>
		<div class="errorMsg" style="text-align: left;">
			<{$error_message}>
		</div>
	<{/if}>
	<{if $article != ""}>
        <h3 class="tdm-title"><{$smarty.const._MA_XMARTICLE_FORMARTICLE_LISTARTICLE}>:</h3>
		<form name="formsel" id="formsel" action="articlemanager.php" method="post">
			<table cellspacing="0" id="imagemain">
				<tr>
					<th class="txtcenter width5"><{$smarty.const._MA_XMARTICLE_FORMARTICLE_SELECT}></th>
					<th class="txtcenter width10"><{$smarty.const._MA_XMARTICLE_ARTICLE_LOGO}></th>
					<th class="txtleft width15"><{$smarty.const._MA_XMARTICLE_ARTICLE_NAME}></th>
				</tr>
				<tbody>
				
				<{foreach item=article from=$article}>
					<tr class="<{cycle values='even,odd'}> alignmiddle">
						<td class="txtcenter"><input type="radio" name="selArticle" id="selArticle<{$article.id}>"  title="Selection article" value="<{$article.id}>"  /></td>
						<td class="txtcenter"><{$article.logo}></td>
						<td class="txtleft">
                            <a href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$article.cid}>&amp;article_id=<{$article.id}>" target="_blank" title="<{$article.name}>" >
                                <h4><{$article.name}></h4>
                            </a>
                            <br><{$article.description}>
                        </td>
					</tr>
				<{/foreach}>

				</tbody>
			</table>
		<input type='submit' class='formButton' name='select'  id='select' value='<{$smarty.const._MA_XMARTICLE_FORMARTICLE_SELECT}>' title='<{$smarty.const._MA_XMARTICLE_FORMARTICLE_SELECT}>'  />
		</form>
    <{/if}>
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
</div><!-- .xmdoc -->
<div id="footer">
    <input value="<{$smarty.const._CLOSE}>" type="button" onclick="window.close();"/>
</div>

</body>
</html>
