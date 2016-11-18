<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\FaqCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Faq Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="faq-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php 
        echo Collapse::widget([
            'items' => [
                [
                    'label' => 'Search',
                    'content' => $this->render('_search', ['model' => $searchModel]),
                ]
            ],
        ]);
    ?>

    <p>
        <?= Html::a('Create Faq Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'faq_category_name',
            'faq_category_weight',
            ['attribute' => 'faq_category_is_featured', 'format' => 'boolean'],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
