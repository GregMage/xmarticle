<div class="xmarticle">
    <ol class="breadcrumb">
        <li><a href="index.php"><{$smarty.const._MA_XMARTICLE_HOME}></a></li>
        <li class="active"><{$name}></li>
    </ol>
    <div class="media">
        <div class="media-left">
            <img class="media-object" src="<{$logo}>" alt="<{$name}>">
        </div>
        <div class="media-body">
            <h2 class="media-heading"><{$name}> (<{$reference}>)</h2>
            <{$description}>
        </div>
    </div>
    <{if $article != ""}>
        <h3 class="tdm-title"><{$smarty.const._MA_XMARTICLE_LISTARTICLE}>:</h3>
        <{section name=i loop=$article}><{include file="db:xmarticle_article.tpl" down=$article[i]}><{/section}>
        <{if $pagenav != ''}><{$pagenav}><{/if}>
    <{/if}>
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
</div><!-- .xmarticle -->