<?php
//===================================================================================================
//みんなのSTEP一覧リスト
//===================================================================================================

class Controller_Temp_Members_Steplist extends Controller_Temp_Members{

    public function action_index(){

        try {
            $data = \Model_Edit::get_steplist(); //みんなのSTEPデータを取得

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

        //PHP側でjson形式にしてJS(Vue.js)側のdataに渡してあげる
        $json_data = json_encode($data, JSON_UNESCAPED_UNICODE, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $json_data_new = htmlentities($json_data, ENT_QUOTES);//サニタイズ実行

        //画面表示処理
        $view = View::forge('temp3');
        $view->set('content', View::forge('steplist'));
        $view->set_global('list', $json_data_new);

        return $view;
   
    }
}
