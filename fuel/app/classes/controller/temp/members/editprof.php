<?php
//===================================================================================================
//プロフィール機能作成
//===================================================================================================

class Controller_Temp_Members_Editprof extends Controller_Temp_Members {

    public function action_index(){

    //初期画面表示

        try {
            //プロフィール情報を取得
            $data = \Model_Edit::user_data();
            
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

        //画面表示処理開始
        $view = View::forge('temp2');
        $view->set('content', View::forge('editprof'));
        $view->set_global('data_email', $data[0]['email']);
        $view->set_global('data_introduction', $data[0]['introduction']);
        $view->set_global('data_image', $data[0]['image']);
        return $view;

    }

    public function action_post(){ //post送信後の処理

        $val = Validation::forge();
        
        $val->add('email', 'email')
            ->add_rule('required')
            ->add_rule('max_length', 255);
        
        $val->add('introduction', '自己紹介やアピール、意気込み')
            ->add_rule('max_length', 255);

        if($val->run()){
            // チェックOK
            //post値を変数に格納
            if(!empty($_POST['email'])){

                $email = $_POST['email'];

            }else{

                $email = '';
            }

            if(!empty($_POST['introduction'])){
                
                $introduction = $_POST['introduction'];
    
            }else{
                
                $introduction = '';
            }

            // 画像用初期設定
            $config = array(
                'path' => DOCROOT.DS.'assets/img',
                'randomize' => true,
                'ext_whitelist' => array('img', 'jpg', 'jpeg', 'gif', 'png'),
            );

            // アップロード基本プロセス実行
            Upload::process($config);

            //===================================================================================================
            //画像がpostされた時の処理
            //===================================================================================================

            // 検証
            if (Upload::is_valid()) 
            {
                //画像バリデーションOK
                // 設定を元に保存
                Upload::save();

                $files = Upload::get_files();
                Log::debug('$_FILESの中身を取得');
                
                $image = $files[0]["saved_as"];

                try {

                    Model_Edit::prof_edit($introduction, $email, $image);

                    //セッションにサクセスメッセージを詰める
                    $successMsg = ' プロフィール内容を更新しました。';
                    Session::set_flash('successMsg', $successMsg);

                    $data = \Model_Edit::user_data(); //表示用データを取得
                    
                } catch (Exception $e) {
                    // 例外が発生した場合に行う処理
                Log::debug($e->getMessage());
                $exception = 'サーバーエラーです。時間を置いてもう一度お試しください。';
                    //Email重複チェック
                    $code = $e->getCode();
                    if($code == 23000){
                        $exception = 'このメールアドレスは不適切なメールアドレスです。やり直してください。';
                    }
                    //画面表示処理
                    $view = View::forge('temp2');
                    $view->set('content', View::forge('exception'));
                    $view->set_global('exception', $exception);
        
                    return $view;
                    
                }
            
                $view = View::forge('temp2');
                $view->set('content', View::forge('editprof'));

                $view->set_global('data_email', $data[0]['email']);
                $view->set_global('data_introduction', $data[0]['introduction']);
                $view->set_global('data_image', $data[0]['image']);
                     
                return $view; //ここで画像がpostされたら$viewを返して処理終了
            }

        //===================================================================================================
        //画像がpostされない時の処理
        //===================================================================================================
                
            foreach (Upload::get_errors() as $file)
                {
                    //画像バリデーションに引っかかったので、エラーメッセージを配列形式で格納
                    $error_msg = $file['errors'][0]["message"];
                }
            
                try {
                    
                    Model_Edit::proftext_edit($introduction, $email); //text形式のPOST値をDbへ格納

                        //セッションにサクセスメッセージを詰める
                        $successMsg = ' プロフィール内容を更新しました。';
                        Session::set_flash('successMsg', $successMsg);
                    
                    

                    $data = \Model_Edit::user_data(); //プロフィールデータの取得
                    
                } catch (Exception $e) {
                    // 例外が発生した場合に行う処理
                Log::debug($e->getMessage());
                $exception = 'サーバーエラーです。時間を置いてもう一度お試しください。';
                    $code = $e->getCode();
                    if($code == 23000){
                        $exception = 'このメールアドレスは不適切なメールアドレスです。やり直してください。';
                    }
                
                    //画面表示処理
                    $view = View::forge('temp2');
                    $view->set('content', View::forge('exception'));
                    $view->set_global('exception', $exception);
        
                    return $view;
                    
                }
                if(!empty($error_msg) && $error_msg != '(ファイルはアップロードされませんでした)'){
                    Session::delete_flash('successMsg');
                }    

            //画面表示処理
            $view = View::forge('temp2');
            $view->set('content', View::forge('editprof'));
            $view->set_global('data_email', $data[0]['email']);
            $view->set_global('data_introduction', $data[0]['introduction']);
            $view->set_global('data_image', $data[0]['image']);
            $view->set_global('error_msg', $error_msg);
            
            return $view;
        }else{
            // 入力エラー格納
            $error = $val->error();

            try {
                    
                //プロフィール情報を取得
                $data = \Model_Edit::user_data();
                
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

            //画面表示処理
            $view = View::forge('temp2');
            $view->set('content', View::forge('editprof'));
            $view->set_global('error', $error);
            $view->set_global('data_email', $data[0]['email']);
            $view->set_global('data_introduction', $data[0]['introduction']);
            $view->set_global('data_image', $data[0]['image']);

            return $view;
        }
            
                 
  }
}



