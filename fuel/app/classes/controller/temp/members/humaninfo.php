<?php
//===================================================================================================
//作成者について
//===================================================================================================

class Controller_Temp_Members_Humaninfo extends Controller_Temp_Members{

    public function action_index(){

        try {
            $data = \Model_Edit::get_humaninfo($_GET['step_id']); //作成者のプロフィールデータ(画像と自己紹介文)を取得

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
        $view->set('content', View::forge('humaninfo'));
        $view->set_global('introduction', $data['introduction']);
        $view->set_global('image', $data['image']);

        return $view;
   
    }
}