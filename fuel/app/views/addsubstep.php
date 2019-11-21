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

    <h1 class="c-title">小ＳＴＥＰ☆彡登録</h1><p class="c-subtitle">(※登録内容の編集や追加、削除はマイページの登録済み一覧から行ってください)</p>
    <br>
    <p class="p-form--count">第<?php if(!empty($count_substep)){echo intval($count_substep + 1);}else{echo 1;}?>章</p> 
    <br>
    <div class="c-form">

        <form action="/sample_framework03/public/temp/members/addsubstep/post?step_id=<?php echo $step_id;?>" method="post" enctype="multipart/form-data" id="step_form">

            <div><label for="title">タイトル</label><input type="text" name="substep_title" class="c-form__text" value="" placeholder="第1章~if文をマスターしよう!!" required></div>

            <div><label for="time">目安時間</label><input type="number" name="substep_hour" class="c-form__number" value="1" required>時間
            <input type="number" name="substep_minutes" class="c-form__number" value="00" required>分</div>
 
            <div><label for="step_content" class="u-label-style">内容</label><textarea name="sub_content" class="c-form__content" cols="50" rows="5" required></textarea></div>

            <input type="submit" name="submit" value="第<?php if(!empty($count_substep)){echo intval($count_substep + 1);}else{echo 1;}?>章を登録する" class="c-form__button p-form__button--long">
            
        </form>

    </div>

</div>