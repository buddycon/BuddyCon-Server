<?php
/**
 * User: Command
 * Date: 08.09.12
 */

/*
 *
 * : {"upload":{"image":{"name":null,"title":null,"caption":null,"hash":"oZnWx","deletehash":"nJwCR4zpUXU7I0W","datetime":"2012-09-09 00:48:28","type":"image\/jpeg","animated":"false","width":1680,"height":988,"size":228631,"views":0,"bandwidth":0},"links":{"original":"http:\/\/i.imgur.com\/oZnWx.jpg","imgur_page":"http:\/\/imgur.com\/oZnWx","delete_page":"http:\/\/imgur.com\/delete\/nJwCR4zpUXU7I0W","small_square":"http:\/\/i.imgur.com\/oZnWxs.jpg","large_thumbnail":"http:\/\/i.imgur.com\/oZnWxl.jpg"}}}
 */
class ApiController extends Controller
{
    public static  $response = array('response'=>"success");
    public static function respond($resp,$die=true,$version=1043){
        if (str_replace('.', '', $_POST['version'])>= $version){
            ApiController::$response['response'] = $resp;
        }else{
            if($die)
                die($resp);
            else
                echo $resp;
        }
    }

    public static $com;
    public static $dataArr= array();

    public static function binds($post,$db,$bool,$default=1){
        if(isset($_POST[$post])){
            if($bool)
                ApiController::$com->bindValue(":".$db,$_POST[$post]);
            else
                ApiController::$com->bindValue(":".$db,$default);
        }
    }
    public static function updateSQL($post,$bool=true){
        if(isset($_POST[$post]) && $_POST[$post] != "" && $bool){
            ApiController::$dataArr[$post] = $_POST[$post];
        }
    }

