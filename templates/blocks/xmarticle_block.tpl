<div class="row">
	<{if $block.article|default:false}>
	<{foreach item=blockarticle from=$block.article}>
		<div class="col-xs-12 col-sm-6 col-lg-3 mb-3 px-1 px-sm-2 mx-3 mx-sm-0">
			<div class="card xmarticle-border" <{if $blockarticle.color != false}>style="border-color : <{$blockarticle.color}>;"<{/if}>>
				<div class="card-header text-center text-truncate d-none d-sm-block" <{if $blockarticle.color != false}>style="background-color : <{$blockarticle.color}>;"<{/if}>>
					<a class="text-decoration-none text-white" href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$blockarticle.cid}>&amp;article_id=<{$blockarticle.id}>">
						<{$blockarticle.name}>
					</a>
				</div>
				<div class="card-header text-center d-block d-sm-none">
					<a class="text-decoration-none" href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$blockarticle.cid}>&amp;article_id=<{$blockarticle.id}>">
						<{$blockarticle.name}>
					</a>
				</div>
				<div class="card-body text-center">
					<div class="row" >
						<div class="col-12" style="height: 150px;">
							<{if $blockarticle.logo != ''}>
							<a title="<{$blockarticle.name}>" href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$blockarticle.cid}>&amp;article_id=<{$blockarticle.id}>">
								<img class="rounded img-fluid mh-100" src="<{$blockarticle.logo}>" alt="<{$blockarticle.name}>">
							</a>
							<{/if}>
						</div>
						<div class="col-12 pt-2 text-left text-muted xmarticle-data">
							<{if $blockarticle.type == "date" || $blockarticle.type == "random"}>
								<div class="d-block d-lg-none d-xl-block"><span class="fa fa-calendar" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_DATE}>: <{$blockarticle.date}></div>
								<div class="d-none d-lg-block d-xl-none"><br /><span class="fa fa-calendar" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_DATE}>: <{$blockarticle.date|truncate:10:''}></div>
							<{/if}>
							<{if $blockarticle.type == "hits"}>
								<span class="fa fa-eye" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_READING}>: <{$blockarticle.hits}>
							<{/if}>
							<{if $blockarticle.type == "rating"}>
							<{if $block.xmsocial == true}>
							<span class="fa fa-star" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_RATING}>: <{$blockarticle.rating}>
							<{/if}>
							<{/if}>
						</div>
						<div class="col-12 pt-2 text-left">					
							<{$blockarticle.description|truncateHtml:30:'...'}>				
						</div>
						<div class="col-12 pt-2">
							<a class="btn btn-primary btn-sm" href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$blockarticle.cid}>&amp;article_id=<{$blockarticle.id}>"><{$smarty.const._MA_XMARTICLE_MOREDETAILS}></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<{/foreach}>
	<{/if}>
</div>