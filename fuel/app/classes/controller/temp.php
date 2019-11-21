<?php

//=============================================================
//ヘッダー、フッター共通化テンプレート機能
//==============================================================

class Controller_Temp extends Controller_Template{
    public $template = 'temp2';

    // //デフォルト以外のテンプレートも用意
    // public function action_index2(){
    //     $this->template = View::forge('temp2');
    // }
    
}