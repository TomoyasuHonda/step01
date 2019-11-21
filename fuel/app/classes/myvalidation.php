<?php
class MyValidation
{
    // 半角英数字チェック
    public static function _validation_alphanum($data)
    {
        if(!empty($data)) {
            if (preg_match("/^[a-zA-Z0-9]+$/", $data)) {
                return true;
            }
            else {
                return false;
            }
        }
        return true;
    }
}