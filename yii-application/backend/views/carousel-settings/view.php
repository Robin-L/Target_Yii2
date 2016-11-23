<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CarouselSettings */

$this->title = $model->carousel_name;
$this->params['breadcrumbs'][] = ['label' => 'Carousel Settings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title . ' Carousel';
?>
<div class="carousel-settings-view">

    <h1><?= Html::encode($model->carousel_name) ?> Carousel</h1>

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'carousel_name',
            'image_height',
            'image_width',
            ['attribute' => 'carousel_autoplay', 'format' => 'boolean'],
            ['attribute' => 'show_indicators', 'format' => 'boolean'],
            ['attribute' => 'show_caption_title', 'format' => 'boolean'],
            ['attribute' => 'show_captions', 'format' => 'boolean'],
            ['attribute' => 'show_caption_background', 'format' => 'boolean'],
            ['attribute' => 'show_controls', 'format' => 'boolean'],
            'caption_font_size',
            'status.status_name',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
