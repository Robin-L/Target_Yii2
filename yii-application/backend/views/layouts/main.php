<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use common\models\PermissionHelpers;
use backend\assets\FontAwesomeAsset;

AppAsset::register($this);
FontAwesomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php

    if(!Yii::$app->user->isGuest) {
        $is_admin = PermissionHelpers::requireMinimumRole('Admin');
        NavBar::begin([
            'brandLabel' => 'Target Yii2 Admin',
            'brandUrl'   => Yii::$app->homeUrl,
            'options'    => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
    } else {
        NavBar::begin([
            'brandLabel' => 'Target Yii2',
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
    }

    if (Yii::$app->user->isGuest) {
        $menuItemsLogOut[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItemsLogOut[] = '<li>'
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
        'items' => $menuItemsLogOut,
    ]);

    if (!Yii::$app->user->isGuest && $is_admin) {
        echo Nav::widget(
            [
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Users', 'items' => [
                        ['label' => 'Users', 'url' => ['user/index']] ,
                        ['label' => 'Profile', 'url' => ['profile/index']] ,
                        ['label' => 'Something else here', 'url' => ['#']] ,
                    ]],
                    ['label' => 'Support', 'items' => [
                        ['label' => 'Support Request', 'url' => ['content/index']],
                        ['label' => 'Status Message', 'url' => ['status-message/index']],
                        ['label' => 'FAQ', 'url' => ['faq/index']],
                        ['label' => 'FAQ Categories', 'url' => ['faq-category/index']],
                    ]],
                    ['label' => 'RBAC', 'items' => [
                        ['label' => 'Roles', 'url' => ['role/index']],
                        ['label' => 'User Types', 'url' => ['user-type/index']],
                        ['label' => 'Statuses', 'url' => ['status/index']],
                    ]],
                    ['label' => 'Content', 'items' => [
                        ['label' => 'Content', 'url' => ['content/index']],
                        ['label' => 'Status Message', 'url' => ['status-message/index']],
                    ]],
                ],
            ]);
    }

    $menuItems = [['label' => 'Home', 'url' => ['site/index']],];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
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
        <p class="pull-left">&copy; Target Yii2 <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
