<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\MarketingImageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Marketing Images';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="marketing-image-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
        echo Collapse::widget([
                'encodeLabels' => false,
                'items' => [
                    [
                        'label' => '<i class="fa fa-caret-square-o-down"></i> Search',
                        'content' => $this->render('_search', ['model' => $searchModel]),
                    ]
                ]
            ]);
    ?>

    <p>
        <?= Html::a('Create Marketing Image', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'marketing_image_path',
            'marketing_image_name',
            'marketing_image_caption_title',
            'marketing_image_caption',
            ['attribute' => 'marketing_image_is_featured', 'format' => 'boolean'],
            ['attribute' => 'marketing_image_is_active', 'format' => 'boolean'],
            'marketing_image_weight',
            'statusName',
            'thumb:html',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
