<div class="xmarticle">
	<div class="xmform">
		<{$form}>
	</div>
	<{if $article != ""}>
        <h3 class="tdm-title"><{$smarty.const._MA_XMARTICLE_LISTARTICLE}>:</h3>
        <{section name=i loop=$article}><{include file="db:xmarticle_article.tpl" down=$article[i]}><{/section}>
    <{/if}>
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
</div><!-- .xmarticle -->