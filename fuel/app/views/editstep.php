<div class="c-form--make">
<p class="c-error--msg"><?php if(!empty($time_error)) echo $time_error ?></p>
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
    <h1 class="c-title">ＳＴＥＰ☆彡編集</h1>

    <div class="c-form">

        <form action="/sample_framework03/public/temp/members/editstep/post?step_id=<?php echo $step_id; ?>" method="post">

        <div><label for="title">タイトル</label><input class="c-editform__text" type="text" value="<?php if($title) echo $title;?>" name="title"></div>

            <div class="u-category--font"><label for="category">カテゴリーを選択してください</label>
                    <select name="category" class="c-form__category">
                        <option value="<?php echo $category;?>"><?php echo $category;?></option>
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
            </div>

            <div><label for="time">目安時間</label>時間<input type="number" name="hour" class="c-form__number" value="<?php echo $hour; ?>" required>
            分<input type="number" name="minutes" class="c-form__number" value="<?php echo $minutes; ?>" required></div>

            <div><label for="step_content">紹介文(100文字以内)</label><textarea id="" cols="70" rows="6" name="content" class="c-form__content"><?php if($content) echo $content;?></textarea></div>

            <!-- ここに小STEP一覧とそれぞれの削除ボタンを表示する -->
            <div class="p-substeplist--space">
                <ul>
                    <?php
                    if(!empty($subtitle[0]['subtitle'])){
                        foreach($subtitle as $value){
                            echo '<a href='.'"'.'http://step0123.xsrv.jp/sample_framework03/public/temp/members/editsubstep?step_id='.$step_id.'&substep_id='.$value['id'].'"'."><li>第".$value['step_number'].'章:'; echo $value['subtitle'].'</li>'.'</a>';
                            echo '<button style="border: none;background: #f8c8c9;padding: 0;"><a style="display: inline-block;width: 35px;height: 19px;" href='.'"'.'http://step0123.xsrv.jp/sample_framework03/public/temp/members/deletesubstep?step_id='.$step_id.'&substep_id='.$value['id'].'"'.">".'削除'.'</a>'.'</button>'.'<br>';
                        }
                    }
                    ?>

                </ul>
                    
            </div>

            <div class="editstep_btn">
                <button type="submit" class="c-form__button">送信</button>
            </div>

            <!-- ここに小stepを追加できるボタンを表示する -->
            <div class="p-step--add">
                    <a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/addsubstep?step_id=<?php echo $step_id; ?>" class="p-button--add">小STEPを追加する</a>
            </div>

            <input type="submit" name="trash" value="削除" class="p-button--delete">

        </form>

    </div>

</div>