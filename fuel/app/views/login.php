<div class="c-auth__form">
    <section class="ctn-form">
        <h1 class="c-auth__title">ログイン</h1>

        <p class="p-exception--error"><?php if(!empty($errorMsg)) echo $errorMsg;?></p>
        <p class="p-exception--error"><?php if(!empty($exception)) echo $exception;?></p>
        
        <?php
            if(!empty($error)):
        ?>
            <ul class="area-error-msg">
        <?php 
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
            <?=$loginform?>
            <p style="display: block;
    color: white;
    font-size: 20px;
    height: 100px;
    text-align: center;
    line-height: 20px;
    ">
                <?php echo Html::anchor('temp/passremindsend', 'パスワード忘れた方はこちら', array('id' => 'a1', 'class' => 'sample'));?>
            </p>
        </div>

    </section>

</div>

