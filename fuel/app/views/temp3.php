<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STEP</title>
    <meta name="description" content="~あなたの人生のSTEPを共有しよう~ 簡易的な学習サービスです。"/>
    <meta name="keywords" content="STEP,学習,勉強,オンライン学習サービス,情報共有">
    <meta name="csrf-token" content="<?php echo \Config::get('security.csrf_token_key');?>">

    <?php echo Asset::css('style.css/style.css'); ?>
    <script  src="http://step0123.xsrv.jp/sample_framework03/public/assets/js/bundle.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
<body class="p-body--background" style="
    font-family: YuGothic,'Yu Gothic',sans-serif;
">
    <div id="app">
    
        <div class="l-header--login">
            <div class="l-header__img--login"><a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/mypage"><img src="data:image/png;base64,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" width="217" height="71" alt="S T E P" class="l-header__mainlogo--login" /></a></div>
            

            <nav class="l-header__menu--login">
                <ul class="l-header__ul--login">
                    <li class="l-menu__steplist--login l-header__commonmenu"><a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/steplist">みんなの一覧</a></li>
                        <li class="l-menu__register--login l-header__commonmenu"><a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/register">SETP登録</a></li>
                        <li class="l-menu__mypage--login l-header__commonmenu"><a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/mypage">マイページ</a></li>
                        <li class="l-menu__prof--login l-header__commonmenu"><a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/editprof">プロフィール&パスワード変更</a></li>
                        <li class="l-menu__logout--login l-header__commonmenu"><a href="http://step0123.xsrv.jp/sample_framework03/public/temp/members/logout">ログアウト</a></li>
                </ul>
            </nav>

            <div class="borders js-borders--login" onclick="js_alert2()">
                <span class="border--login"></span>
                <span class="border--login"></span>
                <span class="border--login"></span>
            </div>

        </div>

        <div id="wrapper">

            <?php echo $content;?>

        </div>
        
        <div class="l-footer--login p-footer--login">
            <p>copyright©2019 STEP ☆彡 all rights reserved.</p>
            <p><button class="p-footer__button--withdraw" onClick="disp()">退会する</button></p>

        </div>

</body>
</html>

<script type="text/javascript">
 function js_alert2() {
        //ログイン認証後のヘッダーのハンバーガーメニュー実装

$(document).on('click', '.js-borders--login', function () {

    $('.l-header__menu--login').removeClass('not-active').addClass('active');

    $(this).addClass('js-flag');

    $(this).children().eq(0).addClass('border1');
    $(this).children().eq(1).addClass('border2');
    $(this).children().eq(2).addClass('border3');
    
});

$(document).on('click', '.js-borders--login.js-flag', function () {

    $('.l-header__menu--login').removeClass('active').addClass('not-active');

    $(this).children().eq(0).removeClass('border1');
    $(this).children().eq(1).removeClass('border2');
    $(this).children().eq(2).removeClass('border3');

    $(this).removeClass('js-flag');
});
}
        window.fuel = window.fuel || {};
        window.fuel.csrfToken = "{{csrf_token()}}";
        function disp(){

        // 「OK」時の処理開始 ＋ 確認ダイアログの表示
        if(window.confirm('2度と元には戻りませんが、本当にいいんですね？')){

            location.href = "http://step0123.xsrv.jp/sample_framework03/public/temp/members/withdraw"; // example_confirm.html へジャンプ

        }
        // 「OK」時の処理終了

        // 「キャンセル」時の処理開始
        else{

            window.alert('キャンセルされました'); // 警告ダイアログを表示

        }
        // 「キャンセル」時の処理終了

        }
    </script>