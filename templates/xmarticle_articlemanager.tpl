<!doctype html>
<html lang="<{$xoops_langcode}>">
<head>
    <meta http-equiv="content-type" content="text/html; charset=<{$xoops_charset}>">
    <meta http-equiv="content-language" content="<{$xoops_langcode}>">
    <title>Xmarticle manager</title>
    <link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl 'xoops.css'}>">
	<link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl 'modules/system/css/admin.css'}>">
    <link rel="stylesheet" type="text/css" media="screen" href="<{xoAppUrl 'media/font-awesome/css/font-awesome.min.css'}>">
	<{if $bootstrap_css != ''}>
	<link rel="stylesheet" type="text/css" media="screen" href="<{$bootstrap_css}>">
	<{/if}>

</head>

<body onload="window.resizeTo(<{$xsize|default:1024}>, <{$ysize|default:768}>);window.moveTo(400,300);">
	<div class="m-3">
		<div class="card text-center mb-3">
			<{if $selected|default:false}>
				<div class="card-header">
					<{$smarty.const._MA_XMARTICLE_FORMARTICLE_SELECTED}>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-6 col-sm-3 col-lg-2 p-1">
							<div class="card">
								<div class="card-body text-center text-truncate"><strong><{$selarticle_arr.name}></strong><br><img src="<{$selarticle_arr.logo}>" alt="<{$selarticle_arr.name}>" style="max-width:150px"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer">
					<form class="text-center" name="selreset" id="selreset" action="articlemanager.php" method="post">
						<input type="hidden" name="selectreset" value="true" />
						<input type='submit' class='btn btn-warning' name='subselect'  id='subselect' value='<{$smarty.const._MA_XMARTICLE_FORMARTICLE_RESETSELECTED}>' title='<{$smarty.const._MA_XMARTICLE_FORMARTICLE_RESETSELECTED}>'  />
						<input class='btn btn-success' value="<{$smarty.const._MA_XMARTICLE_FORMARTICLE_VALIDATE}>" type="button" onclick="window.close();"/>
					</form>
				</div>
			<{else}>
				<div class="card-header"><{$smarty.const._MA_XMARTICLE_FORMARTICLE_NOARTICLESELECTED}></div>
			<{/if}>
		</div>

		<div class="card text-center mb-3">
			<div class="card-header"><{$smarty.const._MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD}></div>
			<div class="card-body">
				<div class="row mx-2 d-flex align-items-center">
					<div class="col-9 border-right">
						<{if $form}>
							<div class="xmform mb-3">
								<h5><{$smarty.const._MA_XMARTICLE_SEARCH}></h5>
								<{$form}>
							</div>
						<{/if}>
					</div>
					<div class="col-3">
						<a href="<{$xoops_url}>/modules/xmarticle/action.php?op=add" class="btn btn-secondary btn-sm" target="_blank" role="button" aria-pressed="true" title="<{$smarty.const._MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD}>">
							<{$smarty.const._MA_XMARTICLE_FORMARTICLE_ARTICLE_ADD}>
						</a>
					</div>
				</div>
					<{if $error_message|default:'' != ''}>
						<div class="errorMsg text-left mt-2">
							<{$error_message}>
						</div>
					<{/if}>
					<{if $article|default:'' != ""}>
						<div class="">
							<form name="formsel" id="formsel" action="articlemanager.php" method="post">
								<table class="table table-hover table-striped table-bordered mt-4" id="">
									<thead>
										<tr class="table-secondary">
											<th class="text-center" colspan="4" ><{$smarty.const._MA_XMARTICLE_FORMARTICLE_LISTARTICLE}> <span class="badge badge-pill badge-info"><{$article_count}></span></th>
										</tr>
										<tr class="table-secondary">
											<th class="text-center"><{$smarty.const._MA_XMARTICLE_FORMARTICLE_SELECT}></th>
											<th class="text-center"><{$smarty.const._MA_XMARTICLE_ARTICLE_LOGO}></th>
											<th class="text-left"><{$smarty.const._MA_XMARTICLE_ARTICLE_NAME}></th>
										</tr>
									<thead>
									<tbody>
									<{foreach item=article from=$articles}>
										<tr class="table-primary" scope="row">
											<td class="align-middle text-center">
												<fieldset>
													<div class="form-group">
														<div class="custom-control custom-radio">
															<input type="radio" name="selArticle" id="selArticle<{$article.id}>" class="custom-control-input" value="<{$article.id}>" >
															<label class="custom-control-label" for="selArticle<{$article.id}>"></label>
														</div>
													</div>
												</fieldset>
											</td>
											<td class="align-middle text-center">
												<img src="<{$article.logo}>" alt="<{$article.name}>" style="max-width:150px">
											</td>
											<td class="align-middle text-left">
												<{$article.name}>
											</td>
										</tr>
									<{/foreach}>
									</tbody>
								</table>
							<input type='submit' class='btn btn-success' name='select'  id='select' value='<{$smarty.const._MA_XMARTICLE_FORMARTICLE_SELECT}>' title='<{$smarty.const._MA_XMARTICLE_FORMARTICLE_SELECT}>'  />
							</form>
						</div>
					<{/if}>
			</div>
		</div>

		<div class="clear spacer"></div>
		<{if $nav_menu|default:false}>
			<div class="floatright"><{$nav_menu}></div>
			<div class="clear spacer"></div>
		<{/if}>
	</div>
	<div id="footer" class="text-center">
		<input value="<{$smarty.const._CLOSE}>" type="button" class='btn btn-secondary' onclick="window.close();"/>
	</div>
</body>
</html>
