<?php
//===================================================================================================
//小STEP編集機能作成
//===================================================================================================

class Controller_Temp_members_Editsubstep extends Controller_Temp_members{

    public function action_index(){
        //送信内容を変数に格納する
        $step_id = $_GET['step_id'];
        $substep_id = $_GET['substep_id'];

        try {
            $data = Model_Edit::get_substep($substep_id);  //画面表示データ取得
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
        $view->set('content', View::forge('editsubstep'));
        $view->set_global('step_id', $step_id);
        $view->set_global('substep_id', $substep_id);
        $view->set_global('subtitle', $data[0]['subtitle']);
        $view->set_global('hour', $hour);
        $view->set_global('minutes', $minutes);
        $view->set_global('subcontent', $data[0]['subcontent']);
        $view->set_global('step_number', $data[0]['step_number']);
        return $view;
    }

    public function action_post(){

        $error = '';
        $substep_id = $_GET['substep_id'];
        $step_id = $_GET['step_id'];

        $val = Validation::forge();

        $val->add('step_number', '何章目か')
            ->add_rule('required')
            ->add_rule('max_length', 255);
        
        $val->add('title', 'タイトル')
            ->add_rule('required')
            ->add_rule('max_length', 255);
        
        $val->add('hour', '時間を入力してください')
            ->add_rule('required');
        
        $val->add('minutes', '時間を入力してください')
            ->add_rule('required');
        
        $val->add('content', '内容')
            ->add_rule('required')
            ->add_rule('max_length', 255);
            //小STEPがSTEPの目安時間を上回っていないかチェック処理開始============================================================
        $flg = 0;
        try {
            $step_time = \Model_Edit::count_time2($_GET['step_id']);//STEPの目安時間を取得
        
            $substep_time = \Model_Edit::count_subtime($_GET['step_id']);//既に登録されているsubSTEPの目安時間を取得
            
            $get_current_time = \Model_Edit::current_time($_GET['substep_id']);//送信している画面の時間を取得(後で引くため)

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
        
        //DBの〇〇時間〇〇分の時間と分の数字を抜き取る作業
        $data_new = explode("時間", $get_current_time);

        $current_step_hour = $data_new[0];//時間の数値だけ抜き取る

        $current_step_minutes = mb_substr($data_new[1], 0, -1);//分の数値だけ抜き取る
        

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
      
        if($step_hour*60 + $step_minutes <  ($sum_substep_hour+$_POST["hour"])*60 + $sum_substep_minutes+$_POST["minutes"] - ($current_step_hour*60+$current_step_minutes)){
            $time_error = '小STEPの目安時間がSTEPを超えています。中断してmypageのSTEP編集画面から修正してください。';
            $flg = 1;
        }

        //小STEPがSTEPの目安時間を上回っていないかチェック処理終了============================================================

        if($val->run() && $flg != 1){
      
            // チェックOK
            //送信内容を変数に格納する
            $title = $_POST['title'];
            $main_hour = $_POST["hour"];
            $main_minutes = $_POST["minutes"];
            $content = $_POST['content'];
            $step_number = $_POST['step_number'];

            try {
                Model_Edit::update_substep($substep_id, $title, $main_hour, $main_minutes, $content, $step_number); //データのupdateメソッド

                $data = Model_Edit::get_substep($substep_id);  //画面表示データ取得
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
                $data = Model_Edit::get_substep($substep_id);  //画面表示データ取得
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
            $time_error = '小STEPの目安時間がSTEPを超えています。やり直してください。';
        }

        $data_new = explode("時間", $data[0]['time']);

        $hour = $data_new[0];

        $minutes = mb_substr($data_new[1], 0, -1);

        //画面表示処理
        $view = View::forge('temp2');
        $view->set('content', View::forge('editsubstep'));
        $view->set_global('substep_id', $substep_id);
        $view->set_global('step_id', $step_id);
        $view->set_global('subtitle', $data[0]['subtitle']);
        $view->set_global('hour', $hour);
        $view->set_global('minutes', $minutes);
        $view->set_global('subcontent', $data[0]['subcontent']);
        $view->set_global('step_number', $data[0]['step_number']);
        if(!empty($error)){
        $view->set_global('error', $error);
        }
        if(!empty($time_error)){
        $view->set_global('time_error', $time_error);
        }
        return $view;

    }
}