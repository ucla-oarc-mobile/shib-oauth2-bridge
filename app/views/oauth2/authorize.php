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

<script type="text/javascript">
(function(){
    var p = function(){ document.getElementById('oauth-authorize-form').submit(); }
    document.addEventListener('DOMContentLoaded', p);
    window.addEventListener('load', p);
})();
</script>