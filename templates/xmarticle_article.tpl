<div class="col mb-3">
	<div class="card h-100 xmnews-border" <{if $down.color != false}>style="border-color : <{$down.color}>;"<{/if}>>
		<div class="card-header" <{if $down.color != false}>style="background-color : <{$down.color}>;"<{/if}>>
			<div class="d-flex justify-content-center text-center">
				<h5 class="mb-0 text-white"><{$down.name}></h5>
			</div>
		</div>

		<{if $down.logo != ''}>
			<img class="img-fluid" src="<{$down.logo}>" alt="<{$down.name}>">
		<{/if}>

		<div class="card-body">
			<{$down.description|truncateHtml:30:'...'}>
			<div class="text-right mt-1 ">
				<button type="button" class="btn btn-primary btn-sm text-right" onclick=window.location.href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$down.cid}>&amp;article_id=<{$down.id}>"><span class="fa fa-book" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_MOREDETAILS}></button>
			</div>
		</div>
		<div class="card-footer text-secondary">
			<div class="row">
				<{if $down.douser == 1}>
					<div class="col-5 text-left">
						<span class="fa fa-user fa-fw" aria-hidden="true"></span> <{$down.author}>
					</div>
				<{/if}>
				<{if $down.dodate == 1}>
					<div class="col-7 text-right">
						<span class="fa fa-calendar fa-fw" aria-hidden="true"></span> <{$down.date}>
					</div>
				<{/if}>

			</div>
			<div class="row">
				<{if $down.dohits == 1}>
					<div class="col-5 text-left">
						<span class="fa fa-eye fa-fw" aria-hidden="true"></span> <{$down.counter}>
					</div>
				<{/if}>
				<{if $down.domdate == 1}>
					<{if $down.mdate|default:false}>
						<div class="col-7 text-right">
							<span class="fa fa-repeat fa-fw" aria-hidden="true"></span> <{$down.mdate}>
						</div>
					<{/if}>
				<{/if}>
			</div>
			<{if $down.dorating == 1}>
				<{if $xmsocial == true}>
					<div class="row">
						<div class="col">
							<span class="fa fa-star" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_RATING}> <{$down.rating}>
						</div>
					</div>
				<{/if}>
			<{/if}>
		</div>
	</div>
</div>
