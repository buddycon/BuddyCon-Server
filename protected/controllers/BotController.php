<?php

class BotController extends Controller
{
    protected function beforeAction($action) {

        return parent::beforeAction($action);
    }
    protected function afterAction($action) {

        return parent::afterAction($action);
    }
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','delete','do'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public static function parseType($string){
        switch($string){
            case ("CHAT_MSG_BATTLEGROUND"):
                return "BG";
            break;
            case ("CHAT_MSG_BATTLEGROUND_LEADER"):
                return "BG";
            break;
            case ("CHAT_MSG_EMOTE"):
                return "Emote";
            break;
            case ("CHAT_MSG_GUILD"):
                return "Guild";
            break;
            case ("CHAT_MSG_PARTY"):
                return "Party";
            break;
            case ("CHAT_MSG_PARTY_LEADER"):
                return "Party";
            break;
            case ("CHAT_MSG_RAID"):
                return "Raid";
            break;
            case ("CHAT_MSG_RAID_LEADER"):
                return "Raid";
            break;
            case ("CHAT_MSG_SAY"):
                return "Say";
            break;
            case ("CHAT_MSG_WHISPER"):
                return "Whisper";
            break;
            case ("CHAT_MSG_YELL"):
                return "Yell";
            break;

            default:
                return $string;
            break;
        }
    }
    static function rgb2html($r, $g=-1, $b=-1)
    {
        if (is_array($r) && sizeof($r) == 3)
            list($r, $g, $b) = $r;

        $r = intval($r); $g = intval($g);
        $b = intval($b);

        $r = dechex($r<0?0:($r>255?255:$r));
        $g = dechex($g<0?0:($g>255?255:$g));
        $b = dechex($b<0?0:($b>255?255:$b));

        $color = (strlen($r) < 2?'0':'').$r;
        $color .= (strlen($g) < 2?'0':'').$g;
        $color .= (strlen($b) < 2?'0':'').$b;
        return '#'.$color;
    }
    public static function parseTypeColor($string){
        switch($string){
            case ("CHAT_MSG_BATTLEGROUND"):
                return BotController::rgb2html(255,127,0);
            break;
            case ("CHAT_MSG_BATTLEGROUND_LEADER"):
                return BotController::rgb2html(255,127,0);
            break;
            case ("CHAT_MSG_EMOTE"):
                return BotController::rgb2html(255,128,64);
            break;
            case ("CHAT_MSG_GUILD"):
                return "#3FB810";//BotController::rgb2html(64,255,64);
            break;
            case ("CHAT_MSG_PARTY"):
                return BotController::rgb2html(170,170,255);
            break;
            case ("CHAT_MSG_PARTY_LEADER"):
                return BotController::rgb2html(170,170,255);
            break;
            case ("CHAT_MSG_RAID"):
                return BotController::rgb2html(255,127,0);
            break;
            case ("CHAT_MSG_RAID_LEADER"):
                return BotController::rgb2html(255,127,0);
            break;
            case ("CHAT_MSG_SAY"):
                return BotController::rgb2html(0,0,0);
            break;
            case ("CHAT_MSG_WHISPER"):
                return BotController::rgb2html(255,128,255);
            break;
            case ("CHAT_MSG_YELL"):
                return BotController::rgb2html(255,64,64);
            break;

            default:
                return $string;
            break;
        }
    }

    public function actionDo($id){
        $model=$this->loadModel($id);
        if(isset($_POST['ajax'])){
            if($_POST['ajax'] == "st"){
                $model->do = "starthb";
            }
            if($_POST['ajax'] == "sp"){
                $model->do = "stophb";
            }
            $model->save();
        }
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{

        $model=$this->loadModel($id);
        if($model->filter == ""){
            $model->filter = CJSON::encode(array(
                'bg'=>      true,
                'guild'=>   true,
                'yell'=>    true,
                'say'=>     true,
            ));
            $model->save();
        }
        if(!isset($_POST['ajax'])){
            $model->lastvisit = time();
            $model->save();
        }elseif($_POST['ajax']=="true"){
            if(!is_bool((bool)$_POST['bg']) || !is_bool((bool)$_POST['guild']) || !is_bool((bool)$_POST['yell']) || !is_bool((bool)$_POST['say']))
                throw new CHttpException(404,'The requested page does not exist.');

            $arr = CJSON::encode(array(
                'bg'=>$_POST['bg'],
                'guild'=>$_POST['guild'],
                'yell'=>$_POST['yell'],
                'say'=>$_POST['say'],
            ));
            if($arr!=$model->filter){
                //throw new CHttpException(501,'The requested page does not exist.');

                $model->filter = $arr;
                $model->save();
            }

        }

        $filter = new FilterChat($model->filter);

        $cond = "";
        if($filter->guild=="false") $cond .= " AND type <> 'CHAT_MSG_GUILD'";
        if($filter->say=="false") $cond .= " AND type <> 'CHAT_MSG_SAY'";
        if($filter->yell=="false") $cond .= " AND type <> 'CHAT_MSG_YELL'";
        if($filter->bg=="false") $cond .= " AND type <> 'CHAT_MSG_BATTLEGROUND_LEADER' AND type <> 'CHAT_MSG_BATTLEGROUND'";

        $chatModel = new Reply();
        $dataProvider=new CActiveDataProvider('Chat',array(
            'criteria'=>array(
                'condition'=>'bot_id='.$id.$cond,
                'order'=>'sended DESC',

            )));
        $dataProviderS=new CActiveDataProvider('Status',array(
            'criteria'=>array(
                'condition'=>'bot_id='.$id,
                'order'=>'latestupdate DESC',
            )));
        $json=CJSON::decode($model->nodes);
        //CVarDumper::dump($json,10,1);
        if(count($json)>0){
            $arr=array();
            $i=0;
            $all = 0;
            foreach($json as $key => $value){
                $arr[] = array('id'=>$i++, 'Gathered'=>$key,"Count"=>$value);
                $all += $value;
            }
            $arr[] = array('id'=>$i++, 'Gathered'=>"Sum","Count"=>$all);
            $arr[] = array('id'=>$i++, 'Gathered'=>"Nodes per hour (avg)","Count"=>$all/($model->running/60/60));
            $dataProviderG = new CArrayDataProvider($arr,array(
                //'id'=> 'id'
                'pagination'=>array(
                   'pageSize'=>100,
               ),

            ));
        }else
            $dataProviderG = null;


        if(isset($_POST['ajax'])){
            if($_POST['ajax'] == "clch"){
                Chat::model()->deleteAllByAttributes(array('bot_id'=>$id));
            }
            if($_POST['ajax'] == "clst"){
                Status::model()->deleteAllByAttributes(array('bot_id'=>$id));
            }
            if($_POST['ajax'] == "repl"){
                $chatModel->bot_id = $id;
                $fail = false;
                if(!isset($_POST['message'])){
                    Yii::app()->user->setFlash('error', '<strong>FAIL!</strong> Messages need message!');
                    $fail=true;
                }
                if($_POST['message']=="") {
                    Yii::app()->user->setFlash('error', '<strong>FAIL!</strong> Messages need message!');
                    $fail=true;
                }
                if($_POST['type']==3 && !isset($_POST['to'])) {
                    Yii::app()->user->setFlash('error', '<strong>FAIL!</strong> Whisper need recipient!');
                    $fail=true;
                }
                if($_POST['type']==3 && $_POST['to']=="") {
                    Yii::app()->user->setFlash('error', '<strong>FAIL!</strong> Whisper need recipient!');
                    $fail=true;
                }
                $chatModel->message = $_POST['message'];

                if(!$fail){
                    switch((int)$_POST['type']){
                        case(0):
                            $chatModel->type = "GUILD";
                            break;
                        case(1):
                            $chatModel->type = "SAY";
                            break;
                        case(2):
                            $chatModel->type = "YELL";
                            break;
                        case(3):
                            $chatModel->type = "WHISPER";
                            $chatModel->to = $_POST['to'];
                            break;
                        case(4):
                            $chatModel->type = "BATTLEGROUND";
                            break;
                    }
                    $chatModel->sended = time();
                    if(!$chatModel->save()) Yii::app()->user->setFlash('error', '<strong>FAIL!</strong> Something was wrong?!');
                    $newChat = new Reply();
                    Yii::app()->user->setFlash('success', '<strong>Success!</strong> Chat message sent.');
                }else{
                    $chatModel->type = (int)$_POST['type'];

                    $newChat = $chatModel;
                }
                Yii::app()->db->active = false;

                $this->renderPartial('_chat',array(
                    'model'=>$newChat,
                ));

            }else{
                Yii::app()->db->active = false;

                $this->renderPartial('_chatnstatus',array(
                    'dataProvider'=>$dataProvider,
                    'dataProviderS'=>$dataProviderS,
                    'dataProviderG'=>$dataProviderG,

                ));
            }
        }else{
            Yii::app()->db->active = false;

            $this->render('view',array(
                'model'=>$this->loadModel($id),
                'filter'=>$filter,
                'chatModel'=>$chatModel,
                'dataProvider'=>$dataProvider,
                'dataProviderS'=>$dataProviderS,
                'dataProviderG'=>$dataProviderG,
            ));
        }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Bot;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bot']))
		{
		
			$model->attributes=$_POST['Bot'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Bot']))
		{
			$model->attributes=$_POST['Bot'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        //Yii::app()->user->setFlash('success', '<strong>Well done!</strong> You successfully read this important alert message.');
		$dataProvider=new CActiveDataProvider('Bot',array(
            'criteria'=>array(
                'condition'=>'user_id='.Yii::app()->user->id,
                'order'=>'latestupdate DESC',
            )));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Bot('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Bot']))
			$model->attributes=$_GET['Bot'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
        if(!ctype_digit ($id) ) throw new CHttpException(404,'The requested page does not exist.');
		$model=Bot::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
        if($model->user_id!=Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.'.Yii::app()->user->id);
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bot-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
