<?php  
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
?>

<div class="site-about">
<br>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?= $settings['heading']; ?>
			</h3>
		</div>
		<?php  
			foreach ($models as $model) {
				$url = Url::toRoute('faq/' . $model->id . '/' . $model->slug);
				// $url = Url::to(['faq/view', 'id' => $model->id]);
				$options = [];
				echo '<div class="panel-body">' . Html::a($model->faq_question, $url, $options) . '</div>';
			}

			echo LinkPager::widget(['pagination' => $pages]);
		?>
	</div>
</div>