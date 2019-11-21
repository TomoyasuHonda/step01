<?php
//===================================================================================================
//マイページ（自分が登録したSTEPとchallengeしているSTEP一覧）機能実装
//===================================================================================================
class Controller_Temp_Members_Mypage extends Controller_Temp_Members {

    public function action_index(){

        try {
            $mydata = \Model_Edit::get_mylist(); //自分の登録したSTEPを取得
            //登録後すぐにマイページへ遷移させるためlogin処理してセッションを詰めてやる
            $challengedata = \Model_Edit::get_challengelist(); //チャレンジしているSTEP一覧を取得
            $cleardata = \Model_Edit::count_cleardata(); //clearテーブルからclearの個数を取得
            $subdata = \Model_Edit::count_substep3();//substepテーブルからsubstep全体の件数を取得

        } catch (Exception $e) {
            // 例外が発生した場合に行う処理
            Log::debug($e->getMessage());
            $exception = 'サーバーエラーです。時間を置いてもう一度お試しください。';
            //画面表示処理
            $view = View::forge('temp2');
            $view->set('content', View::forge('mypage'));
            $view->set_global('exception', $exception);

            return $view;
            
        }

        // //Viewで表示しやすいように配列を変形する
        $cleardata_new = Functions::Arrange_array($cleardata);
        $subdata_new = Functions::Arrange_array($subdata);

        //PHP側でjson形式にしてJS(Vue.js)側のdataに渡してあげる
        $json_mydata = json_encode($mydata, JSON_UNESCAPED_UNICODE, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
        $json_mydata_new = htmlentities($json_mydata, ENT_QUOTES);//サニタイズ実行

        //画面表示処理
        $view = View::forge('temp3');
        $view->set('content', View::forge('mypage'));
        $view->set_global('mylist', $json_mydata_new);
        $view->set_global('challengelist', $challengedata);
        $view->set_global('cleardata', $cleardata_new);
        $view->set_global('subdata', $subdata_new);

        return $view;
    }
}