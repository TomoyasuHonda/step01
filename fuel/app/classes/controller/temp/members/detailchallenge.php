<?php
//===================================================================================================
//チャレンジ(小STEP)機能実装
//===================================================================================================
class Controller_Temp_Members_detailchallenge extends Controller_Temp_Members{

    public function action_index(){

            //送信内容を変数に格納する
            $substep_id = $_GET['substep_id'];
            $step_id = $_GET['step_id'];
            $challenge_id = $_GET['challenge_id'];

            try {

                $data = \Model_Edit::get_detailchallenge($substep_id);//画面に表示するchallengeデータの詳細を取得

                $substep_list = \Model_Edit::get_substeplist($step_id);//サイドバーに表示する小STEP一覧を取得
                
                $clear_data = \Model_Edit::clear_flg($challenge_id);//clearしたかどうか判別
    
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
            $view->set('content', View::forge('detailchallenge'));
            $view->set_global('step_id', $step_id);
            $view->set_global('substep_id', $substep_id);
            $view->set_global('title', $data[0]['subtitle']);
            $view->set_global('content', $data[0]['subcontent']);
            $view->set_global('time', $data[0]['time']);
            $view->set_global('subtitle', $substep_list);
            $view->set_global('challenge_id', $challenge_id);
            $view->set_global('clear_count', $clear_data);

            return $view;
        
    }

    public function action_clear(){

        //送信内容を変数に格納する
        $substep_id = $_GET['substep_id'];
        $step_id = $_GET['step_id'];
        $challenge_id = $_GET['challenge_id'];

        try {
                
            \Model_Edit::clear_substep($step_id, $substep_id, $challenge_id); //クリアBtnを押した時にクリアテーブルにidがインサートされる

            $data = \Model_Edit::get_detailchallenge($substep_id);//画面に表示するchallengeデータの詳細を取得

            $substep_list = \Model_Edit::get_substeplist($step_id);//サイドバーに表示する小STEP一覧を取得
            
            $clear_data = \Model_Edit::clear_flg($challenge_id);//clearしたかどうか判別

        } catch (Exception $e) {
            
            // 例外が発生した場合に行う処理
            Log::debug($e->getMessage());
            $exception = 'サーバーエラーです。';
            if($e->getCode() == 1062 || $e->getCode() == 23000){
                $exception = '既にクリアボタンは押されています';
            }
            //画面表示処理
            $view = View::forge('temp2');
            $view->set('content', View::forge('exception'));
            $view->set_global('exception', $exception);

            return $view;
            
        }

        //画面表示処理
        $view = View::forge('temp2');
        $view->set('content', View::forge('detailchallenge'));
        $view->set_global('step_id', $step_id);
        $view->set_global('substep_id', $substep_id);
        $view->set_global('title', $data[0]['subtitle']);
        $view->set_global('content', $data[0]['subcontent']);
        $view->set_global('time', $data[0]['time']);
        $view->set_global('subtitle', $substep_list);
        $view->set_global('challenge_id', $challenge_id);
        $view->set_global('clear_count', $clear_data);

        return $view;

    }
}
