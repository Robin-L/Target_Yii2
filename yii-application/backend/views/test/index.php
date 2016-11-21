<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
// use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'FAQs';
$this->params['breakcrumbs'][] = $this->title;
?>
<div class="site-about">
	<h1><?= Html::encode($this->title) ?></h1>
	<br>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Questions</h3>
		</div>
		<?php  
			foreach ($models as $model) {
				$url = Url::to(['faq/view', 'id' => $model->id]);
				$options = [];
				echo '<div class="panel-body">' . Html::a($model->faq_question, $url, $options) . '</div>';
			}
			echo LinkPager::widget(['pagination' => $pages]);
			/*$data = $provider->getModels();
			$questions = ArrayHelper::map($data, 'faq_question', 'id');
			foreach ($questions as $question => $id) {
				$url = Url::to(['faq/view', 'id' => $id]);
				$options = [];
				echo '<div class="panel-body">' . Html::a($question, $url, $options) . '</div>';
			}*/
		?>
	</div>
</div>
