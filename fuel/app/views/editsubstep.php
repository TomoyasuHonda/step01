<div style="text-align: center;" class="c-form--make">
<p class="c-error--msg"><?php if(!empty($time_error)) echo $time_error ?></p>

<?php
            if(!empty($error)):
        ?>
            <ul class="area-error-msg">
        <?php 
        //バリデーションに引っかかったらこちらに表示
            foreach ($error as $key => $val):
        ?>
            <li><?=$val?></li>
        <?php
            endforeach;
        ?>
                </ul>
        <?php
            endif;
        ?>

    <div class="c-form">

        <form action="/sample_framework03/public/temp/members/editsubstep/post?step_id=<?php echo $step_id;?>&substep_id=<?php echo $substep_id;?>" method="post">

            <div class="p-form__stepnumber">第<input class="p-stepnumber--layout" type="number" value="<?php echo $step_number;?>" name="step_number" required> 章</div> 

            <input class="c-editform__text" type="text" value="<?php echo $subtitle;?>" name="title">


            <!-- <div style="padding-top: 30px;"><label for="time">目安時間：<input type="text" value="<?php //echo $time;?>" name="time"></label></div> -->

            <div><label for="time">目安時間</label><br><input type="number" name="hour" class="c-form__number" value="<?php echo $hour; ?>" required>時間
                    <input type="number" name="minutes" class="c-form__number" value="<?php echo $minutes; ?>" required>分</div>

            <textarea id="" cols="70" rows="5" name="content" class="c-form__content"><?php echo $subcontent;?></textarea>

            <!-- ここに戻るbtnを設置 -->
            <div id="btn">
                <!-- ここに送信ボタン -->
                <div class="editstep_btn" style="">
                    <button type="submit" class="c-form__button u-button--right u-button--positionup">送信</button>
                </div>
                
                <div id="backBtn">
                    <?php echo '<a class="c-form__button u-button--left" href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/editstep?step_id='.$step_id.'">'.'戻る'.'</a>';?>
                </div>
                
            </div>
            

        </form>
    </div>
</div>