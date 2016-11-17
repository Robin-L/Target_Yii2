<?php 

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\EntryForm;

class TestController extends Controller
{
	public function actionSay($message = 'Hello')
	{
		return $this->render('say', ['message' => $message]);
	}

	public function actionEntry()
	{
		$model = new EntryForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			return $this->render('entry-confirm', ['model' => $model]);
		} else {
			return $this->render('entry', ['model' => $model]);
		}
	}
}