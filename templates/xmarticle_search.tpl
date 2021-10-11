<div class="xmarticle">
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php"><{$index_module}></a></li>
		<li class="breadcrumb-item active" aria-current="page"><{$smarty.const._MA_XMARTICLE_SEARCH}></li>
	  </ol>
	</nav>
	<div>
		<{$form|default:false}>
	</div>
	<{if $article|default:'' != ""}>
        <h3 class="tdm-title"><{$smarty.const._MA_XMARTICLE_LISTARTICLE}> <span class="badge badge-pill badge-info"><{$article_count}></span>:</h3>
		<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 justify-content-center">
			<{section name=i loop=$article}><{include file="db:xmarticle_article.tpl" down=$article[i]}><{/section}>
		</div>
	<{/if}>
    <div class="clear spacer"></div>
    <{if $nav_menu|default:false}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
    <{if $no_article|default:false}>
        <div class="alert alert-danger" role="alert"><{$smarty.const._MA_XMARTICLE_ERROR_NOARTICLE}></div>
    <{/if}>
</div><!-- .xmarticle -->