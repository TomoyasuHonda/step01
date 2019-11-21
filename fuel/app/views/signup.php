
<div class="c-auth__form">
    <section class="ctn-form">
        <h1 class="c-auth__title">ユーザー登録</h1>

        <p class="p-exception--error"><?php if(!empty($exception)) echo $exception;?></p>
        
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

        <div class="authform">
            <?=$signupform //こちらにphp側で作成したformを導入する?>
        </div>
    </section>

</div>