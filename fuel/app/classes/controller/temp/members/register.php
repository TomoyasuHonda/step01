<?php
//===================================================================================================
//mainSTEP登録機能　 
//===================================================================================================

class Controller_Temp_Members_Register extends Controller_Temp_Members{
    
    public function action_index(){
        //post送信なしで初期画面表示

        $view = View::forge('temp2');
    
        $view->set('content', View::forge('mainstep'));

        return $view;
    }

    public function action_mainpost(){
        //mainstep登録後substepを登録させてやるための処理

        $val = Validation::forge();
        $val->add('step_title', 'タイトル')
            ->add_rule('required')
            ->add_rule('max_length', 20);

        $val->add('step_category', 'カテゴリー')
            ->add_rule('required');
        
        $val->add('step_hour', '時間を入力してください')
            ->add_rule('required');
        
        $val->add('step_minutes', '時間を入力してください')
            ->add_rule('required');

        $val->add('main_content', '紹介文')
            ->add_rule('required')
            ->add_rule('max_length', 100);
        
        if($val->run()){
            // チェックOK
            //メインの処理のpost内容を変数に格納
            if(Input::method() === 'POST'){
                $main_title = $_POST["step_title"];
                $main_category = $_POST["step_category"];
                $main_hour = $_POST["step_hour"];
                $main_minutes = $_POST["step_minutes"];
                $main_content = $_POST["main_content"];

                try {
                    //mainSTEPをDBへ登録
                    \Model_Edit::register_step($main_title, $main_category, $main_hour, $main_minutes, $main_content);
        
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

            }

            //画面表示処理
            $view = View::forge('temp2');
            $view->set('content', View::forge('substep'));

            return $view;

        }else{
            // 入力エラー格納
            $error = $val->error();

            //画面表示処理
            $view = View::forge('temp2');
            $view->set('content', View::forge('mainstep'));
            $view->set_global('error', $error);

            return $view;
        }

    }

    public function action_subpost(){
        //substep登録後引き続きsubstepを登録させてやるための処理

        $val = Validation::forge();

        $val->add('substep_title', 'タイトル')
            ->add_rule('required')
            ->add_rule('max_length', 20);
        
        $val->add('substep_hour', '時間')
            ->add_rule('required')
            ->add_rule('max_length', 5);
        
        $val->add('substep_minutes', '分')
            ->add_rule('required')
            ->add_rule('max_length', 3);

        $val->add('sub_content', '内容')
            ->add_rule('required')
            ->add_rule('max_length', 100);

        //小STEPがSTEPの目安時間を上回っていないかチェック処理開始============================================================
        $flg = '0';
        try {
            $step_time = \Model_Edit::count_time();//STEPの目安時間を取得
        
            $substep_time = \Model_Edit::count_subtime($step_time['id']);//既に登録されているsubSTEPの目安時間を取得

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

        //STEPの時間と分を変数に格納
        //DBの〇〇時間〇〇分の時間と分の数字を抜き取る作業
        $data_new = explode("時間", $step_time['time']);

        $step_hour = $data_new[0];//時間の数値だけ抜き取る

        $step_minutes = mb_substr($data_new[1], 0, -1);//分の数値だけ抜き取る
        

        //substepに今までの小stepの合計時間が複数個存在しているのでfoeachで回して足していく
        $substep_hour = array();
        $substep_minutes = array();
        foreach($substep_time as $value){
            
            //DBの〇〇時間〇〇分の時間と分の数字を抜き取る作業
            $data_new = explode("時間", $value['time']);

            $substep_hour[] = $data_new[0];//時間の数値だけ抜き取る

            $substep_minutes[] = mb_substr($data_new[1], 0, -1);//分の数値だけ抜き取る
        }
        $sum_substep_hour = array_sum($substep_hour);
        $sum_substep_minutes = array_sum($substep_minutes);
  
        if($step_hour*60 + $step_minutes <  ($sum_substep_hour + $_POST["substep_hour"] )*60 + $sum_substep_minutes + $_POST["substep_minutes"]){
            $time_error = '小STEPの目安時間がSTEPを超えています。中断してmypageのSTEP編集画面から修正してください。';
            $flg = 1;
        }

        //小STEPがSTEPの目安時間を上回っていないかチェック処理終了============================================================

            if($val->run() && $flg != 1){
                // チェックOK
                
                //メインの処理のpost内容を変数に格納
                if(Input::method() === 'POST'){
                    $sub_title = $_POST["substep_title"];
                    $sub_hour = $_POST["substep_hour"];
                    $sub_minutes = $_POST["substep_minutes"];
                    $sub_content = $_POST["sub_content"];

                    try {
                        //subSTEPをDBへ登録
                        \Model_Edit::register_substep($sub_title, $sub_hour, $sub_minutes, $sub_content);

                        //現在何枚目かをカウントする為にDBから個数を取得
                        $count_substep = \Model_Edit::count_substep();
            
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
                }

                //画面表示処理
                $view = View::forge('temp2');
                $view->set('content', View::forge('substep'));
                $view->set_global('count_sub_step', $count_substep[0]['count(*)']);

                return $view; 

            }else{
                // 入力エラー格納
                $error = $val->error();

                try {
                    //現在何枚目かをカウントする為にDBから個数を取得
                    $count_substep = \Model_Edit::count_substep();
        
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
                $view->set('content', View::forge('substep'));
                $view->set_global('error', $error);
                $view->set_global('time_error', $time_error);
                $view->set_global('count_sub_step', $count_substep[0]['count(*)']);

                return $view;
            }

    }

}