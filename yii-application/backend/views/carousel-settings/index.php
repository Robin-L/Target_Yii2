<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CarouselSettingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carousel Settings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-settings-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Carousel Settings', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'carousel_name',
            'image_height',
            'image_width',
            ['attribute' => 'carousel_autoplay', 'format' => 'boolean'],
            ['attribute' => 'show_indicators', 'format' => 'boolean'],
            ['attribute' => 'show_caption_title', 'format' => 'boolean'],
            ['attribute' => 'show_captions', 'format' => 'boolean'],
            ['attribute' => 'show_caption_background', 'format' => 'boolean'],
            'caption_font_size',
            ['attribute' => 'show_controls', 'format' => 'boolean'],
            // 'show_indicators',
            // 'show_caption_title',
            // 'show_captions',
            // 'show_caption_background',
            // 'caption_font_size',
            // 'show_controls',
            // 'status_id',
            // 'created_at',
            'statusName',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
