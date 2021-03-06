<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
// use frontend\assets\FontAwesomeAsset;
use backend\models\search\CarouselSettingsSearch;

AppAsset::register($this);
// FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php  
        $carouselSettings = CarouselSettingsSearch::getCarouselSettings('Front Page');
        if ($carouselSettings['caption_font_size']) {
            echo '<style>.carousel-caption{';

            if ($carouselSettings['show_caption_background']) {
                echo 'background:rgba(0, 0, 0, 0.5);';
            }

            echo 'font-size:'.$carouselSettings['caption_font_size'] . ';}</style>';
        }
    ?>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Target Yii2',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        // ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/pages/about']],
        ['label' => 'FAQs', 'url' => ['/faq/index']],
        ['label' => 'Contact', 'url' => ['/pages/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
        $menuItems[] = ['label'=> 'Social Sync', 
                        'items' => [
                            [
                                'label' => '<i class="fa fa-facebook"></i> Fackbook',
                                'url' => ['site/auth', 'authclient' => 'facebook']
                            ],
                            [
                                'label' => '<i class="fa fa-github"></i> Github',
                                'url' => ['site/auth', 'authclient' => 'github']
                            ],
                        ]];
    } else {
        $menuItems[] = ['label' => 'Profile', 'url' => ['/profile/view']];
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false, // "<i>"标签不特殊处理
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
