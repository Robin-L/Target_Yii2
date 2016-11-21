<?php 
namespace components;

use yii;
use yii\base\Widget;
use yii\helpers\Html;
use backend\models\Faq;
use backend\models\search\FaqSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;

class FaqWidget extends Widget
{
	public $models;
	public $pages;
	public $settings = [];

	public function init()
	{
		parent::init();

		if (!isset($this->settings['pageSize'])) {
			$this->settings['pageSize'] = 2;
		}

		if ($this->settings['featuredOnly'] === true) {
			$query = Faq::find()->where(['faq_is_featured' => 1]);
		} else {
			$query = Faq::find();
		}

		// $query = Faq::find()->where(['faq_is_featured' => 1]);
		$query->orderBy(['faq_weight' => SORT_ASC]);
		$countQuery = clone $query;
		$this->pages = new Pagination(['defaultPageSize' => $this->settings['pageSize'], 'totalCount' => $countQuery->count()]);
		$this->models = $query->offset($this->pages->offset)->limit($this->pages->limit)->all();
	}

	public function run()
	{
		return $this->render('faq', [
			'models' 	=> $this->models, 
			'pages' 	=> $this->pages, 
			'settings'	=> $this->settings,
		]);
	}
}