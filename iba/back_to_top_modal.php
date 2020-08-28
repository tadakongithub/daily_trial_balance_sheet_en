<!--index.phpに戻るときに現れるモダル-->
<div class="ui modal">

<i id="close_edit" class="massive close icon"></i>

<form class="ui form" action="" method="post" style="text-align: center">
    <p>
        <?php checkLang(
            'Data entered will be deleted if you go back to top page'
            , 'トップページに戻ると入力したデータが消去されます。');
        ?>
    </p>

    <input type="submit" name="back_to_top" value="<?php checkLang('Back to Top', 'トップページへ');?>" class="ui button">
</form>

</div>

<script>
$(document).ready(function(){
    $('#back_to_top').on('click', function(e){
        e.preventDefault();

        $('.ui.modal').modal('show');
    });
});
</script>