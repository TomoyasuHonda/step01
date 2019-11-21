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

    <h1 class="c-title">ＳＴＥＰ☆彡登録</h1>
    <br>

    <div class="c-form">

        <form action="/sample_framework03/public/temp/members/register/mainpost" method="post" enctype="multipart/form-data" id="step_form">

            <label for="title">タイトル</label><input type="text" name="step_title" class="c-form__text" value="<?php if(!empty($_POST['step_title'])) echo $_POST['step_title']; ?>" placeholder="私のプログラミング学習記録" required maxlength="250">
   
            <label for="category" class="u-category--font">カテゴリーを選択してください</label>
                <select name="step_category" form="step_form" id="category" class="c-form__category">
                    <option disabled selected value>Choose...</option>
                    <option value="プログラミング">プログラミング</option>
                    <option value="外国語">外国語</option>
                    <option value="数学">数学</option>
                    <option value="国語">国語</option>
                    <option value="社会学">社会学</option>
                    <option value="科学">科学</option>
                    <option value="芸術">芸術</option>
                    <option value="料理">料理</option>
                    <option value="その他">その他</option>
                </select>
            
       
            <label for="time">目安時間</label><input type="number" name="step_hour" class="c-form__number" value="1" required>時間

            <input type="number" name="step_minutes" class="c-form__number" value="00" required>分
       
            <label for="step_content">紹介文(100文字以内)</label><textarea name="main_content" class="c-form__content" cols="55" rows="6" required maxlength="250"><?php if(!empty($_POST['main_content'])) echo $_POST['main_content']; ?></textarea>

            <input type="submit" name="submit" value="送信" class="c-form__button">
            
        </form>

    </div>


</div>














