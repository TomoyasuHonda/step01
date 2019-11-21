<?php
//===================================================================================================
//小STEP追加機能作成
//===================================================================================================
class Controller_Temp_Members_Addsubstep extends Controller_Temp_Members{

    public function action_index(){
            //送信内容を変数に格納する
            $step_id = $_GET['step_id'];

            try {
                //小stepをカウント処理
                $count_substep = \Model_Edit::count_substep2($step_id);
    
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
            $view->set('content', View::forge('addsubstep'));
            $view->set_global('count_substep', $count_substep[0]['count(*)']);
            $view->set_global('step_id', $step_id);

            return $view;
        
    }

    public function action_post(){

        $step_id = Input::get('step_id');
        $error = '';

        $val = Validation::forge();
        
        $val->add('substep_title', 'タイトル')
            ->add_rule('required')
            ->add_rule('max_length', 25);
        
        $val->add('substep_hour', '時間')
            ->add_rule('required')
            ->add_rule('max_length', 5);

        $val->add('substep_minutes', '分')
            ->add_rule('required')
            ->add_rule('max_length', 2);

        $val->add('sub_content', '内容')
            ->add_rule('required')
            ->add_rule('max_length', 100);
            
        //小STEPがSTEPの目安時間を上回っていないかチェック処理開始============================================================
        $flg = '0';
        try {
            $step_time = \Model_Edit::count_time2($_GET['step_id']);//STEPの目安時間を取得
        
            $substep_time = \Model_Edit::count_subtime($_GET['step_id']);//既に登録されているsubSTEPの目安時間を取得

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
        $data_new = explode("時間", $step_time[0]['time']);

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
                //メインの処理の送信内容を変数に格納
                $sub_title = $_POST["substep_title"];
                $sub_hour = $_POST["substep_hour"];
                $sub_minutes = $_POST["substep_minutes"];
                $sub_content = $_POST["sub_content"];

                try {
                    //substep登録処理
                    \Model_Edit::add_substep($step_id, $sub_title, $sub_hour, $sub_minutes, $sub_content);
        
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

            try {
                //小stepをカウント処理
                $count_substep = \Model_Edit::count_substep2($step_id);
    
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

                // 入力エラー
                $error = $val->error();
                $time_error = '小STEPがSTEPの目安時間を上回っています。やり直してください。';
                
                //画面表示処理
                $view = View::forge('temp2');
                $view->set('content', View::forge('addsubstep'));
                $view->set_global('count_substep', $count_substep[0]['count(*)']);
                $view->set_global('step_id', $step_id);
                $view->set_global('error', $error);
                $view->set_global('time_error', $time_error);
                return $view;
        }

        try {
            //main_idでDBから情報を取得する
            $data = \Model_Edit::get_editstep($step_id);

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

        $data_new = explode("時間", $data[0]['time']);

        $hour = $data_new[0];

        $minutes = mb_substr($data_new[1], 0, -1);

        //画面表示処理
        $view = View::forge('temp2');
        $view->set('content', View::forge('editstep'));
        $view->set_global('step_id', $step_id);
        $view->set_global('title', $data[0]['title']);
        $view->set_global('content', $data[0]['content']);
        $view->set_global('hour', $hour);
        $view->set_global('minutes', $minutes);
        $view->set_global('category', $data[0]['category']);
        $view->set_global('substeplist', $data);
        $view->set_global('subtitle', $data);

        return $view;
    
}

    
}