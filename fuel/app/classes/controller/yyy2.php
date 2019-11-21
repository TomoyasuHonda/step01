<?php

//======================================================================================
//テストファイル
//======================================================================================

class Controller_Yyy2 extends Controller_Temp_Members{

public function action_index(){


    $view = View::forge('temp3');
    $view->set('content', View::forge('yyy2.php'));
    return $view;
}

public function action_sendmail(){
\Package::load('email');

 //インスタンスの作成
 $email=Email::forge();

 //メール情報の設定
 $email->from('nasayaro@svk.jp','ともやす');
 $email->to('honda.t.0320@gmail.com','本田');
 $email->subject('テストメール');
 $email->body('これはテストメールです');

 try
{
    //メール送信
    $email->send();
}
catch(\EmailValidationFailedException $e)
{
    // バリデーションが失敗したとき
    Log::debug('misu');
}
catch(\EmailSendingFailedException $e)
{
    // ドライバがメールを送信できなかったとき
    Log::debug('misu');
}
 //メール送信後のビュー表示
 return Response::forge(View::forge('sample1/sendmail'));
}


}

