<?php

//=============================================================
//退会機能の実装
//==============================================================

class Controller_Temp_Members_Withdraw extends Controller_Temp_Members{

    public function action_index(){

        try {
            // 例外が発生する可能性のあるコード

            if (!Auth::delete_user(Auth::get_screen_name())) {
                throw new Exception('退会に失敗しました！サーバーのメンテナンス中です。時間を置いてお試しください');
            }

            //マイページへ遷移させる
            Response::redirect('http://step0123.xsrv.jp/sample_framework03/public/temp/members/mypage');

        } catch (Exception $e) {
            // 例外が発生した場合に行う処理
            Log::debug($e->getMessage());
            $exception = 'サーバーエラーです。時間を置いてもう一度お試しください。';
            //画面表示用の処理
            $view = View::forge('temp');
            $view->set('content', View::forge('exception'));
            $view->set_global('exception', $exception);
            return $view;
        }

        //退会処理実行開始
        //Auth::delete_user(Auth::get_screen_name());

        //退会後画面へ遷移
        $view = View::forge('temp');
        $view->set('content', View::forge('withdraw.php'));
        return $view;
    }
}