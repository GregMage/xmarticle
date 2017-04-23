<div class="xmarticle">
    <ol class="breadcrumb">
        <li><a href="index.php"><{$smarty.const._MA_XMARTICLE_HOME}></a></li>
        <li><a href="index.php"><{$category_name}></a></li>
        <li class="active"><{$name}></li>
    </ol>
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
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><{$smarty.const._MA_XMARTICLE_COMPINFORMATION}></h3>
        </div>
        <div class="panel-body">
            Panel content
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><{$smarty.const._MA_XMARTICLE_GENINFORMATION}></h3>
        </div>
        <div class="panel-body">
            Panel content
        </div>
    </div>
</div><!-- .xmarticle -->