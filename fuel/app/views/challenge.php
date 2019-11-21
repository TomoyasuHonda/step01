<div style="text-align: center;">

    <h1 class="c-title c-title--space"><?php echo $title;?></h1>
    (目安時間<?php echo $time;?>)

    <p class="c-content"><?php echo $content;?></p>

    
    <p class="c-category">カテゴリー: <?php echo $category;?></p> 

    <!-- ここに小STEP一覧を表示する -->
    <div class="c-substep__list">
    <ul>
        <?php
        
        if(!empty($substeplist[0]['subtitle'])){
           foreach($substeplist as $value){
        if($clear_count+1 >= $value['step_number'] || $value['step_number'] == 1 ){
                echo '<a href='.'"'.'http://step0123.xsrv.jp/sample_framework03/public/temp/members/detailchallenge?step_id='.$step_id.'&challenge_id='.$challenge_id.'&substep_id='.$value['id'].'"'." class='p-challenge__substep'><li>第".$value['step_number'].'章:'; echo $value['subtitle'].'<br>'.'</li>'.'</a>';
        }
    }
    }
    
    if(!empty($substeplist[0]['subtitle'])){
            foreach($substeplist as $value){
                if($clear_count+1 < $value['step_number'] && $value['step_number'] != 1){
                echo '<li>第'.$value['step_number'].'章:'; echo $value['subtitle'].'<br>'.'</li>';
        }
    }
    }
        ?>

    </ul>
    
    </div>

    <div style="margin-bottom: 200px;">
        <a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-show-count="false">Tweet</a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
    
</div>

