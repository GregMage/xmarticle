<table class="table table-striped">
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
<{foreach item=article from=$block.article}>
	<tr>
		<td><{$article.name}></td>
		<td><{$article.reference}></td>
		<td><{$article.description|truncateHtml:50:'...'}></td>
		<td><{$article.author}></td>
		<td>
			<a href="<{$xoops_url}>/modules/xmarticle/action.php?op=edit&amp;article_id=<{$article.id}>">
				<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> <{$smarty.const._MA_XMARTICLE_EDIT}></button>
			</a>
		</td>
	</tr>
<{/foreach}>
	</tbody>
</table>