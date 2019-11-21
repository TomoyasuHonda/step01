<div class="p-register">
<p class="c-successmsg--slide" id="js-show-msg" style="display:none;">
    <?php echo Session::get_flash('successMsg');?>
</p>
<p class="p-exception--error"><?php if(!empty($exception)) echo $exception;?></p>
    <h1 class="c-title">登録済みのStep</h1>
    
    <div>
          <img src="https://illust.download/wp-content/uploads/2018/09/tegaki42_2top-768x543.jpg" alt="" class="p-image--flower">
      </div>
      
    <div id="appp"><br>
    
        <div id="app2">
                <ul>
                    <!-- Vue.jsでコンポーネント実装 -->
                    <list-item v-bind:register_step="register_step"></list-item>
                </ul>
        </div>  
    </div>
    
</div>

<div class="p-challenge">
    <h1 class="c-title">チャレンジしているStep</h1>

    <?php if(!empty($challengelist)){

             foreach($challengelist as $value){ //1つのstepをforeach文で作成

                echo '<div class="u-challenge--style">';
                echo '<a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/challenge?step_id='.$value['id'].'&challenge_id='.$value['challengeId'].'" style="text-decoration: none;">';
                echo '<div class="p-challenge__list">';
                echo '<li class="c-title--small">タイトル:'.$value['title'].'</li>'.'<br>';
                echo '<li>'.$value['time'].'</li>'.'<br>';
                echo '<li>'.$value['category'].'</li>'.'<br>';
                echo '<li class="u-content--frame">'.$value['content'].'</li>'.'<br>';
                if(!empty($cleardata[$value['challengeId']])){
                    $progressRate = round($cleardata[$value['challengeId']]/$subdata[$value['challengeId']]*100, 0);
                echo $progressRate.'%';
                 }else{
                    $progressRate = 0;
                echo $progressRate.'%';
                 }
                echo '<div class="p-challenge__list--frame">';

                echo '<div style="width:'.(int)$progressRate.'%" class="p-challenge__list--percentage">';
                echo '</div>';

                echo '</div>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
                
             }
            
    }?>

</div>

<script type="text/javascript">

    var json_steplist_obj;

    var json_mydata = '<?php if(!empty($mylist)) echo $mylist; ?>';//PHPからJSON形式のデータを取得

    var json_mydata_new = json_mydata.replace(/(\r\n)/g, '\n')
    .replace(/(\r)/g,   '\n')
    .replace(/(\n)/g,  '\\n')
    .replace(/&quot;/g,'"');

    var register_step = JSON.parse(json_mydata_new);//JSONデータをJSオブジェクトに変換
    
$(function(){
    //メッセージ表示
    var $jsShowMsg = $('#js-show-msg');
    var msg = $jsShowMsg.text();
    if(msg.replace(/^[\s'-']+|[\s'-']+$/g, "").length){
        $jsShowMsg.slideToggle('slow');
        setTimeout(function(){ $jsShowMsg.slideToggle('slow'); }, 5000);
    }
})
    
</script>






