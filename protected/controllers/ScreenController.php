<?php

class ScreenController extends Controller
{
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array(),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','delete','want','thumbs'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','update','index','view'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        if(!ctype_digit ($id) ) throw new CHttpException(404,'The requested page does not exist.');
        $model=Bot::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        if($model->user_id!=Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        $dataProvider=new CActiveDataProvider('Screen',array(
            'criteria'=>array(
                'condition'=>'bot_id='.$model->id,
                'order'=>'uploadedtime DESC',
            )));

		$this->render('view',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Screen;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Screen']))
		{
			$model->attributes=$_POST['Screen'];
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

		if(isset($_POST['Screen']))
		{
			$model->attributes=$_POST['Screen'];
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
	public function actionDelete($id,$t)
	{
        if($t==1){
            if(!ctype_digit ($id) ) throw new CHttpException(404,'The requested page does not exist.');
            $model=Screen::model()->with('bot')->findByPk($id);
        }else{
            $model=Screen::model()->with('bot')->findByAttributes(array('delete'=>$id));
        }
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        if($model->bot->user_id != Yii::app()->user->id)
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        if($t==1){
            // http://doc-help.net/screen/sc/1348520796.jpg
            $r = preg_match('!(.*)/sc/(\d*).jpg!is', $model->link, $result);
            if(preg_match('@http://.*@is', $model->link, $subpattern))
                fopen($result[1]."/upload.php?delete=".$result[2], "r");
            else
                fopen("http://".$result[1]."/upload.php?delete=".$result[2], "r");

        }
        $model->delete();
        Yii::app()->end();
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Screen');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionThumbs($id)
	{
        if(!ctype_digit ($id) ) throw new CHttpException(404,'The requested page does not exist.');
        $model=Bot::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        if($model->user_id!=Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');

        $dataProvider=new CActiveDataProvider('Screen',array(
            'criteria'=>array(
                'condition'=>'bot_id='.$model->id,
                'order'=>'uploadedtime DESC',
            )));

        $this->widget('bootstrap.widgets.TbThumbnails', array(
            'dataProvider'=>$dataProvider,
            'template'=>"{items}\n{pager}",
            'itemView'=>'_thumb',
            'htmlOptions'=>array('id'=>'thumbs'),
        ));
	}

    public function actionWant($id)
	{
        if(!ctype_digit ($id) ) throw new CHttpException(404,'The requested page does not exist.');
        $model=Bot::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        if($model->user_id!=Yii::app()->user->id)
            throw new CHttpException(404,'The requested page does not exist.');
        $model->wantscreen = 1;
        //Yii::app()->user->setFlash('success', '<strong>Requested Screenshot!</strong>');
        if($model->save())
        $this->widget('bootstrap.widgets.TbAlert', array(
            'block'=>true, // display a larger alert block?
            'fade'=>true, // use transitions?
            'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
            'alerts'=>array( // configurations per alert type
                'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
            ),
        ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Screen('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Screen']))
			$model->attributes=$_GET['Screen'];

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
		$model=Screen::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='screen-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
