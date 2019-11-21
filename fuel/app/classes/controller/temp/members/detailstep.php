<?php
//===================================================================================================
//みんなのstep一覧詳細機能実装
//===================================================================================================
class Controller_Temp_members_Detailstep extends Controller_Temp_members{

    public function action_index(){
        
        //GETパラ取得してmainstepIDを元にmainstepを取得する
        $step_id = 	Input::get('step_id');

        try {
            //main_idでDBから情報を取得する
            $data = \Model_Edit::get_detailstep($step_id);

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
        $view->set('content', View::forge('detailstep'));
        $view->set_global('step_id', $step_id);
        $view->set_global('title', $data[0]['title']);
        $view->set_global('content', $data[0]['content']);
        $view->set_global('time', $data[0]['time']);
        $view->set_global('category', $data[0]['category']);
        $view->set_global('substeplist', $data);

        return $view;
        
    }

    
}

