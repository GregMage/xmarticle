<div class="col-sm-4 col-md-4 xm-minibox">
    <div class="xm-article-logo">
        <img src="<{$down.logo}>" alt="<{$down.name}>">
    </div>
    <a class="xm-title" title="<{$down.name}>" href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$down.cid}>&amp;article_id=<{$down.id}>">
        <{$down.name}>
    </a>
    <div class="row xm-article-data">
        <div class="col-md-5"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMARTICLE_DATE}>"></span>
            <{$down.date}>
        </div>
        <div class="col-md-7"><span class="glyphicon glyphicon-user" title="<{$smarty.const._MA_XMARTICLE_AUTHOR}>"></span>
			<{$down.author}>
        </div>
    </div>

    <div class="xm-short-description">
        <{$down.description}>
    </div>

    <a class="btn btn-primary col-md-9" title="<{$down.name}>"
       href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$down.cid}>&amp;article_id=<{$down.id}>">
        <{$smarty.const._MA_XMARTICLE_MOREDETAILS}>
    </a>
</div><!-- .xm-minibox -->
