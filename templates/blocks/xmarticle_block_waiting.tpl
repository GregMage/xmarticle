<{if $block.article|default:'' != ''}>
	<table class="table table-striped table-hover table-sm">
		<thead class="thead-light">
			<tr>
				<th scope="col"><{$smarty.const._MA_XMARTICLE_ARTICLE_NAME}></th>
				<th scope="col"><{$smarty.const._MA_XMARTICLE_ARTICLE_REFERENCE}></th>
				<th scope="col"><{$smarty.const._MA_XMARTICLE_ARTICLE_DESC}></th>
				<th scope="col"><{$smarty.const._MA_XMARTICLE_USERID}></th>
				<th scope="col"><{$smarty.const._MA_XMARTICLE_ACTION}></th>
			</tr>
		</thead>
		<tbody>
	<{foreach item=waitingarticle from=$block.article}>
		<tr>
			<td><{$waitingarticle.name}></td>
			<td><{$waitingarticle.reference}></td>
			<td><{$waitingarticle.description}></td>
			<td><{$waitingarticle.author}></td>
			<td>
				<a href="<{$xoops_url}>/modules/xmarticle/action.php?op=edit&amp;article_id=<{$waitingarticle.id}>">
					<button type="button" class="btn btn-outline-primary"><i class="fa fa-edit"></i></button>
				</a>
			</td>
		</tr>
	<{/foreach}>
		</tbody>
	</table>
<{else}>
	<div class="alert alert-primary"><{$smarty.const._MA_XMARTICLE_BLOCKS_NOWAITING}></div>
<{/if}>