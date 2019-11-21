<div class="c-form--make">

<br>
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

    <p class="p-form--count">第<?php if(!empty($count_sub_step)){echo intval($count_sub_step + 1);}else{echo 1;}?>章</p> 
 
    <div class="c-form">

        <form action="/sample_framework03/public/temp/members/register/subpost" method="post" enctype="multipart/form-data" id="step_form">

            <div><label for="title">タイトル</label><input type="text" name="substep_title" class="c-form__text" value="" placeholder="第1章~if文をマスターしよう!!" required maxlength="250"></div>
        
            <div><label for="time">目安時間</label><input type="number" name="substep_hour" class="c-form__number" value="1" required>時間
            <input type="number" name="substep_minutes" class="c-form__number" value="00" required>分</div>
       
            <div><label for="step_content">内容(100以内)</label><textarea name="sub_content" class="c-form__content" cols="50" rows="5" required maxlength="250"></textarea></div>

            <input type="submit" name="submit" value="第<?php if(!empty($count_sub_step)){echo intval($count_sub_step + 1);}else{echo 1;}?>章を登録する" class="c-form__button p-form__button--long">

       
            
        </form>
        
        <div style="text-align: center;"><a class="c-step--finish" href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/mypage">完了or中断</a></div> 

    </div>

    <br>

</div>














