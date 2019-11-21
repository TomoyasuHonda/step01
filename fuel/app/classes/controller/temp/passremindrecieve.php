<?php
//===================================================================================================
//機能作成
//===================================================================================================
class Controller_Temp_Passremindrecieve extends Controller_Temp{

    public function action_index(){

            //画面表示処理 
            $view = View::forge('temp');
            $view->set('content', View::forge('passremindrecieve'));

            return $view;
    }

    public function action_post(){

        $error = array();
        $auth_key = Session::get('auth_key');

        if(empty($auth_key)){
            Response::redirect('http://step0123.xsrv.jp/sample_framework03/public/temp/passremindsend');//E-mail入力画面へ遷移させる
        }

        //バリデーション
        //今回はDB登録などはないのでhtml側で実装

        //変数にPOST値を格納
        $send_auth_key = $_POST['auth_key'];


        //認証キーの照合
        if($auth_key === $send_auth_key){

            if(time() < Session::get('auth_key_limit')){
            //パスワード生成
            $password = Functions::make_rand_key();
            $auth_email = Session::get('auth_email');

            try {
            //更新したいユーザー名を取得
            $get_username = \Model_Edit::get_username($auth_email);

            // 現在のユーザーのパスワードをリセット
            $password = Auth::reset_password($get_username);
    
            } catch (Exception $e) {
                // 例外が発生した場合に行う処理
                $exception = $e->getMessage();
                //画面表示処理
                $view = View::forge('temp');
                $view->set('content', View::forge('exception'));
                $view->set_global('exception', $exception);
    
                return $view;
                
            }


            //メール送信処理開始
            \Package::load('email');

            //インスタンスの作成
            $send_email=Email::forge();
            
            $comment = <<<EOT
        本メールアドレス宛にパスワード再発行の依頼がありました。
        下記の新しいパスワードを元にログインしてください

        URL: http://step0123.xsrv.jp/sample_framework03/public/temp/login.php
        新しいパスワード:{$password}

        ///////////////////////////////////////////
        STEPカスタマーセンター
        E-mail info@step0123.xsrv.jp
        ///////////////////////////////////////////
EOT;
            
            //メール情報の設定
            $send_email->from('info@step0123.xsrv.jp','STEP運営局');
            $send_email->to($auth_email);
            $send_email->subject('パスワード送付メール');
            $send_email->body($comment);
            
            try
            {
                //メール送信
                $send_email->send();
            }
            catch(\EmailValidationFailedException $e)
            {
                // バリデーションが失敗したとき
                // 例外が発生した場合に行う処理
                $exception = 'メールアドレスが正しくないため送信できませんでした。:'.$e->getMessage();
                //画面表示処理
                $view = View::forge('temp');
                $view->set('content', View::forge('exception'));
                $view->set_global('exception', $exception);
    
                return $view;
                
            }
            catch(\EmailSendingFailedException $e)
            {
                // ドライバがメールを送信できなかったとき
                $exception = 'メール送信時のその他のエラーが発生しました。:'.$e->getMessage();
                //画面表示処理
                $view = View::forge('temp');
                $view->set('content', View::forge('exception'));
                $view->set_global('exception', $exception);
    
                return $view;
            }
            //メール送信後のビュー表示
            Response::redirect('http://step0123.xsrv.jp/sample_framework03/public/temp/login');//loginページへ遷移させる

            }else{
                $error[1] = '認証キーの有効期限がきれています。1つ前の画面からやり直してください';
            }
        }else{
            $error[0] = '認証キーが不適切です';

            //画面表示処理 
            $view = View::forge('temp');
            $view->set('content', View::forge('passremindrecieve'));
            $view->set_global('error', $error);
            return $view;
            }

        }

}