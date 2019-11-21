<?php

//=============================================================
//ログアウト機能の実装
//==============================================================

class Controller_Temp_members_Logout extends Controller_Temp_members{

    public function action_index(){

        try {
            // 例外が発生する可能性のあるコード

            if (Auth::logout()) {
                throw new Exception('サーバーのメンテナンス中です。以下のリンクよりお戻りください');
            }

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

        $view = Response::redirect('temp/login')->execute();
            
        return $view;

    }
}

