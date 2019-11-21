<div style="text-align: center;">
    <h1 class="c-title c-title--space"><?php echo $title;?></h1>
    (目安時間<?php echo $time;?>)

    <p class="c-content"><?php echo $content;?></p>

    <!-- ここに戻るbtnを設置 -->
    <?php echo '<a  class="p-button--back" href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/challenge?step_id='.$step_id.'&challenge_id='.$challenge_id.'">'.'戻る'.'</a>';?>

    <!-- ここにクリアbtnを設置 -->
    <button class="p-button--clear">
        <?php echo '<a class="p-button__link--clear" href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/detailchallenge/clear?step_id='.$step_id.'&substep_id='.$substep_id.'&challenge_id='.$challenge_id.'">'.'クリア'.'</a>';?>
    </button>
    
    

    <!-- ここに小STEP一覧を表示する -->
    <div class="p-list--substep">
    <ul>
        <?php
            foreach($subtitle as $value){
        if($clear_count+1 >= $value['step_number'] || $value['step_number'] == 1 ){
                echo '<a href='.'"'.'http://step0123.xsrv.jp/sample_framework03/public/temp/members/detailchallenge?step_id='.$step_id.'&challenge_id='.$challenge_id.'&substep_id='.$value['id'].'"'." class='p-challenge__substep'><li>第".$value['step_number'].'章:'; echo $value['subtitle'].'<br>'.'</li>'.'</a>';
        }
    }

            foreach($subtitle as $value){
                if($clear_count+1 < $value['step_number'] && $value['step_number'] != 1){
                echo '<li>第'.$value['step_number'].'章:'; echo $value['subtitle'].'<br>'.'</li>';
        }
    }
        ?>

    </ul>

    </div>
    
</div>

