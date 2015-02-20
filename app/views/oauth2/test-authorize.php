<div class="text-center">

    <?php
    echo Form::open(array(
        'url'=>'/oauth2/test-authorize?'.$_SERVER['QUERY_STRING'],
        'method'=>'post',
        'style'=>'display:inline;',
        'id' => 'oauth-authorize-form'));

    echo Form::token();

    echo Form::hidden('approve', '1');

    echo Form::label('eduPersonPrincipalName', 'eduPersonPrincipalName');
    echo Form::text('eduPersonPrincipalName');

    echo Form::label('givenName', 'givenName');
    echo Form::text('givenName');

    echo Form::label('sn', 'sn');
    echo Form::text('sn');

    echo Form::label('mail', 'mail');
    echo Form::text('mail');

    echo Form::label('eduPersonScopedAffiliation', 'eduPersonScopedAffiliation');
    echo Form::textarea('eduPersonScopedAffiliation');

    echo Form::submit('Continue');

    echo Form::close();

    ?>

</div>

<style>
label, input, textarea {
    display: block;
}
input, textarea{
    margin-bottom: 1em;
}
label {
    font-weight: bold;
    line-height: 1.4;
}
</style>
