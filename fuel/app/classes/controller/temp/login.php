<?php

//=============================================================
//ログイン機能の実装
//==============================================================

class Controller_Temp_Login extends Controller_Temp{

    public function action_index(){

        //変数を宣言
        $error = '';
        $formData = '';
        $errorMsg = '';
       
        //フォーム作成開始
        $form = Fieldset::forge('loginform');
        
        $form->add('email', 'Email', array('type'=>'email', 'class'=>'c-authform__text--font'))
             ->add_rule('required')
             ->add_rule('min_length', 1)
             ->add_rule('max_length', 255);

        $form->add('password', 'パスワード', array('type'=>'password', 'class'=>'c-authform__text--font'))
             ->add_rule('required')
             ->add_rule('alphanum')
             ->add_rule('min_length', 6)
             ->add_rule('max_length',20);

        $form->add('remember', 'ログイン保持', array('type'=>'checkbox', 'class'=>'c-authform__remember'));

        $form->add('submit', '', array('value'=>'ログイン', 'type'=>'submit', 'class'=>'c-authform__button'));
        //フォーム作成終了
        
        if(!empty($_SERVER['HTTP_REFERER'])){
            
        $url = basename($_SERVER['HTTP_REFERER']);
        if($url === 'passremindsend'){
            //画面表示用の処理
            $view = View::forge('temp');
            $view->set('content', View::forge('login'));
            $view->set_global('loginform', $form->build(''), false);//作成したformをbuild()でViewに埋め込む
            return $view;
        }else{
            //Input::method()でHTTPメソッドが帰ってくるので、POSTかどうかを確認
        if(Input::method() === 'POST'){
            $email = $_POST['email'];
            $password = $_POST['password'];

            //バリデーションインスタンスを取得
            $val = $form->validation();
            $val->add_callable('myvalidation');//自分で追加したバリデーション(半角チェック)を取得

            if($val->run()){ //バリデーションを実行
      
                $formData = $val->validated();//バリデーションに成功したフィールドを配列形式で格納する

                $auth = Auth::instance(); //Authインスタンス生成
                
                if(isset($_POST['remember'])){//保持にチェックがついていた場合
                
                // remember-me クッキーを作成
                Auth::remember_me();
                }

                //メールアドレスとパスワードを検証
                if ($user = Auth::validate_user($email, $password))
                {
                    try {
                    
                        if (!$auth->login($_POST['email'], $_POST['password'])) {
                            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください1');
                        }
                       
                        Response::redirect('http://step0123.xsrv.jp/sample_framework03/public/temp/members/mypage');//マイページへ遷移させる
                 
                    } catch (Exception $e) {
                        // 例外が発生した場合に行う処理
                        //ログインに失敗しました！時間を置いてお試しください
                        $exception = $e->getMessage();
                        //画面表示用の処理
                        $view = View::forge('temp');
                        $view->set('content', View::forge('login'));
                        $view->set_global('loginform', $form->build(''), false);//作成したformをbuild()でViewに埋め込む
                        $view->set_global('exception', $exception);
                        return $view;
                    }
                
                }else{
                    $errorMsg = 'ログインに失敗しました！Emailアドレスまたはパスワードが不適切です';
            }

            }else{
                //バリデーション失敗
                $error = $val->error();
            }
            //フォームにPOSTされた値をセット
            $form->repopulate();

        }
        }

        

    //画面表示用の処理
    $view = View::forge('temp');
    $view->set('content', View::forge('login'));
    $view->set_global('loginform', $form->build(''), false);//作成したformをbuild()でViewに埋め込む
    $view->set_global('error', $error);
    $view->set_global('errorMsg', $errorMsg);
    return $view;
    
    }else{
    Response::redirect('temp/top');
    
  }
    }
}