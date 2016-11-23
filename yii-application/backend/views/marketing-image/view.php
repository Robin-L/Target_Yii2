<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MarketingImage */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Marketing Images', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marketing-image-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    <h1><?= Html::encode($model->marketing_image_name) ?></h1><br>

    <div>
        <?php  
            echo Html::img('/' . $model->marketing_image_path . '?' . 'time=' . time(), ['width' => '600px']);
        ?>
    </div>
    <br>
    <div>
        <?php  
            echo Html::img('/' . $model->marketing_thumb_path . '?' . 'time=' . time());
        ?>
    </div>
    <br>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'marketing_image_caption_title',
            'marketing_image_caption',
            'marketing_image_path',
            'marketing_thumb_path',
            'marketing_image_weight',
            ['attribute' => 'marketing_image_is_featured', 'format' => 'boolean'],
            ['attribute' => 'marketing_image_is_active', 'format' => 'boolean'],
            'status.status_name',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
