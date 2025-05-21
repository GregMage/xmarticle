<div class="xmarticle">
    <ol class="breadcrumb">
		<li class="active"><{$index_module}></li>
    </ol>
	<{if $category_count != 0}>
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h1 class="h2"><{$smarty.const._MA_XMARTICLE_CATEGORY_LIST}></h1>
			<{if $export == true}>
			<a href="<{xoAppUrl 'modules/xmstats/export.php?op=article'}>" class="btn btn-sm btn-secondary">
				<{$smarty.const._MA_XMARTICLE_INDEX_EXPORT}>
			</a>
			<{/if}>
		</div>
		<div class="row justify-content-center">
			<{foreach item=category from=$categories}>
				<div class="col-6 col-sm-4 col-md-3 col-lg-3 p-2">
					<div class="card xmarticle-border" <{if $category.color != false}>style="border-color : <{$category.color}>;"<{/if}>>
						<a class="text-decoration-none" title="<{$category.name}>" href="<{$xoops_url}>/modules/xmarticle/viewcat.php?category_id=<{$category.id}>">
							<div class="card-header text-center" <{if $category.color != false}>style="background-color : <{$category.color}>;"<{/if}>>
								<{$category.name}>
							</div>
						</a>
						<div class="card-body h-md-550 text-center">
							<div class="row" style="height: 150px;">
								<div class="col-12 h-75">
									<{if $category.logo != ''}>
										<a title="<{$category.name}>" href="<{$xoops_url}>/modules/xmarticle/viewcat.php?category_id=<{$category.id}>">
											<img class="rounded img-fluid mh-100" src="<{$category.logo}>" alt="<{$category.name}>">
										</a>
									<{/if}>
									<div class="col-12 p-2">
										<{if $category.description != ""}>
											<button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#xmDesc-<{$category.id}>">+</button>
										<{else}>
											<button class="btn btn-secondary btn-sm" disabled data-toggle="modal">+</button>
										<{/if}>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal fade" id="xmDesc-<{$category.id}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title aligncenter"><{$category.name}></h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<{$category.description}>
							</div>
							<div class="modal-footer">
								<a title="<{$category.name}>" href="<{$xoops_url}>/modules/xmarticle/viewcat.php?category_id=<{$category.id}>"
								   class="btn btn-secondary">
									<{$category.totalarticle}>
								</a>
							</div>
						</div>
					</div>
				</div>
			<{/foreach}>
		</div>
		<div class="clear spacer"></div>
		<{if $nav_menu|default:false}>
			<div class="floatright"><{$nav_menu}></div>
			<div class="clear spacer"></div>
		<{/if}>
	<{else}>
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<{$smarty.const._MA_XMARTICLE_ERROR_NOCATEGORY}>
		</div>
	<{/if}>
</div><!-- .xmarticle -->