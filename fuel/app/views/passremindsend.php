<div>

<p class="p-exception--error"><?php if(!empty($error)) echo $error;?></p>

        <p class="c-text--remind">ご指定のメールアドレス宛に<br>パスワード再発行用のURLと認証キーをお送りします</p>

        <p class="p-exception--error"><?php if(!empty($errorMsg)) echo $errorMsg;?></p>
        
        <form action="http://step0123.xsrv.jp/sample_framework03/public/temp/passremindsend/post" method="post" class="c-form--remind">

            <label for="email" class="c-form__label--remind">メールアドレス
                <input type="email" name="email" class="c-form__input--remind" placeholder="sample@test.com" required>
            </label>

            <input type="submit" type="送信" class="c-form__button--remind">
        </form>

        <div>
            
        </div>

</div>