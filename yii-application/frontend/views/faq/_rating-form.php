<?php  
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\StarRating;
?>

<div class="faq-rating-form">
	<?php $form = ActiveForm::begin(['method' => 'post', 'action' => ['faq-rating/rating']]); ?>
	<?= Html::activeHiddenInput($faqRating, 'faq_id', ['value' => $model->id]) ?>
	<?= $form->field($faqRating, 'faq_rating')->label('Rate This FAQ')->widget(StarRating::className(), ['pluginOptions' => [
			'size' => 'sm',
			'stars'=> 5,
			'min'  => 0,
			'max'  => 5,
			'step' => 0.5,
			'starCaptions' => []
		]]);
	?>

	<div class="form-group">
		<?= Html::submitButton('Rate It!', ['class' => 'btn btn-success']) ?>
	</div>
	<?php ActiveForm::end(); ?>
</div>