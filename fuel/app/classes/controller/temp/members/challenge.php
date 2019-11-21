<?php
//===================================================================================================
//チャレンジ(STEP)機能実装
//===================================================================================================

class Controller_Temp_Members_Challenge extends Controller_Temp_Members{

    public function action_index(){


      if(!empty($_SERVER['HTTP_REFERER'])){ //url改ざんされた場合にelse以下の処理が走り、mypageへ遷移させる

        $url = strtok(basename($_SERVER['HTTP_REFERER']), '?');

        if($url === 'detailstep' ){

          $step_id = $_GET['step_id'];
  
              //マイページへ
              //新しいテーブルにインサート（mainstepとチャレンジしたい人を紐付けるため）
              try {
                \Model_Edit::make_challenge($step_id);
                
                Response::redirect('temp/members/mypage');
    
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
  
        }elseif($url === 'mypage' || $url === 'challenge' || $url === 'detailchallenge' || $url === 'clear'){
    
          $challenge_id = $_GET['challenge_id'];
          $step_id = $_GET['step_id'];
  
          try {
            $data = \Model_Edit::get_challenge($step_id, $challenge_id);
            
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
              $view->set('content', View::forge('challenge'));
              $view->set_global('step_id', $step_id);
              $view->set_global('title', $data[0]['title']);
              $view->set_global('content', $data[0]['content']);
              $view->set_global('time', $data[0]['time']);
              $view->set_global('category', $data[0]['category']);
              $view->set_global('substeplist', $data);
              $view->set_global('challenge_id', $challenge_id);
              $view->set_global('clear_count', $clear_data);
  
              return $view;
        }

      }else{
        Response::redirect('temp/members/mypage');
        
      }

      
        
    }
}

