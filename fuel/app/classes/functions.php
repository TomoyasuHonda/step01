<?php
class Functions {
    public static function Arrange_array($arraydata){
        $new_array = array();
    
        foreach($arraydata as $value){
            
    
            $new_array[$value['challenge_id']] = $value['count(*)'];
            
        }
    
        return $new_array;
        
    }

    public static function make_rand_key($length = 8){
        $str = '';
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        for($i = 0; $i < $length; $i++ ){
            $str .= $chars[mt_rand(0, 61)]; 
        }
        return  $str;
    }
    
}