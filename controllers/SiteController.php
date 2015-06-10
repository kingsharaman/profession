<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;
use app\models\ListingForm;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new ListingForm();
		
		$id = Yii::$app->request->get('id');
		
		if(!$id) {
			$id = 1;
		}
		
		$listing[$model->formName()] = Yii::$app->db->createCommand('SELECT * FROM job_listings WHERE id=:id')->bindValue(':id', $id)->queryOne();
		
		$model->load($listing);
		
        return $this->render('review', ['model' => $model, 'layout' => 'main']);
        return $this->render('index');
    }
    
	public function actionReview()
	{
        $model = new ListingForm();		
		
		$listing[$model->formName()] = Yii::$app->db->createCommand('SELECT * FROM job_listings WHERE id=:id')->bindValue(':id', Yii::$app->request->get('id'))->queryOne();
		
		$model->load($listing);
		
        return $this->render('review', ['model' => $model, 'layout' => 'main']);
	}
	
	public function actionActivate()
	{
        $model = new ListingForm();
		
		$id = Yii::$app->request->post($model->formName())["id"];
		
		Yii::$app->db->createCommand('UPDATE job_listings SET status=\'aktív\' WHERE id=:id')->bindValue(':id', $id)->execute();
		Yii::$app->db->createCommand('UPDATE job_listings SET activated=NOW() WHERE id=:id')->bindValue(':id', $id)->execute();
		
		$listing[$model->formName()] = Yii::$app->db->createCommand('SELECT * FROM job_listings WHERE id=:id')->bindValue(':id', $id)->queryOne();
		
		$model->load($listing);
		
		//$model->id = $listing["id"];
		/*$model->title = $listing["title"];
		$model->status = $listing["status"];
		$model->activated = $listing["activated"];
		$model->email = $listing["email"];*/
		
		mail($model->email, 'Hirdetés aktiválása', $model->id." azonosítójú hirdetését ".$model->activated."-kor sikeresen aktiváltuk.");		
		
        return $this->render('activate', ['model' => $model, 'layout' => 'main']);
	}
}
