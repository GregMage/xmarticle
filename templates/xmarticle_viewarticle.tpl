<div class="xmarticle">
    <ol class="breadcrumb">
        <li><a href="index.php"><{$smarty.const._MA_XMARTICLE_HOME}></a></li>
        <li><a href="viewcat.php?category_id=<{$category_id}>"><{$category_name}></a></li>
        <li class="active"><{$name}></li>
    </ol>
	<{if $status == 2}>
	<div class="alert alert-warning" role="alert">
		<{$smarty.const._MA_XMARTICLE_INFO_ARTICLEWAITING}>
	</div>
	<{/if}>
	<{if $status == 0}>
	<div class="alert alert-danger" role="alert">
		<{$smarty.const._MA_XMARTICLE_INFO_ARTICLEDISABLE}>
	</div>
	<{/if}>
    <div class="media">
        <div class="media-left">
            <img class="media-object" src="<{$logo}>" alt="<{$name}>">
        </div>
        <div class="media-body">
            <h2 class="media-heading"><{$name}> (<{$reference}>)</h2>
            <{$description}>
        </div>
    </div>
    <br>
	<{if $field_count > 0}>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><{$smarty.const._MA_XMARTICLE_COMPINFORMATION}></h3>
        </div>
        <div class="panel-body">
			<{foreach item=field from=$field}>
				<{if $field.row == true}>
				<div class="row xm-article-field">
				<{/if}>
					<div class="col-md-3">
						<b><{$field.name}></b><br>
						<{$field.description}>
					</div>
					<div class="col-md-3">
						<{$field.value}>
					</div>
				<{if $field.count is div by 2 || $field.end == true}>
				</div>
				<{/if}>
			<{/foreach}>
        </div>
    </div>
	<{/if}>
	<{if $xmdoc_viewdocs == true}>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><{$smarty.const._MA_XMARTICLE_XMDOC}></h3>
        </div>
        <div class="panel-body">
            <{include file="db:xmdoc_viewdoc.tpl"}>
        </div>
    </div>
    <{/if}>
	<{if $xmstock_viewstocks == true}>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><{$smarty.const._MA_XMARTICLE_XMSTOCK}></h3>
        </div>
        <div class="panel-body">
            <{include file="db:xmstock_viewstocks.tpl"}>
        </div>
    </div>
    <{/if}>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><{$smarty.const._MA_XMARTICLE_GENINFORMATION}></h3>
        </div>
        <div class="panel-body">
			<div class="row xm-article-general">
				<div class="col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMARTICLE_DATE}>"></span>
					<{$smarty.const._MA_XMARTICLE_DATE}>: <{$date}>
				</div>
				<div class="col-md-6"><span class="glyphicon glyphicon-user" title="<{$smarty.const._MA_XMARTICLE_AUTHOR}>"></span>
					<{$smarty.const._MA_XMARTICLE_AUTHOR}>: <{$author}>
				</div>
			</div>
			<{if $mdate}>
			<div class="row xm-article-general">
				<div class="col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMARTICLE_MDATE}>"></span>
					<{$smarty.const._MA_XMARTICLE_MDATE}>: <{$mdate}>
				</div>
			</div>
			<{/if}>
			<div class="row xm-article-general">
				<div class="col-md-6"><span class="glyphicon glyphicon-repeat" title="<{$smarty.const._MA_XMARTICLE_READING}>"></span>
					<{$smarty.const._MA_XMARTICLE_READING}>: <{$counter}>
				</div>
				<div class="col-md-6"><span class="glyphicon glyphicon-star-empty" title="<{$smarty.const._MA_XMARTICLE_RATING}>"></span>
					<{$smarty.const._MA_XMARTICLE_RATING}>: <{$rating}> <{$votes}>
				</div>
			</div>
			<div class="xm-article-general-button">
				<div class="btn-group" role="group" aria-label="...">
					<a href="action.php?op=clone&amp;article_id=<{$article_id}>">
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-duplicate"></span> <{$smarty.const._MA_XMARTICLE_CLONE}></button>
                    </a>
                    <a href="action.php?op=edit&amp;article_id=<{$article_id}>">
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> <{$smarty.const._MA_XMARTICLE_EDIT}></button>
                    </a>
                    <a href="action.php?op=del&amp;article_id=<{$article_id}>">
                        <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> <{$smarty.const._MA_XMARTICLE_DEL}></button>
                    </a>
				</div>
			</div>
			
        </div>
    </div>
	<div style="text-align: center; padding: 3px; margin:3px;">
        <{$commentsnav}>
        <{$lang_notice}>
    </div>
    <div style="margin:3px; padding: 3px;">
        <{if $comment_mode == "flat"}>
        <{include file="db:system_comments_flat.tpl"}>
        <{elseif $comment_mode == "thread"}>
        <{include file="db:system_comments_thread.tpl"}>
        <{elseif $comment_mode == "nest"}>
        <{include file="db:system_comments_nest.tpl"}>
        <{/if}>
    </div>
	<div style="margin:3px; padding: 3px;">
		<{include file='db:system_notification_select.tpl'}>
    </div>
</div><!-- .xmarticle -->