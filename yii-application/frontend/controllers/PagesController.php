<?php  

namespace frontend\controllers;

use Yii;
use frontend\models\ContactForm;
use yii\filters\AccessControl;
use backend\models\search\CarouselSettingsSearch;

class PagesController extends \yii\web\Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'only' => ['captcha'],
				'rules' => [
					[
						'actions' => ['captcha'],
						'allow' => true,
						'roles' => ['?', '@'],
					],
				],
			]
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
		$carouselSettings = CarouselSettingsSearch::getCarouselSettings('Front Page');
		return $this->render('index', ['carouselSettings' => $carouselSettings]);
	}

	public function actionAbout()
	{
		return $this->render('about');
	}

	public function actionContat()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
				Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
			} else {
				Yii::$app->session->setFlash('error', 'There was an errr sending email.');
			}
			return $this->refresh();
		} else {
			return $this->render('contact', ['model' => $model]);
		}
	}

	public function actionPrivacy()
	{
		return $this->render('privacy');
	} 

	public function actionTermsService()
	{
		return $this->render('terms-service');
	}
}