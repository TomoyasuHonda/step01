<?php
//===================================================================================================
//機能作成
//===================================================================================================
class Controller_Temp_Passremindsend extends Controller_Temp{

    public function action_index(){

            //画面表示処理 
            $view = View::forge('temp');
            $view->set('content', View::forge('passremindsend'));

            return $view;
        
    }

    public function action_post(){

        //変数にPOST値を格納
        $email = $_POST['email'];

        try {
            //送信してきたメールアドレスが登録されているかチェック
            $valid_email = \Model_Edit::valid_email($email);

        } catch (Exception $e) {
            // 例外が発生した場合に行う処理
            $exception = 'Emailの重複検証に失敗しました。時間を置いて再度お試しください。'.$e->getMessage();
            //画面表示処理
            $view = View::forge('temp');
            $view->set('content', View::forge('exception'));
            $view->set_global('exception', $exception);

            return $view;
            
        }

        if(!empty($valid_email)){
        //送信されたメアドはDBに登録されています

        //認証キー生成
        $auth_key = Functions::make_rand_key();

        $comment = <<<EOT
        本メールアドレス宛にパスワード再発行の依頼がありました。
        下記のURLにて認証キーをご入力頂くとパスワードが再発行されます。

        パスワード再発行認証キー入力ページ: http://step0123.xsrv.jp/sample_framework03/public/temp/passremindrecieve.php
        認証キー:{$auth_key}
        ※認証キーの有効期限は30分となります

        認証キーを再発行されたい場合は下記ページより再度再発行をお願いします。
        http://step0123.xsrv.jp/sample_framework03/public/temp/passremindsend.php

        ///////////////////////////////////////////
        STEPカスタマーセンター
        URL http://step0123.xsrv.jp/sample_framework03/public/temp/top
        E-mail info@step0123.xsrv.jp
        ///////////////////////////////////////////
EOT;

        //メール送信処理開始
        //インスタンスの作成
        $send_email = Email::forge();
        
        //メール情報の設定
        $send_email->from('info@step0123.xsrv.jp','STEP運営局');
        $send_email->to($email);
        $send_email->subject('認証キー送付メール');
        $send_email->body($comment);
        
        try
        {
            //メール送信
            $send_email->send();
        }
        catch(\EmailValidationFailedException $e)
        {
            // バリデーションが失敗したとき
        }
        catch(\EmailSendingFailedException $e)
        {
            // ドライバがメールを送信できなかったとき
        }

        //認証に必要な情報をセッションに詰めてやる
        Session::set('auth_key', $auth_key);
        Session::set('auth_email', $email);
        Session::set('auth_key_limit', time()+(60*30));

        //メール送信後のビュー表示
        Response::redirect('http://step0123.xsrv.jp/sample_framework03/public/temp/passremindrecieve');//認証キー入力画面へ遷移させる

        }else{
            //送信されたメアドはDBに登録されていません
            $error = 'こちらのメールアドレスは登録されていません';

            //画面表示処理 
            $view = View::forge('temp');
            $view->set('content', View::forge('passremindsend'));
            $view->set_global('error', $error);

            return $view;

        }
        }

}