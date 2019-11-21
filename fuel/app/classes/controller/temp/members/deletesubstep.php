<?php
//===================================================================================================
//小STEP削除機能作成
//===================================================================================================
class Controller_Temp_Members_Deletesubstep extends Controller_Temp_Members{

    public function action_index(){

        //GETパラ取得してIDを元にmainstepを取得する
        $step_id = 	Input::get('step_id');
        $substep_id = Input::get('substep_id');

        try {
            //小STEP削除を実行
            \Model_Edit::delete_substep($substep_id);

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

        //DBの〇〇時間〇〇分の時間と分の数字を抜き取る作業
        $data_new = explode("時間", $data[0]['time']);

        $hour = $data_new[0];//時間の数値だけ抜き取る

        $minutes = mb_substr($data_new[1], 0, -1);//分の数値だけ抜き取る

        //画面表示処理
        $view = View::forge('temp2');
        $view->set('content', View::forge('editstep'));
        $view->set_global('step_id', $step_id);
        $view->set_global('title', $data[0]['title']);
        $view->set_global('content', $data[0]['content']);
        $view->set_global('hour', $hour);
        $view->set_global('minutes', $minutes);
        $view->set_global('category', $data[0]['category']);
        $view->set_global('subtitle', $data);

        return $view;
        
    }
}