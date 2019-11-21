<?php 

//=============================================================
//認証機能実装
//==============================================================

class Controller_Temp_Members extends Controller_Temp {
    public function before(){
        
            if(!Auth::check()){
                Response::redirect('temp/login');
            }
        }
    }


