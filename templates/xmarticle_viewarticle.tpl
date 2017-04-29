<div class="xmarticle">
    <ol class="breadcrumb">
        <li><a href="index.php"><{$smarty.const._MA_XMARTICLE_HOME}></a></li>
        <li><a href="viewcat.php?category_id=<{$category_id}>"><{$category_name}></a></li>
        <li class="active"><{$name}></li>
    </ol>
    <div class="media">
        <div class="media-left">
            <img class="media-object" src="<{$logo}>" alt="<{$name}>">
        </div>
        <div class="media-body">
            <h2 class="media-heading"><{$name}> (<{$category_reference}><{$reference}>)</h2>
            <{$description}>
        </div>
    </div>
    <br>
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
					<{$smarty.const._MA_XMARTICLE_AUTHOR}>:<{$author}>
				</div>
			</div>
			<{if $mdate}>
			<div class="row xm-article-general">
				<div class="col-md-6"><span class="glyphicon glyphicon-calendar" title="<{$smarty.const._MA_XMARTICLE_MDATE}>"></span>
					<{$smarty.const._MA_XMARTICLE_MDATE}>: <{$mdate}>
				</div>
			</div>
			<{/if}>
			<div class="xm-article-general-button">
				<div class="btn-group" role="group" aria-label="...">
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-duplicate"></span> <{$smarty.const._MA_XMARTICLE_CLONE}></button>
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span> <{$smarty.const._MA_XMARTICLE_EDIT}></button>
					<button type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> <{$smarty.const._MA_XMARTICLE_DEL}></button>
				</div>
			</div>
			
        </div>
    </div>
</div><!-- .xmarticle -->