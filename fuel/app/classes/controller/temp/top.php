<?php

class Controller_Temp_Top extends Controller_Temp {

    public function action_index(){

        $view = View::forge('temp');
        $view->set('content', View::forge('top'));
        return $view;
    }
}