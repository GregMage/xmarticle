<div class="xmarticle">
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php"><{$index_module}></a></li>
		<li class="breadcrumb-item active" aria-current="page"><{$name}></li>
	  </ol>
	</nav>
	<div class="row mb-2">
		<{if $logo != ''}>
		<div class="col-3 col-md-4 col-lg-3 text-center">
			<img class="rounded img-fluid" src="<{$logo}>" alt="<{$name}>">
		</div>
		<{/if}>
		<div class="col-9 col-md-8 col-lg-9 " style="padding-bottom: 5px; padding-top: 5px;">
			<h4 class="mt-0"><{$name}></h4>
			<{$description}>
		</div>
	</div>
    <{if $article|default:'' != ""}>
        <h3><{$smarty.const._MA_XMARTICLE_LISTARTICLE}>:</h3>
		<div class="row row-cols-lg-3 row-cols-md-2 row-cols-1 justify-content-center">
			<{section name=i loop=$article}><{include file="db:xmarticle_article.tpl" down=$article[i]}><{/section}>
		</div>
    <{/if}>
    <div class="clear spacer"></div>
    <{if $nav_menu|default:false}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
	<div style="margin:3px; padding: 3px;">
		<{include file='db:system_notification_select.tpl'}>
    </div>
</div><!-- .xmarticle -->