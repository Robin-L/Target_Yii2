<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CarouselSettings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carousel-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'carousel_name')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'image_height')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'image_width')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'carousel_autoplay')->dropDownList($model->carouselAutoplayList, ['prompt' => 'Please Choose One']) ?>

    <?= $form->field($model, 'show_indicators')->dropDownList($model->showIndicatorsList, ['prompt' => 'Please Choose One']) ?>

    <?= $form->field($model, 'show_caption_title')->->dropDownList($model->showCaptionTitleList, ['prompt' => 'Please Choose One']) ?>

    <?= $form->field($model, 'show_captions')->->dropDownList($model->showCaptionList, ['prompt' => 'Please Choose One']) ?>

    <?= $form->field($model, 'show_caption_background')->->dropDownList($model->showCaptionBackgroundList, ['prompt' => 'Please Choose One']) ?>

    <?= $form->field($model, 'caption_font_size')->textInput(['maxlength' => 45]) ?>

    <?= $form->field($model, 'show_controls')->->dropDownList($model->showControlsList, ['prompt' => 'Please Choose One']) ?>

    <?= $form->field($model, 'status_id')->->dropDownList($model->statusList) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
