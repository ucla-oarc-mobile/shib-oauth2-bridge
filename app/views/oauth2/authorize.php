<div class="text-center">
    
    <?php
    echo Form::open(array(
        'url'=>'/oauth2/authorize?'.$_SERVER['QUERY_STRING'],
        'method'=>'post',
        'style'=>'display:inline;',
        'id' => 'oauth-authorize-form'));
    echo Form::token();
    echo Form::hidden('approve', '1');
    echo Form::submit('Continue');
    echo Form::close();
    
    ?>

</div>