<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
	<?= $form->field($model, 'name')->label('账号') ?>
	<?= $form->field($model, 'email')->label('邮箱') ?>
	<div class="form-group">
		<?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
	</div>
<?php ActiveForm::end(); ?>