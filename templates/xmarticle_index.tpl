<div class="xmarticle">
    <{if count($categories) gt 0}>
    <ol class="breadcrumb">
        <li class="active"><{$smarty.const._MA_XMARTICLE_HOME}></li>
    </ol>

    <div class="xm-category row">
        <{foreach item=category from=$categories}>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3 xm-category-list">
                <a class="btn btn-primary btn-md btn-block" title="<{$category.name}>"
                   href="<{$xoops_url}>/modules/xmarticle/viewcat.php?category_id=<{$category.id}>">
                    <{$category.name}>
                </a>

                <a title="<{$category.name}>" href="<{$xoops_url}>/modules/xmarticle/viewcat.php?category_id=<{$category.id}>" class="xm-category-image">
                    <img src="<{$category.logo}>" alt="<{$category.name}>">
                </a>

                <!-- Category Description -->
                <div class="aligncenter">
                    <{if $category.description != ""}>
                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#xmDesc-<{$category.id}>">+</button>
                    <{else}>
                        <button class="btn btn-xs disabled" data-toggle="modal">+</button>
                    <{/if}>
                </div>

                <div class="modal fade" id="xmDesc-<{$category.id}>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header"><h4 class="modal-title aligncenter"><{$category.name}></h4></div>
                            <div class="modal-body">
                                <{$category.description}>
                            </div>
                            <div class="modal-footer">
                                <a title="<{$category.name}>" href="<{$xoops_url}>/modules/xmarticle/viewcat.php?category_id=<{$category.id}>"
                                   class="pull-left btn btn-success">
                                    <{$category.totalarticle}>
                                </a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">&times;</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Category Description -->
            </div>
            <!-- .xm-category-list -->
        <{/foreach}>
    </div><!-- .xm-category -->
    <div class="clear spacer"></div>
    <{if $nav_menu}>
        <div class="floatright"><{$nav_menu}></div>
        <div class="clear spacer"></div>
    <{/if}>
    <{else}>
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <{$smarty.const._MA_XMARTICLE_ERROR_NOCATEGORY}>
        </div>
    <{/if}>
	<div style="margin:3px; padding: 3px;">
		<{include file='db:system_notification_select.tpl'}>
    </div>
</div><!-- .xmarticle -->