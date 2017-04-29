<div class="xmarticle">
    <{if $error_message}>
        <div class="alert alert-danger" role="alert"><{$error_message}></div>
    <{else}>
        <div class="xmform">
            <{$form}>
        </div>
    <{/if}>
</div><!-- .xmarticle -->