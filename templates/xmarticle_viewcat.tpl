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
    <{if $articles|default:'' != ""}>
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h2 class="h2"><{$smarty.const._MA_XMARTICLE_LISTARTICLE}></h2>
			<div class="btn-toolbar mb-2 mb-md-0">
				<div class="btn-group mr-2">
					<label class="my-1 mr-2"><{$smarty.const._MA_XMARTICLE_ORDER}> </label>
					<select class="form-control form-control-sm" id="order_filter" onchange="location='viewcat.php?category_id=<{$category_id}>&sort=<{$sort}>&filter=<{$filter}>&display=<{$display}>&order='+this.options[this.selectedIndex].value">
						<option value=1 <{if $order == 1}>selected="selected"<{/if}>><{$smarty.const._MA_XMARTICLE_ORDER_NAME}></option>
						<option value=2 <{if $order == 2}>selected="selected"<{/if}>><{$smarty.const._MA_XMARTICLE_ORDER_DATE}></option>
						<option value=3 <{if $order == 3}>selected="selected"<{/if}>><{$smarty.const._MA_XMARTICLE_ORDER_VIEW}></option>
						<option value=4 <{if $order == 4}>selected="selected"<{/if}>><{$smarty.const._MA_XMARTICLE_ORDER_REF}></option>
					</select>
					<div class="form-check form-check-inline">
						&nbsp;<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" <{if $sort == 0}>checked<{/if}> onchange="location='viewcat.php?category_id=<{$category_id}>&order=<{$order}>&sort=0&filter=<{$filter}>&display=<{$display}>'">
						<label class="form-check-label" for="inlineRadio1"><span class="fa fa-arrow-down"></span></label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" <{if $sort == 1}>checked<{/if}> onchange="location='viewcat.php?category_id=<{$category_id}>&order=<{$order}>&sort=1&filter=<{$filter}>&display=<{$display}>'">
						<label class="form-check-label" for="inlineRadio2"><span class="fa fa-arrow-up"></span></label></label>
					</div>
					<select class="form-control form-control-sm" id="statut_filter" onchange="location='viewcat.php?category_id=<{$category_id}>&order=<{$order}>&sort=<{$sort}>&display=<{$display}>&filter='+this.options[this.selectedIndex].value">
						<option value=10 <{if $filter == 10}>selected="selected"<{/if}>>10&nbsp;<{$smarty.const._MA_XMARTICLE_FILTER_PERPAGE}></option>
						<option value=20 <{if $filter == 20}>selected="selected"<{/if}>>20&nbsp;<{$smarty.const._MA_XMARTICLE_FILTER_PERPAGE}></option>
						<option value=50 <{if $filter == 50}>selected="selected"<{/if}>>50&nbsp;<{$smarty.const._MA_XMARTICLE_FILTER_PERPAGE}></option>
						<option value=100 <{if $filter == 100}>selected="selected"<{/if}>>100&nbsp;<{$smarty.const._MA_XMARTICLE_FILTER_PERPAGE}></option>
					</select>
				</div>
				<button type="button" class="btn btn-sm btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmarticle/viewcat.php?category_id=<{$category_id}>&order=<{$order}>&sort=<{$sort}>&filter=<{$filter}>&display=0" <{if $display == 0}>disabled<{/if}>><span class="fa fa-id-card-o"></span></button>
				&nbsp;
				<button type="button" class="btn btn-sm btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmarticle/viewcat.php?category_id=<{$category_id}>&order=<{$order}>&sort=<{$sort}>&filter=<{$filter}>&display=1" <{if $display == 1}>disabled<{/if}>><span class="fa fa-list-alt"></span></button>
				<{if $export == true}>
				&nbsp;
				<a href="<{xoAppUrl 'modules/xmstats/export.php?op=article'}>" class="btn btn-sm btn-secondary">
					<{$smarty.const._MA_XMARTICLE_INDEX_EXPORT}>
				</a>
				<{/if}>
			</div>
		</div>
		<{if $display|default:0 == 0}>
			<div class="row row-cols-lg-4 row-cols-md-3 row-cols-1 justify-content-center">
				<{section name=i loop=$articles}><{include file="db:xmarticle_article.tpl" down=$articles[i]}><{/section}>
			</div>
		<{else}>
			<table class="table table-hover">
				<thead class="thead-light">
					<tr>
						<th scope="col"><{$smarty.const._MA_XMARTICLE_ARTICLE_REFERENCE}></th>
						<th scope="col"><{$smarty.const._MA_XMARTICLE_ARTICLE_NAME}></th>
						<th scope="col" class="text-center"><span class="fa fa-eye fa-fw" aria-hidden="true"></span></th>
						<th scope="col" class="text-center"><span class="fa fa-user fa-fw" aria-hidden="true"></span></th>
						<th scope="col" class="text-center"><span class="fa fa-calendar fa-fw" aria-hidden="true"></span></th>
					</tr>
				</thead>
				<tbody>
				<{foreach item=article from=$articles}>
					<tr>
						<td><{$article.reference}></td>
						<td><a href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?article_id=<{$article.id}>" target="_blank"><{$article.name}></a></td>
						<td class="text-center"><{$article.counter}></td>
						<td class="text-center"><{$article.author}></td>
						<td class="text-center"><{$article.date}></td>
					</tr>
				<{/foreach}>
				</tbody>
			</table>
		<{/if}>
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