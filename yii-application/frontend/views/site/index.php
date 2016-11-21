<?php

use \yii\bootstrap\Modal;
use \yii\bootstrap\Collapse;
use \yii\bootstrap\Alert;
use yii\helpers\Html;
use components\FaqWidget;

$this->title = 'Target Yii2';
?>
<div class="site-index">

    <div class="jumbotron">

        <?php if(Yii::$app->user->isGuest) {
            echo Html::a('Get Started Today', ['site/signup'], ['class' => 'btn btn-lg btn-success']);
            } ?>
        <p>
            <h1>Target Yii2 <i class="fa fa-plug"></i></h1>
            <p class="lead">Use this Yii 2 Template to start Project.</p>
        </p>
    </div>

    <?php 
        echo Collapse::widget([
            'items' => [
                [
                    'label'     => 'Top Features',
                    'content'   => ['123', '456']
                ],
                [
                    'label' => 'Top Resources',
                    'content'   => 'FacebookPlugin'
                ],
            ]
        ]);

        Modal::begin([
            'header' => '<h2>Lastest Comments</h2>',
            'toggleButton'  => ['label' => 'comments'],
        ]);
        Modal::end();
    ?>
    <?php 
        echo Alert::widget(['options' => ['class' => 'alert-info'], 'body' => 'Launch your project like a rocket...',]);
    ?>
    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
                <h2>Free</h2>
                <p>
                    <?php 
                        if (!Yii::$app->user->isGuest) {
                            echo Yii::$app->user->identity->username . ' is doing cool stuff. ';
                        }
                    ?>
                </p>
                <p>
                    <a href="http://www.yiiframework.com/doc-2.0/guide-index.html" title="Yii Documentation" class="btn btn-default">Yii Documentation</a>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Advantage</h2>
                <p>
                    Ease of use is a huge advantage.
                </p>
                <p>
                    <a href="http://www.yiiframework.com/forum/" class="btn btn-default">Yii Forum</a>
                </p>
            </div>
            <div class="col-lg-4">
                <h2>Code Quick, Code Right!</h2>
                <p>
                    leverage the power of the awesome Yii 2 framework with this enhanced template.
                </p>
                <p>
                    <a href="http://www.yiiframework.com/extensions/" class="btn btn-default">Yii Extensions</a>
                </p>
            </div>
        </div>
        
    </div>
    <?= FaqWidget::widget(['settings' => ['pageSize' => 3, 'featuredOnly' => true]]) ?>
</div>
