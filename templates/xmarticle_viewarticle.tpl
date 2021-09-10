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
						<h3 class="mb-0 text-white"><{$title}></h3>
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
								  <span class="fa fa-user fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMNEWS_NEWS_PUBLISHEDBY_BT}>
								  <figcaption class="figure-caption text-center"><{$author}></figcaption>
							</figure>
						<{/if}>
						<{if ($dodate == 1) && (($domdate == 1) && ($mdate|default:false)) && ($douser == 1)}>
							<figure class="figure text-muted m-1 pr-2 text-center border-right border-secondary">
								  <span class="fa fa-calendar fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMNEWS_NEWS_PUBLISHED_BT}>
								  <figcaption class="figure-caption text-center d-none d-md-block"><{$date}></figcaption>
								  <figcaption class="figure-caption text-center d-block d-md-none"><{$date|truncate:10:''}> </figcaption>
							</figure>
						<{else}>
							<{if $dodate == 1}>
								<figure class="figure text-muted m-1 pr-2 text-center border-right border-secondary">
									  <span class="fa fa-calendar fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMNEWS_NEWS_PUBLISHED_BT}>
									  <figcaption class="figure-caption text-center"><{$date}></figcaption>
								</figure>
							<{/if}>
						<{/if}>	
						<{if $domdate == 1}>
							<{if $mdate|default:false}>
								<figure class="figure text-muted m-1 pr-2 text-center border-right border-secondary">
									<span class="fa fa-repeat fa-fw" aria-hidden="true"></span> <{$smarty.const._MA_XMNEWS_NEWS_MDATE_BT}>
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
						<{if $CAT == true}><a href="index.php?news_cid=<{$category_id}>"><{/if}><img class="card-img-top rounded img-fluid" src="<{$logo}>" alt="<{$title}>"><{if $CAT == true}></a><{/if}>
					<{/if}>
				</div>
				<div class="card-body">
					<p class="card-text mb-auto">
						<div class="row">
							<div class="col">
								<{if $logo != ''}>
								<{if $CAT == true}>
								<a href="index.php?news_cid=<{$category_id}>">
								<{/if}>
								<img class="col-3 rounded float-right d-none d-md-block" src="<{$logo}>" alt="<{$title}>">
								<{if $CAT == true}>
								</a>
								<{/if}>
								<{/if}>
								<p>
								<{$news}>
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

	<{if $navigation == true}>
		<div class="row justify-content-between mt-3 mb-2">
			<div class="col-12 col-lg-6 mb-3">
				<{if $news_before_status == true}>
					<a href="article.php?news_id=<{$news_before_id}>" class="btn btn-primary btn-block" <{if news_before_color != false}>style="border-color : <{$news_before_color}>;"<{/if}>">
						<div class="d-flex justify-content-between align-items-center">
							<div class="text-left"><span class="fa fa-long-arrow-left fa-2x"></span></div>
							<div class="text-right">
								<span class="text-muted"><span class="fa fa-newspaper-o"></span> <small><{$news_before_text}></small></span><br />
								<h5><{$news_before_title}></h5>
							</div>
						</div>
					</a>
				<{/if}>
			</div>
			<div class="col-12 col-lg-6 mb-3">
				<{if $news_after_status == true}>
					<a href="article.php?news_id=<{$news_after_id}>" class="btn btn-primary btn-block" <{if $news_after_color != false}>style="border-color : <{$news_after_color}>;"<{/if}>">
						<div class="d-flex justify-content-between align-items-center">
							<div class="text-left">
								<span class="text-muted"><span class="fa fa-newspaper-o"></span> <small><{$news_after_text}></small></span><br />
								<h5><{$news_after_title}></h5>
							</div>
							<div class="text-right"><span class="fa fa-long-arrow-right fa-2x"></span></div>
						</div>
					</a>
				<{/if}>
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