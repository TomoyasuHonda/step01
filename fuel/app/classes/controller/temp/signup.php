<?php

//=============================================================
//ユーザー登録機能の実装
//==============================================================

class Controller_Temp_Signup extends Controller_Temp { 
    const PASS_LENGTH_MIN = 6;
    const PASS_LENGTH_MAX = 20;

    public function action_index(){
     
     //変数宣言
        $error = '';
        $formData = '';
        $new_password = '';
        if(Input::method() === 'POST'){
            $new_password = $_POST['password'];
        }

        //フォーム作成開始
        $form = Fieldset::forge('signupform1');

        $form->add('username', 'お名前', array('type'=>'text', 'class'=>'c-authform__text--font'))
             ->add_rule('required')
             ->add_rule('min_length', 1)
             ->add_rule('max_length', 255);
        $form->add('email', 'メールアドレス', array('type'=>'email', 'class'=>'c-authform__text--font'))
             ->add_rule('required')
             ->add_rule('valid_email')
             ->add_rule('min_length',1)
             ->add_rule('max_length',255);
        $form->add('password', 'パスワード', array('type'=>'password', 'class'=>'c-authform__text--font'))
             ->add_rule('required')
             ->add_rule('alphanum')
             ->add_rule('min_length', self::PASS_LENGTH_MIN)
             ->add_rule('max_length', self::PASS_LENGTH_MAX);
        $form->add('re_password', 'パスワード再入力', array('type'=>'password', 'class'=>'c-authform__text--font'))
             ->add_rule('required')
             ->add_rule('alphanum')
             ->add_rule('match_field', 'password')
             ->add_rule('min_length', self::PASS_LENGTH_MIN)
             ->add_rule('max_length', self::PASS_LENGTH_MAX)
             ->add_rule('match_value', $new_password, $strict = false);

        $form->add('submit', '', array('value'=>'登録', 'class'=>'c-authform__button', 'type'=>'submit'));
        //フォーム作成終了



        //Input::method()でHTTPメソッドが帰ってくるので、POSTかどうかを確認
        if(Input::method() === 'POST'){

            //バリデーションインスタンスを取得
            $val = $form->validation();
            $val->add_callable('myvalidation');//自分で追加したバリデーション(半角チェック)を取得

            if($val->run()){ //バリデーションを実行
                
                $formData = $val->validated();//バリデーションに成功したフィールドを配列形式で格納する

                $auth = Auth::instance(); //Authインスタンス生成

                try {
                    // 例外が発生する可能性のあるコード

                    if (!$auth->create_user($formData['username'], $formData['password'], $formData['email'])) {
                        throw new Exception('ユーザー登録に失敗しました！Emailアドレスまたはパスワードが不適切です。またはサーバーのメンテナンス中です。時間を置いてお試しください');
                    }

                    //登録後すぐにマイページへ遷移させるためlogin処理してセッションを詰めてやる
                    if (!$auth->login($_POST['email'], $_POST['password'])) {
                        throw new Exception('ログインに失敗しました！Emailアドレスまたはパスワードが不適切です。またはサーバーのメンテナンス中です。時間を置いてお試しください');
                    }
        
                    //マイページへ遷移させる
                    Response::redirect('http://step0123.xsrv.jp/sample_framework03/public/temp/members/mypage');

                } catch (Exception $e) {
                    // 例外が発生した場合に行う処理
                    //$exception =  'ユーザー登録に失敗しました！Emailアドレスまたはパスワードが不適切です。またはサーバーのメンテナンス中です。時間を置いてお試しください';
                    $exception = $e->getMessage();
                    // //画面表示用の処理
                    $view = View::forge('temp');
                    $view->set('content', View::forge('signup'));
                    $view->set_global('signupform', $form->build(''), false); //作成したformをbuild()でViewに埋め込む
                    $view->set_global('exception', $exception);
                    return $view;
                }

            }else{
                //バリデーション失敗
                $error = $val->error();
            }
            //フォームにPOSTされた値をセット
            $form->repopulate();
        }

        //画面表示用の処理
        $view = View::forge('temp');
        $view->set('content', View::forge('signup'));
        $view->set_global('signupform', $form->build(''), false); //作成したformをbuild()でViewに埋め込む
        $view->set_global('error', $error);
        return $view;
    }
}










