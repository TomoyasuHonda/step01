<?php
//===================================================================================================
//パスワード変更機能作成
//===================================================================================================

class Controller_Temp_Members_Editpass extends Controller_Temp_Members {

        public function action_index(){
            
            //変数を宣言
            $passData = '';
            $val = '';
            $error = '';
            $new_password = ''; 
            if(Input::method() === 'POST'){
                $new_password = $_POST['new_password'];
            }

            //フォーム作成
            $formpass = Fieldset::forge('pass_editform');

            $formpass->add('old_password', 'パスワード', array('type'=>'password', 'class'=>'c-authform__text--font'))
                     ->add_rule('required')
                     ->add_rule('alphanum')
                     ->add_rule('min_length', 6)
                     ->add_rule('max_length', 20);

            $formpass->add('new_password', '新しいパスワード', array('type'=>'password', 'class'=>'c-authform__text--font'))
                     ->add_rule('required')
                     ->add_rule('alphanum')
                     ->add_rule('min_length', 6)
                     ->add_rule('max_length', 20);

            $formpass->add('re_new_password', '新しいパスワード再入力', array('type'=>'password', 'class'=>'c-authform__text--font'))
                     ->add_rule('required')
                     ->add_rule('alphanum')
                     ->add_rule('min_length', 6)
                     ->add_rule('max_length', 20)
                     ->add_rule('match_value', $new_password, $strict = false);
            
            $formpass->add('submit', '', array('type'=>'submit', 'value'=>'送信する', 'class'=>'c-authform__button'));
            //フォーム作成終了


            if(Input::method() === 'POST'){
                //post送信後の処理
                
                //バリデーションインスタンスを取得
                $val = $formpass->validation();
                $val->add_callable('myvalidation');//自分で追加したバリデーション(半角チェック)を取得

                if($val->run()){//バリデーションを実行

                    $passData = $val->validated();//バリデーションに成功したフィールドを配列形式で格納する
                    $auth = Auth::instance();//Authインスタンス生成

                    try {
                        // 例外が発生する可能性のあるコード
                        //パスワード変更メソッドを使用
                        if (!$auth->change_password($_POST['old_password'], $_POST['new_password'], $username = $auth->get_screen_name())) {
                            throw new Exception('パスワード変更に失敗しました！パスワードが正しくありません。またはサーバーのメンテナンス中です。時間を置いてお試しください');
                        }
                        
                        //セッションにサクセスメッセージを詰める
                        $successMsg = ' パスワードを変更しました。';
                        Session::set_flash('successMsg', $successMsg);
                        
                        //マイページへ遷移させる
                        Response::redirect('http://step0123.xsrv.jp/sample_framework03/public/temp/members/mypage');
                        

                    } catch (Exception $e) {
                        // 例外が発生した場合に行う処理
                Log::debug($e->getMessage());
                $exception = 'サーバーエラーです。時間を置いてもう一度お試しください。';
                        //画面表示処理
                        $view = View::forge('temp2');
                        $view->set('content', View::forge('exception'));
                        $view->set_global('exception', $exception);
            
                        return $view;
                        
                    }

                }else{
                    //バリデーションに引っかかったのでエラー格納
                    $error = $val->error();
                }
                //フォームにPOSTされた値をセット
                $formpass->repopulate();
            }

            //画像表示用処理
            $view = View::forge('temp2');
            $view->set('content', View::forge('editpass'));
            $view->set_global('editpassform', $formpass->build(''), false); //作成したformをbuild()でViewに埋め込む
            $view->set_global('error', $error);
            return $view;
        }
    
}

 