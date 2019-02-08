<{foreach item=article from=$block.article}>
	<div class="col-sm-4 col-md-4 xm-minibox">
		<div class="xm-article-logo">
			<img src="<{$article.logo}>" alt="<{$article.name}>">
		</div>
		<a class="xm-title" title="<{$article.name}>" href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$article.cid}>&amp;article_id=<{$article.id}>">
			<{$article.name}>
		</a>
		<div class="row xm-article-data">
			<{if $article.type == "date" || $article.type == "random"}>
			<div class="col-md-8"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMARTICLE_DATE}>"></span>
				<{$smarty.const._MA_XMARTICLE_DATE}>: <{$article.date}>
			</div>
			<{/if}>
			<{if $article.type == "hits"}>
			<div class="col-md-8"><span class="glyphicon glyphicon-repeat" title="<{$smarty.const._MA_XMARTICLE_READING}>"></span>
				<{$smarty.const._MA_XMARTICLE_READING}>: <{$article.hits}>
			</div>
			<{/if}>
			<{if $article.type == "rating"}>
			<div class="col-md-8"><span class="glyphicon glyphicon-star-empty" title="<{$smarty.const._MA_XMARTICLE_RATING}>"></span>
				<{$smarty.const._MA_XMARTICLE_RATING}>: <{$article.rating}> (<{$article.votes}>)
			</div>
			<{/if}>
		</div>

		<div class="xm-short-description">
			<{$article.description|truncateHtml:20:'...'}>
		</div>

		<a class="btn btn-primary col-md-9" title="<{$article.name}>"
		   href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$article.cid}>&amp;article_id=<{$article.id}>">
			<{$smarty.const._MA_XMARTICLE_MOREDETAILS}>
		</a>
	</div>
<{/foreach}>
<div class="clearfix"></div>