<div class="xmarticle">
	<nav aria-label="breadcrumb">
	  <ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php"><{$index_module}></a></li>
		<li class="breadcrumb-item"><a href="viewcat.php?category_id=<{$category_id}>"><{$category_name}></a></li>
		<li class="breadcrumb-item active" aria-current="page"><{$name}></li>
	  </ol>
	</nav>
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
	<div class="row mb-2">
		<div class="col-md-12">
			<div class="card" <{if $category_color != false}>style="border-color : <{$category_color}>;"<{/if}>>
				<div class="card-header category_color" <{if $category_color != false}>style="background-color : <{$category_color}>;"<{/if}>>
					<div class="d-flex justify-content-between">
						<h3 class="mb-0 text-white"><{$name}> (<{$reference}>)</h3>
						<{if $dohits == 1}>
							<div class="row align-items-center text-right">
								<div class="col">
									<span class="badge badge-secondary fa-lg text-primary ml-2"><span class="fa fa-eye fa-lg" aria-hidden="true"></span><small> <{$counter}></small></span>
								</div>	
							</div>	
						<{/if}>
					</div>
				</div>
				<{if ($douser == 1) || ($dodate == 1) || (($domdate == 1) && ($mdate)) || ($dorating == 1) }> 
					<div class="row border-bottom border-secondary mx-1 pl-1">
						<{if $douser == 1}>
							<figure class="figure text-muted my-1 pr-2 text-center border-right border-secondary">
								  <span class="fa fa-user fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_AUTHOR}>
								  <figcaption class="figure-caption text-center"><{$author}></figcaption>
							</figure>
						<{/if}>
						<{if ($dodate == 1) && (($domdate == 1) && ($mdate|default:false)) && ($douser == 1)}>
							<figure class="figure text-muted m-1 pr-2 text-center border-right border-secondary">
								  <span class="fa fa-calendar fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_ARTICLE_PUBLISHED_BT}>
								  <figcaption class="figure-caption text-center d-none d-md-block"><{$date}></figcaption>
								  <figcaption class="figure-caption text-center d-block d-md-none"><{$date|truncate:10:''}> </figcaption>
							</figure>
						<{else}>
							<{if $dodate == 1}>
								<figure class="figure text-muted m-1 pr-2 text-center border-right border-secondary">
									  <span class="fa fa-calendar fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_ARTICLE_PUBLISHED_BT}>
									  <figcaption class="figure-caption text-center"><{$date}></figcaption>
								</figure>
							<{/if}>
						<{/if}>	
						<{if $domdate == 1}>
							<{if $mdate|default:false}>
								<figure class="figure text-muted m-1 pr-2 text-center border-right border-secondary">
									<span class="fa fa-repeat fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_ARTICLE_MDATE_BT}>
									<figcaption class="figure-caption text-center"><{$mdate}></figcaption>
								</figure>
							<{/if}>
						<{/if}>
						<{if $dorating == 1}>
							<figure class="text-muted m-1 pr-2 text-center border-right border-secondary">
								<span class="d-block"><{include file="db:xmsocial_rating.tpl" down_xmsocial=$xmsocial_arr}></span>
								<figcaption class="figure-caption text-center"></figcaption>
							</figure>	
						<{/if}>
					</div>
				<{/if}>
				<div class="d-block d-md-none pt-2 px-4">
					<{if $logo != ''}>
						<img class="card-img-top rounded img-fluid" src="<{$logo}>" alt="<{$name}>">
					<{/if}>
				</div>
				<div class="card-body">
					<p class="card-text mb-auto">
						<div class="row">
							<div class="col">
								<{if $logo != ''}>
									<img class="col-3 rounded float-right d-none d-md-block" src="<{$logo}>" alt="<{$name}>">
								<{/if}>
								<p>
								<{$description}>
								</p>
							</div>
						</div>
					</p>
					<div class="w-100"></div>
					<{if $social == true}>
						<{include file="db:xmsocial_social.tpl"}>
						<br>
					<{/if}>
					<{if $xmdoc_viewdocs|default:false == true}>
					<div class="col-12 pl-4 pr-4 pb-4">
						<div class="card">
							<div class="card-header">
								<{$smarty.const._MA_XMNEWS_NEWS_XMDOC}>
							</div>
							<div class="card-body">
								<{include file="db:xmdoc_viewdoc.tpl"}>
							</div>
						</div>
					</div>
					<div class="w-100"></div>
					<{/if}>
				</div>
			</div>
		</div>				
	</div>
	<{if ($perm_edit == true) || ($perm_clone == true) || ($perm_del == true)}> 
		<div class="col-12 pl-4 pr-4 pb-2">
			<div class="text-center pt-2">
				<div class="btn-group text-center" role="group">
					<{if $perm_edit == true}>
						<a class="btn btn-secondary" href="action.php?op=edit&amp;article_id=<{$article_id}>"><span class="fa fa-edit" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_EDIT}></a>
					<{/if}>
					<{if $perm_clone == true}>
						<a class="btn btn-secondary" href="action.php?op=clone&amp;article_id=<{$article_id}>"><span class="fa fa-clone" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_CLONE}></a>
					<{/if}>
					<{if $perm_del == true}>
						<a class="btn btn-secondary" href="action.php?op=del&amp;article_id=<{$article_id}>"><span class="fa fa-trash" aria-hidden="true"></span> <{$smarty.const._MA_XMARTICLE_DEL}></a>
					<{/if}>
				</div>
			</div>
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