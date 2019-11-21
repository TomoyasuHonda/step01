<?php
//=============================================================
//Model処理
//==============================================================

class Model_Edit extends Model{

    public static function user_data(){

        $email = Auth::get_email();

        $user_id = Auth::get_user_id();
        
        //DBへ接続する処理をかく
        $query = DB::query("SELECT email, introduction, `image` FROM users where id = '" . $user_id[1] . "'")->execute()->as_array();

        if ($query) {
            return $query;
        }elseif($query === 0){
            return $query;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function prof_edit($introduction, $email, $image){
        
        $user_id = Auth::get_user_id();

        $query = DB::update('users')
            ->value("introduction", $introduction)
            ->value("email", $email)
            ->value("image", $image)
            ->where('id', '=', $user_id[1])
            ->execute();

            if (is_int($query)) {
                return true;
        }else{
                throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function proftext_edit($introduction, $email){
        
        $user_id = Auth::get_user_id();

        $query = DB::update('users')
                    ->value("introduction", $introduction)
                    ->value("email", $email)
                    ->where('id', '=', $user_id[1])
                    ->execute();

                    if (is_int($query)) {
                        return true;
                    }else{
                            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
                    }
    } 

    

    public static function register_step($main_title, $main_category, $main_hour, $main_minutes, $main_content){

            $user_id = Auth::get_user_id();

            $query = DB::insert('mainstep');

            $query->set(array(
                'title' => $main_title,
                'category' => $main_category,
                'time' => $main_hour.'時間'.$main_minutes.'分',
                'content' => $main_content,
                'user_id' => $user_id[1]
            ))->execute();

            if ($query) {
                return true;
            }elseif($query === 0){
                return $query;
            }else{
                throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
            }
   
    }



    public static function register_substep($sub_title, $sub_hour, $sub_minutes, $sub_content){

        $user_id = Auth::get_user_id();

        $step_id = DB::query("SELECT id FROM mainstep where `user_id` = '" . $user_id[1] . "' ORDER BY timestamp DESC")->execute()->as_array();

        $count = DB::query("SELECT count(*) from substep where mainstep_id = '" . $step_id[0]['id'] . "'  ")->execute()->as_array();

        $query = DB::insert('substep');

        $query->set(array(
                'subtitle' => $sub_title,
                'time' => $sub_hour.'時間'.$sub_minutes.'分',
                'subcontent' => $sub_content,
                'mainstep_id' => $step_id[0]['id'],
                'user_id' => $user_id[1],
                'step_number' => $count[0]['count(*)'] + 1
            ))->execute();

            if ($query) {
                return true;
            }elseif($query === 0){
                return $query;
            }else{
                throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
            }
            
    }

    public static function count_substep(){
        $user_id = Auth::get_user_id();

        $step_id = DB::query("SELECT id FROM mainstep where `user_id` = '" . $user_id[1] . "' ORDER BY timestamp DESC")->execute()->as_array();

        //カウント処理を記述
        $count = DB::query("SELECT count(*) from substep where mainstep_id = '" . $step_id[0]['id'] . "'  ")->execute()->as_array();

        if ($count) {
            return $count;
        }elseif($count === 0){
            return $count;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    
    }

    public static function get_steplist(){
        $list = DB::query("SELECT id, title, category, time, content FROM mainstep WHERE delete_flg = 0 ORDER BY timestamp DESC")->execute()->as_array();

        if ($list) {
            return $list;
        }elseif($list === 0){
            return $list;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function get_mylist(){

        $user_id = Auth::get_user_id();

        $mylist = DB::query("SELECT id, title, category, time, content FROM mainstep where `user_id` = '" . $user_id[1] . "' AND delete_flg = 0 ORDER BY timestamp DESC")->execute()->as_array();

        if ($mylist) {
            return $mylist;
        }elseif(isset($mylist)){
            return $mylist;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function get_detailstep($id){
        $detailstep = DB::query("SELECT mainstep.title, mainstep.category, mainstep.time, mainstep.content, substep.subtitle, substep.step_number FROM mainstep LEFT JOIN substep ON mainstep.id = substep.mainstep_id where mainstep.id = $id AND mainstep.delete_flg = 0 ORDER BY mainstep.timestamp DESC")->execute()->as_array();

        if ($detailstep) {
            return $detailstep;
        }elseif($detailstep === 0){
            return $detailstep;
        }else{
            throw new Exception('不正な値が入りました。またはサーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function get_editstep($id){
        $user_id = Auth::get_user_id();

        $editstep = DB::query("SELECT mainstep.title, mainstep.category, mainstep.time, mainstep.content, substep.id, substep.subtitle, substep.subcontent, substep.step_number FROM mainstep LEFT JOIN substep ON mainstep.id = substep.mainstep_id where mainstep.id = $id AND mainstep.user_id = $user_id[1] AND mainstep.delete_flg = 0 ORDER BY mainstep.timestamp DESC")->execute()->as_array();

        if ($editstep) {
            return $editstep;
        }elseif($editstep === 0){
            return $editstep;
        }else{
            throw new Exception('データを取得できませんでした。');
        }
    }

    public static function update_step($id, $title, $hour, $minutes, $content, $category){

        $query = DB::update('mainstep')
            ->value("title", $title)
            ->value("time", $hour.'時間'.$minutes.'分')  
            ->value("content", $content)
            ->value("category", $category)
            ->where('id', '=', $id)
            ->execute();

            if (is_int($query)) {
                return true;
            }else{
                    throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
            }
    }

    public static function get_substep($id){

        $user_id = Auth::get_user_id();

        $get_substep = DB::query("SELECT subtitle, time, subcontent, step_number FROM substep where id = $id AND user_id = $user_id[1] AND delete_flg = 0")->execute()->as_array();

        if ($get_substep) {
            return $get_substep;
        }elseif($get_substep === 0){
            return $get_substep;
        }else{
            throw new Exception('データの取得に失敗しました。');
        }
    }

    public static function update_substep($id, $title, $hour, $minutes, $content, $step_number){

        $update_substep = DB::update('substep')
        ->value("subtitle", $title)
        ->value("time", $hour.'時間'.$minutes.'分')
        ->value("subcontent", $content)
        ->value("step_number", $step_number)
        ->where('id', '=', $id)
        ->execute();

        if (is_int($update_substep)) {
            return true;
        }else{
                throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function delete_step($id){
        //delete構文だがdelete_flgに1を立てるのでupdateを使う

        $update_substep = DB::update('mainstep')
        ->value("delete_flg", 1)
        ->where('id', '=', $id)
        ->execute();

        if (is_int($update_substep)) {
            return true;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }

    }

    public static function make_challenge($step_id){

        $user_id = Auth::get_user_id();

        $challenge = DB::insert('challenge');

        $challenge->set(array(
            'user_id' => $user_id[1],
            'mainstep_id' => $step_id
        ))->execute();

        if ($challenge) {
            return $challenge;
        }elseif($challenge === 0){
            return $challenge;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }

    }

    public static function get_challenge($step_id, $challenge_id){

        $user_id = Auth::get_user_id();

        $challenge = DB::query("SELECT mainstep.title, mainstep.category, mainstep.time, mainstep.content, substep.id, substep.subtitle, substep.step_number FROM mainstep LEFT JOIN challenge ON mainstep.id = challenge.mainstep_id LEFT JOIN substep ON mainstep.id = substep.mainstep_id where mainstep.delete_flg = 0 AND challenge.user_id = $user_id[1] AND challenge.mainstep_id = $step_id AND challenge.id = $challenge_id ORDER BY mainstep.timestamp DESC")->execute()->as_array();

        if ($challenge) {
            return $challenge;
        }elseif($challenge === 0){
            return $challenge;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function get_challengelist(){

        $user_id = Auth::get_user_id();

        $challenge = DB::query("SELECT mainstep.id, mainstep.title, mainstep.category, mainstep.time, mainstep.content, challenge.id as challengeId FROM challenge LEFT JOIN mainstep ON challenge.mainstep_id = mainstep.id  where mainstep.delete_flg = 0 AND challenge.user_id = $user_id[1] ORDER BY challenge.timestamp ASC")->execute()->as_array();

        if ($challenge) {
            return $challenge;
        }elseif(isset($challenge)){
            return $challenge;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }

    }

    public static function get_detailchallenge($substep_id){
        $get_substep = DB::query("SELECT subtitle, time, subcontent, step_number FROM substep where id = $substep_id AND delete_flg = 0")->execute()->as_array();

        if ($get_substep) {
            return $get_substep;
        }elseif($get_substep === 0){
            return $get_substep;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }

    }

    public static function get_substeplist($step_id){

        $substep_list = DB::query("SELECT id, subtitle, step_number FROM substep where mainstep_id = $step_id AND delete_flg = 0")->execute()->as_array();

        if ($substep_list) {
            return $substep_list;
        }elseif($substep_list === 0){
            return $substep_list;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function clear_substep($step_id, $substep_id, $challenge_id){ //クリアBtnを押した時に実行

        $user_id = Auth::get_user_id();

        $clear = DB::insert('clear');

        $clear->set(array(
            'user_id' => $user_id[1],
            'mainstep_id' => $step_id,
            'substep_id' => $substep_id,
            'challenge_id' => $challenge_id
        ))->execute();

        if ($clear) {
            return true;
        }elseif($clear === 0){
            return true;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }

    }

    public static function count_cleardata(){

        $user_id = Auth::get_user_id();

        $clear_count = DB::query("SELECT challenge_id, count(*) FROM `clear` WHERE user_id = $user_id[1] group by challenge_id")->execute()->as_array();

        if ($clear_count) {
            return $clear_count;
        }elseif(isset($clear_count)){
            return $clear_count;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }

    }


    public static function count_substep2($step_id){

        //カウント処理を記述
        $count = DB::query("SELECT count(*) from substep where mainstep_id = '" . $step_id . "'  ")->execute()->as_array();

        if ($count) {
            return $count;
        }elseif($count === 0){
            return $count;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function count_substep3(){

        $user_id = Auth::get_user_id();

        $clear_count = DB::query("SELECT challenge.id as challenge_id, substep.mainstep_id, count(*) FROM substep JOIN challenge ON challenge.mainstep_id = substep.mainstep_id WHERE challenge.user_id = $user_id[1] group by mainstep_id, challenge.id")->execute()->as_array();
    
        if ($clear_count) {
            return $clear_count;
        }elseif(isset($clear_count)){
            return $clear_count;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function add_substep($step_id, $sub_title, $sub_hour, $sub_minutes, $sub_content){

        $user_id = Auth::get_user_id();

        $count = DB::query("SELECT count(*) FROM substep WHERE mainstep_id =' ".$step_id. "'  ")->execute()->as_array();
        
            $query = DB::insert('substep');

            $query->set(array(
                'subtitle' => $sub_title,
                'time' => $sub_hour.'時間'.$sub_minutes.'分',
                'subcontent' => $sub_content,
                'mainstep_id' => $step_id,
                'user_id' => $user_id[1],
                'step_number' => $count[0]['count(*)'] + 1
            ))->execute();

            if ($query) {
                return $query;
            }elseif($query === 0){
                return $query;
            }else{
                throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
            }
    }

    public static function delete_substep($substep_id){

        $substep = DB::delete('substep')
                    ->where('id', $substep_id)
                    ->execute();

        $clear = DB::delete('clear')
                    ->where('substep_id', $substep_id)
                    ->execute();


            if (is_int($substep) && is_int($clear)) {
                    return true;
            }else{
                    throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
            }
    }

    public static function valid_email($email){

        $count = DB::query("SELECT count(*) FROM users WHERE email = '" . $email . "' AND delete_flg = 0")->execute()->as_array();

        return $count[0]['count(*)'];

    }

    public static function get_username($email){
        $query = DB::query("SELECT username FROM users where email = '" .$email . "'")->execute()->as_array();

        if ($query) {
            return $query;
        }elseif($query === 0){
            return $query;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }

    }
    
    public static function count_time(){
        $user_id = Auth::get_user_id();

        $query = DB::query("SELECT id, time FROM mainstep where user_id = '" .$user_id[1] . "' ORDER BY timestamp DESC")->execute()->as_array();
        
        if ($query) {
            return $query[0];
        }elseif($query === 0){
            return $query[0];
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }
    public static function count_time2($id){

        $query = DB::query("SELECT time FROM mainstep where id = '" .$id . "'")->execute()->as_array();
        
        if ($query) {
            return $query;
        }elseif($query === 0){
            return $query;
        }else{
            throw new Exception('サーバーのメンテナンス中です。数時間たってもアクセスできない場合は運営にご連絡ください');
        }
    }

    public static function count_subtime($step_id){

        $query = DB::query("SELECT time FROM substep where mainstep_id = '" .$step_id . "'")->execute()->as_array();
        
        return $query;
    }
    
    public static function current_time($substep_id){

        $query = DB::query("SELECT time FROM substep where id = '" .$substep_id . "'")->execute()->as_array();
        
        return $query[0]['time'];
    }
    
    public static function get_humaninfo($step_id){
        
        $user_id = DB::query("SELECT user_id FROM mainstep WHERE id = '" .$step_id . "'")->execute()->as_array();

       $query = DB::query("SELECT image, introduction FROM users WHERE id = '" .$user_id[0]['user_id'] . "'")->execute()->as_array();

        return $query[0];
    }
    
    public static function clear_flg($challenge_id){

        $query = DB::query("SELECT substep_id FROM clear where challenge_id = '" .$challenge_id . "'")->execute()->as_array();

        return count($query);

    }
    
}