    public function actionIndex()
    {
        /*Yii::log("++++++++++++++++++++++++++++++++++++++++++++++++++++++++++", "info", "test");
        foreach($_POST as $key => $val){
            Yii::log($key." - ".$val, "info", "test");
        }*/
        //$_POST = $_REQUEST;
        if(!isset($_POST['version']))
            die("New Plugin Version available! This version isnt supported");
        elseif(str_replace('.', '', $_POST['version'])< 1050)
            echo "New Plugin Version available!";

        if(!array_key_exists('apikey', $_POST) || $_POST['apikey'] == ""){
            Yii::log("No Api", "info", "test");
            ApiController::respond("No Api Code ".array_key_exists('apikey', $_POST));
        }else{
            $connection=Yii::app()->db;
            $sql = 'SELECT id FROM user WHERE apikey = :apikey';
            $command=$connection->createCommand($sql);
            $command->bindValue(":apikey",$_POST['apikey']);
            $bot=$command->queryRow();
            if(!$bot)ApiController::respond("No User");
            else{
                $user_id = $bot['id'];

                $sql = 'SELECT id,do,wantscreen FROM bot WHERE user_id = :user AND name = :name';
                $command=$connection->createCommand($sql);
                $command->bindValue(":user",$user_id);
                $command->bindValue(":name",$_POST['name']);
                $bot=$command->queryRow();
                if(!$bot)$insert =true;
                else $insert = false;

                ApiController::$com=$connection->createCommand();

                ApiController::$dataArr['user_id'] =$user_id;
                ApiController::$dataArr['name'] =$_POST['name'];
                ApiController::$dataArr['latestupdate'] = time();
                ApiController::$dataArr['lastvisit'] = null;
                ApiController::$dataArr['wantscreen'] = "";
                ApiController::$dataArr['do'] = "";

                ApiController::updateSQL("gold");
                ApiController::updateSQL("xp");
                ApiController::updateSQL("xp_needed");
                ApiController::updateSQL("xph");
                ApiController::updateSQL("timetolevel");
                ApiController::updateSQL("kills");
                ApiController::updateSQL("killsh");
                ApiController::updateSQL("honor");
                ApiController::updateSQL("honorh");
                ApiController::updateSQL("death");
                ApiController::updateSQL("deathh");
                ApiController::updateSQL("bgwin");
                ApiController::updateSQL("bglost");


                if(isset($_POST{'level'}) && ($_POST{'level'} < 91 && $_POST{'level'} > 0))
                    ApiController::$dataArr['level'] =$_POST['level'];

                if(isset($_POST{'runningtime'}) && $_POST{'runningtime'}!=""){
                    ApiController::$dataArr['running'] =$_POST['runningtime'];
                }else
                    ApiController::$dataArr['running'] = 0;

                if(isset($_POST{'nodeh'}) && $_POST{'nodeh'}!="{}"){
                    ApiController::$dataArr['nodes'] =$_POST['nodeh'];
                }else
                    ApiController::$dataArr['nodes'] ="{}";

                if($insert) ApiController::$com->insert('bot', ApiController::$dataArr);
                else  ApiController::$com->update('bot', ApiController::$dataArr, "id=:id", array(':id'=>$bot['id']));

                if(!$insert){
                    if($bot['wantscreen']){
                        ApiController::respond("screen",false);
                        //Yii::log("Screen Requested", "info", "test");
                    }
                    if($bot['do']!=null && $bot['do']!=""){
                        ApiController::respond($bot['do'],false);
                    }
                }

                $dataReaderUp=ApiController::$com->execute();

                if(isset($_POST['status']) && $_POST['status']!="{}"){
                    $json = CJSON::decode($_POST['status']);
                    $sql = 'INSERT INTO status (message,latestupdate,bot_id) VALUES(:message,:up,:bot)';
                    $command=$connection->createCommand($sql);
                    foreach($json as $value){
                        $command->bindValue(":message",$value);
                        $command->bindValue(":bot",$bot['id']);
                        $command->bindValue(":up",time());
                        $command->execute();
                    }
                }

                if($_POST['chat_message']!=""){
                    $sql = 'INSERT INTO chat (message,`from`,`type`,sended,bot_id) VALUES(:message,:from,:type,:send,:bot)';
                    $command=$connection->createCommand($sql);
                    $command->bindValue(":message", $_POST['chat_message']);
                    $command->bindValue(":from", $_POST['chat_from']);
                    $command->bindValue(":type", $_POST['chat_type']);
                    $command->bindValue(":bot",$bot['id']);
                    $command->bindValue(":send",time());
                    $command->execute();
                }
                if($_POST['screen']!=""){
                    $json = CJSON::decode($_POST['screen']);
                    if(isset($json['hasthumb'])){
                        // own img host
                        $sql = 'INSERT INTO screen (bot_id,`delete`,thumb,uploadedtime,private,link) VALUES(:bot,:del,:thumb,:send,:prv,:link)';
                        $command=$connection->createCommand($sql);
                        if($json['hasthumb']) $command->bindValue(":thumb", 1);
                        else  $command->bindValue(":thumb", null);

                        $command->bindValue(":del", null);
                        $command->bindValue(":link", $json['file']);

                        $command->bindValue(":prv", 1);

                        $command->bindValue(":bot",$bot['id']);
                        $command->bindValue(":send",time());
                        $command->execute();
                    }else{
                        // imgur img host
                        $data = $json['upload']['image'];

                        $sql = 'INSERT INTO screen (bot_id,`delete`,thumb,uploadedtime,private,link) VALUES(:bot,:del,:thumb,:send,:prv,:link)';
                        $command=$connection->createCommand($sql);

                        $command->bindValue(":thumb", null);

                        $command->bindValue(":del", $data['deletehash']);
                        $command->bindValue(":link", $data['hash']);

                        $command->bindValue(":prv", 0);

                        $command->bindValue(":bot",$bot['id']);
                        $command->bindValue(":send",time());
                        $command->execute();
                    }

                }



                $sql = 'SELECT * FROM reply WHERE bot_id = :bot ORDER BY id ASC';
                $command=$connection->createCommand($sql);
                $command->bindValue(":bot",$bot['id']);
                $rep=$command->queryRow();
                if($rep){
                    ApiController::respond("chat");
                    ApiController::$response['message'] = $rep['message'];
                    ApiController::$response['to'] = $rep['to'];
                    ApiController::$response['type'] = $rep['type'];

                    $sql = 'DELETE FROM reply WHERE bot_id = :bot AND (sended<:ti OR id = :id)';
                    $command=$connection->createCommand($sql);
                    $command->bindValue(":bot",$bot['id']);
                    $command->bindValue(":ti",time()-120);
                    $command->bindValue(":id",$rep['id']);
                    $command->execute();
                }else{
                    $sql = 'DELETE FROM reply WHERE bot_id = :bot AND sended<:ti';
                    $command=$connection->createCommand($sql);
                    $command->bindValue(":bot",$bot['id']);
                    $command->bindValue(":ti",time()-120);
                    $command->execute();
                }


            }


            /*
           $user = User::model()->findByAttributes(array('apikey'=>$_POST['apikey']));
           if($user == null){
               Yii::log("No User", "info", "test");
               ApiController::respond("No User");
           }else{
               $bot = Bot::model()->findByAttributes(array('user_id'=> $user->id, 'name'=>  $_POST{'name'}, ));
               if($bot == null){
                   Yii::log("New Bot ".$_POST{'name'}, "info", "test");
                   $bot = new Bot;
               }

               $bot->user_id = $user->id;
               $bot->name = $_POST{'name'};

               if($_POST{'level'} > 90 || $_POST{'level'} <1){
                   $bot->level = 1;
                   Yii::log("----------------------------------------------------------------", "info", "test");
                   foreach($_POST as $key => $val){
                       Yii::log($key." - ".$val, "info", "test");
                   }
               }else
                   $bot->level = $_POST{'level'};

               if($_POST{'xp'} > 32800000)
                   $bot->xp = 1;
               else
                   $bot->xp = $_POST{'xp'};

               if($_POST{'xp_needed'} > 32800000)
                   $bot->xp_needed = 1;
               else
                   $bot->xp_needed = $_POST{'xp_needed'};
*/
            /*
               $bot->gold = $_POST{'gold'};
               $bot->latestupdate = time();
               if($bot->wantscreen){
                   ApiController::respond("screen",false);
                   Yii::log("Screen Requested", "info", "test");
                   $bot->wantscreen = 0;
               }else{
                   $bot->wantscreen = 0;
               }
               if($bot->do!=null && $bot->do!=""){
                   ApiController::respond($bot->do,false);
                   $bot->do = null;
               }

               if(isset($_POST{'nodeh'}) && $_POST{'nodeh'}!="{}"){
                   $bot->nodes = $_POST{'nodeh'};
               }else{
                   $bot->nodes = null;
               }

               if(isset($_POST{'runningtime'}) && $_POST{'runningtime'}!=""){
                   $bot->running = round($_POST{'runningtime'});
               }
               if(str_replace('.', '', $_POST['version'])>= 1047){
                   $bot->timetolevel=$_POST['timeolevel'];
                   $bot->xph= $_POST['xph'];
                   $bot->kills=$_POST['kills'];
                   $bot->killsh=$_POST['killsh'];
                   $bot->honor=$_POST['honor'];
                   $bot->honorh=$_POST['honorh'];
                   $bot->death=$_POST['death'];
                   $bot->deathh=$_POST['deathh'];
                   $bot->bgwin=$_POST['bgwin'];
                   $bot->bglost=$_POST['bglost'];
               }


               // ++++++++++++++++++++++++++++++++++++++++++++ saving bot
               if(!$bot->save()){
                   $err = "err: ";
                   foreach ($bot->getErrors() as $attrname => $errlist )
                   {
                       $err .= "  Errorred attribute: $attrname\n";
                       foreach ($errlist as $err)
                       {
                           $err .= "    $err\n";
                       }
                   }
                   Yii::log("No Bot ".$err, "info", "test");
               }
*/
            /*
               $bot->refresh();

               if(isset($_POST['status']) && $_POST['status']!="{}"){
                   $json = CJSON::decode($_POST['status']);
                   foreach($json as $value){
                       $stat = new Status();
                       $stat->bot_id = $bot->id;
                       $stat->latestupdate = time();
                       $stat->message = $value;
                       if(!$stat->save()) ApiController::respond("No Status");
                   }
               }

               if($_POST['chat_message']!=""){
                   $chat = new Chat();
                   $chat->bot_id = $bot->id;
                   $chat->message = $_POST['chat_message'];
                   $chat->from = $_POST['chat_from'];
                   $chat->type = $_POST['chat_type'];
                   $chat->sended = time();
                   if(!$chat->save()) ApiController::respond("No Chat");
               }
               if($_POST['screen']!=""){
                   $json = CJSON::decode($_POST['screen']);
                   if(isset($json['hasthumb'])){
                       $screen = new Screen();
                       $screen->bot_id = $bot->id;
                       $screen->private = 1;
                       $screen->link = $json['file'];
                       if($json['hasthumb']) $screen->thumb = 1;
                       $screen->uploadedtime = time();
                       if(!$screen->save()) ApiController::respond("No Save IMG own Host");
                   }else{
                       $data = $json['upload']['image'];
                       $screen = new Screen();
                       $screen->bot_id = $bot->id;
                       $screen->link = $data['hash'];
                       $screen->delete = $data['deletehash'];
                       //$screen->thumb = $json['chat_type'];
                       $screen->uploadedtime = time();
                       if(!$screen->save()) ApiController::respond("No Save IMG");
                   }

               }

               Reply::model()->deleteAll('sended<:ti',array('ti'=>time()-60));
               $criteria = new CDbCriteria;
               $criteria->order = 'id ASC';
               $reply = Reply::model()->findByAttributes(array('bot_id'=>$bot->id),$criteria);
               if($reply != null){
                   ApiController::respond("chat");
                   ApiController::$response['message'] = $reply->message;
                   ApiController::$response['to'] = $reply->to;
                   ApiController::$response['type'] = $reply->type;

                   $reply->delete();

               }
           }
       }*/
       if(str_replace('.', '', $_POST['version'])>= 1043){
           echo CJSON::encode(ApiController::$response);
        }




        foreach(Yii::app()->db->getStats() as $k=>$v)
            Yii::log($k." - ".$v, "info", "api");
        Yii::app()->db->active = false;


       // Yii::log("Success", "info", "test");m
    }
    }
    public function actionMobile(){

        if(!isset($_POST['user']) || !isset($_POST['pass']) )  die(CJSON::encode(array("code"=>"noLogin")));
        $user = User::model()->findByAttributes(array('username'=>$_POST['user']));
        if($user===null) die(CJSON::encode(array("code"=>"noUser")));
        else if($user['password']!==crypt($_POST['pass'] , $user->password)) die(CJSON::encode(array("code"=>"falsePW")));

        //if(isset($_POST['lg']) && $_POST['lg'] == "true") die("success");
       // $user->lastcheck = time()-60*60*24*6;

       // $bots = Bot::model()->findAll('user_id = :user AND ')
        $status = Status::model()->with('bot')->findAll(array(
            'condition' => 'bot.user_id = :user AND t.latestupdate > :dat AND message NOT LIKE "Xp gain: %"',
            'params' => array('user'=>$user->id, 'dat'=>$user->lastcheck ),
            'order' => 't.latestupdate DESC'
        ));

        $retstat = array();
        foreach($status as $stat){
            $retstat[] = array(
                'name' => $stat->bot->name,
                'time' => $stat->latestupdate,
                'message' => $stat->message,
            );

        }
        //CVarDumper::dump($retstat,10,true);

        $chat = Chat::model()->with('bot')->findAll(array(
            'condition' => 'bot.user_id = :user AND t.sended > :dat',
            'params' => array('user'=>$user->id, 'dat'=>$user->lastcheck ),
            'order' => 't.sended DESC'
        ));

        $retchat = array();
        foreach($chat as $ch){
            $retchat[] = array(
                'name' => $ch->bot->name,
                'time' => $ch->sended,
                'message' => $ch->message,
                'from' => $ch->from,
            );

        }
        //CVarDumper::dump($retchat,10,true);

        $result = array(
            'count' => count($retstat)+count($retchat),
            'status'=>$retstat,
            'chat'=>$retchat,
            'login'=>"success"
        );

        $user->lastcheck = time();
        $user->save();
        echo CJSON::encode($result);
        Yii::app()->db->active = false;


    }
}
