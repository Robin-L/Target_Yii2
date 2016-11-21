<?php 

namespace frontend\controllers;

use yii;
use backend\models\Faq;
use backend\models\search\FaqSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class FaqController extends Controller
{
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
		];
	}

	public function actionIndex()
	{
		$searchModel = new FaqSearch();
		$provider = $searchModel->frontendProvider();

		return $this->render('index', [
				'searchModel' => $searchModel,
				'provider'	=> $provider,
			]);
	}

	public function actionView($id, $slug=null)
	{
		$model = $this->findModel($id);
		if ($slug == $model->slug) {
			return $this->render('view', [
				'model' => $model,
				'slug'  => $model->slug
			]);
		} else {
			throw new NotFoundHttpException('The requested Faq does not exist.');
		}
		
	}

	protected function findModel($id)
	{
		if (($model = Faq::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException('The requested page does not exist.');
		}
	}

}