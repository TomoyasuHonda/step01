<div>

        <p class="c-text--remind">ご指定のメールアドレスに送りした<br>メール内にある認証キーを入力してください</p>

        <p><?php
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
        ?></p>
        
        <form action="http://step0123.xsrv.jp/sample_framework03/public/temp/passremindrecieve/post" method="post" class="c-form--remind">

            <label for="text" class="c-form__label--remind">認証キー
                <input type="text" name="auth_key" class="c-form__input--remind" required>
            </label>

            <input type="submit" type="送信" class="c-form__button--remind">
        </form>

        <div>
            
        </div>

</div>