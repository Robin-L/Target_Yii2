<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MarketingImage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="marketing-image-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'marketing_image_name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'marketing_image_caption_title') ?>

    <?= $form->field($model, 'marketing_image_caption')->textInput() ?>

    <?= $form->field($model, 'marketing_image_is_featured')->dropDownList($model->marketingImageIsFeaturedList, ['prompt' => 'Please Choose One']) ?>

    <?= $form->field($model, 'marketing_image_is_active')->dropDownList($model->marketingImageIsActiveList, ['prompt' => 'Please Choose One']) ?>

    <?= $form->field($model, 'marketing_image_weight')->textInput() ?>

    <?= $form->field($model, 'status_id')->dropDownList($model->statusList) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
