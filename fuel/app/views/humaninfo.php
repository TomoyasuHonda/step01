<h1 class="c-title">作成者のプロフィール</h1>

<div style="
        margin-top: 100px;
    ">
    <div class="p-selfintroduction">
        <h2 class="p-selfintroduction__h2">自己紹介文</h2>
        <p class="p-selfintroduction__p"><?php echo $introduction;?></p>
    </div>

    <div class="p-image">
        <img src="/sample_framework03/public/assets/img/<?php if(!empty($image)){echo $image;}?>" alt="画像がアップロードされていません" class="p-image__img">
    </div>
</div>

<a href="javascript:void(0);" onclick="window.history.back();" class="p-button--back">戻る</a>
