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
	<{if $articles|default:'' != ""}>
		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
			<h2 class="h2"><{$smarty.const._MA_XMARTICLE_LISTARTICLE}> <span class="badge badge-pill badge-info"><{$article_count}></span></h2>
			<div class="btn-toolbar mb-2 mb-md-0">
				<div class="btn-group mr-2">
					<label class="my-1 mr-2"><{$smarty.const._MA_XMARTICLE_ORDER}> </label>
					<select class="form-control form-control-sm" id="order_filter" onchange="location='search.php?op=search&<{$arguments}>&sort=<{$sort}>&filter=<{$filter}>&display=<{$display}>&order='+this.options[this.selectedIndex].value">
						<option value=1 <{if $order == 1}>selected="selected"<{/if}>><{$smarty.const._MA_XMARTICLE_ORDER_NAME}></option>
						<option value=2 <{if $order == 2}>selected="selected"<{/if}>><{$smarty.const._MA_XMARTICLE_ORDER_DATE}></option>
						<option value=3 <{if $order == 3}>selected="selected"<{/if}>><{$smarty.const._MA_XMARTICLE_ORDER_VIEW}></option>
						<option value=4 <{if $order == 4}>selected="selected"<{/if}>><{$smarty.const._MA_XMARTICLE_ORDER_REF}></option>
					</select>
					<div class="form-check form-check-inline">
						&nbsp;<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1" <{if $sort == 0}>checked<{/if}> onchange="location='search.php?op=search&<{$arguments}>&order=<{$order}>&sort=0&filter=<{$filter}>&display=<{$display}>'">
						<label class="form-check-label" for="inlineRadio1"><span class="fa fa-arrow-down"></span></label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" <{if $sort == 1}>checked<{/if}> onchange="location='search.php?op=search&<{$arguments}>&order=<{$order}>&sort=1&filter=<{$filter}>&display=<{$display}>'">
						<label class="form-check-label" for="inlineRadio2"><span class="fa fa-arrow-up"></span></label></label>
					</div>
					<select class="form-control form-control-sm" id="statut_filter" onchange="location='search.php?op=search&<{$arguments}>&order=<{$order}>&sort=<{$sort}>&display=<{$display}>&filter='+this.options[this.selectedIndex].value">
						<option value=1 <{if $filter == 1}>selected="selected"<{/if}>>1&nbsp;<{$smarty.const._MA_XMARTICLE_FILTER_PERPAGE}></option>
						<option value=2 <{if $filter == 2}>selected="selected"<{/if}>>2&nbsp;<{$smarty.const._MA_XMARTICLE_FILTER_PERPAGE}></option>
						<option value=5 <{if $filter == 5}>selected="selected"<{/if}>>5&nbsp;<{$smarty.const._MA_XMARTICLE_FILTER_PERPAGE}></option>
						<option value=10 <{if $filter == 10}>selected="selected"<{/if}>>10&nbsp;<{$smarty.const._MA_XMARTICLE_FILTER_PERPAGE}></option>
					</select>
				</div>
				<button type="button" class="btn btn-sm btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmarticle/search.php?op=search&start=<{$start}>&<{$arguments}>&order=<{$order}>&sort=<{$sort}>&filter=<{$filter}>&display=0" <{if $display == 0}>disabled<{/if}>><span class="fa fa-id-card-o"></span></button>
				&nbsp;
				<button type="button" class="btn btn-sm btn-secondary" onclick=window.location.href="<{$xoops_url}>/modules/xmarticle/search.php?op=search&start=<{$start}>&<{$arguments}>&order=<{$order}>&sort=<{$sort}>&filter=<{$filter}>&display=1" <{if $display == 1}>disabled<{/if}>><span class="fa fa-list-alt"></span></button>
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
						<td><a href="<{$xoops_url}>/modules/xmarticle/viewarticle.php?category_id=<{$article.cid}>&amp;article_id=<{$article.id}>" target="_blank"><{$article.name}></a></td>
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
    <{if $no_article|default:false}>
        <div class="alert alert-danger" role="alert"><{$smarty.const._MA_XMARTICLE_ERROR_NOARTICLE}></div>
    <{/if}>
</div><!-- .xmarticle -->