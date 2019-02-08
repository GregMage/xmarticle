<{foreach item=article from=$block.article}>
	<div class="col-sm-4 col-md-4 xm-minibox">
		<div class="xm-article-logo">
			<img src="<{$article.logo}>" alt="<{$article.name}>">
		</div>
		<a class="xm-title" title="<{$article.name}>" href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$article.cid}>&amp;article_id=<{$article.id}>">
			<{$article.name}>
		</a>
		<div class="row xm-article-data">
			<div class="col-md-5"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMARTICLE_DATE}>"></span>
				<{$article.date}>
			</div>
			<div class="col-md-7"><span class="glyphicon glyphicon-user" title="<{$smarty.const._MA_XMARTICLE_AUTHOR}>"></span>
				<{$article.author}>
			</div>
		</div>

		<div class="xm-short-description">
			<{$article.description}>
		</div>

		<a class="btn btn-primary col-md-9" title="<{$article.name}>"
		   href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$article.cid}>&amp;article_id=<{$article.id}>">
			<{$smarty.const._MA_XMARTICLE_MOREDETAILS}>
		</a>
	</div>
<{/foreach}>