<div style="text-align: center;">
    <h1 class="c-title--space c-title"><?php echo $title;?></h1>
    (目安時間<?php echo $time;?>)

    <p class="c-content"><?php echo $content;?></p>

    
    <p class="c-category">カテゴリー: <?php echo $category;?></p> 

    <!-- ここに小STEP一覧を表示する -->
    <div class="c-substep__list">
        <ul>
            <?php
                if(!empty($substeplist[0]['subtitle'])){
                foreach($substeplist as $value){
                    echo '<li>'. '第'.$value['step_number'].'章:'; echo $value['subtitle'].'<br>'.'</li>';
            }
        }
            ?>
            <a class="p-link__humaninfo c-button--frame" href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/humaninfo?step_id=<?php echo $step_id;?>">作った人物について</a><br><br>
            <a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/challenge?step_id=<?php echo $step_id;?>" class="p-button--challenge">チャレンジ</a>

        </ul>
    
    </div>
    
    
    
    
</div>

