<p class="c-successmsg--slide" id="js-show-msg" style="display:none;">
    <?php echo Session::get_flash('successMsg');?>
</p>
<div class="c-form--make">

<br>

<?php
            if(!empty($error)):
        ?>
            <ul class="area-error-msg">
        <?php 
        //バリデーションに引っかかったらこちらに表示
            foreach ($error as $key => $val):
        ?>
            <li class="c-error--msg"><?=$val?></li>
        <?php
            endforeach;
        ?>
                </ul>
        <?php
            endif;
        ?>

    <h1 class="c-title">プロフィール編集</h1>

    <div class="c-form" style="line-height: 40px;">
        <form action="/sample_framework03/public/temp/members/editprof/post" method="post" enctype="multipart/form-data">

            <div><label for="email">email<input type="email" name="email" class="c-form__text" value="<?php if(!empty($data_email)){echo $data_email;} ?>" required maxlength="250"></label></div>
       
            <div><label for="introduction">自己紹介やアピール、意気込み<br><textarea name="introduction" class="c-form__content" cols="50" rows="5"><?php if(!empty($data_email)){echo $data_introduction;};?></textarea></label></div>

            <div>
                画像
                <input type="file" name="upload_file">
                
                
                <img src="/sample_framework03/public/assets/img/<?php if(!empty($data_image)){echo $data_image;}?>" alt="画像がアップロードされていません" class="p-upload"> 

            </div>
            
            <p class="c-error--msg"><?php if(!empty($error_msg) && $error_msg != '(ファイルはアップロードされませんでした)' ){echo $error_msg;} ?></p>

            <input type="submit" name="submit" value="送信" class="c-form__button">

        </form>
        <div style="
    text-align: center;
    margin-top: 50px;
"><a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/editpass" class="c-button--frame">パスワード変更</a></div>
    </div>


</div>

<script type="text/javascript">
    
$(function(){
    //メッセージ表示
    var $jsShowMsg = $('#js-show-msg');
    var msg = $jsShowMsg.text();
    if(msg.replace(/^[\s'-']+|[\s'-']+$/g, "").length){
        $jsShowMsg.slideToggle('slow');
        setTimeout(function(){ $jsShowMsg.slideToggle('slow'); }, 5000);
    }
})
    
</script>














