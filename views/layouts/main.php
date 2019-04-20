<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\models\Usuarios;

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Libraryii',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);

    if (Yii::$app->user->isGuest) {
        $menu = [
            [
                'label' => 'Autores',
                'url' => ['/autores/index'],
                'encode' => false
            ],
            [
                'label' => 'Libros',
                 'url' => ['/libros/index'],
                 'encode' => false
            ],
            ['label' => 'Registrarse', 'url' => ['/usuarios/create']],
            ['label' => 'Login', 'url' => ['/site/login']]
        ];
    } else {
        $usuario = Usuarios::findOne(['id' => Yii::$app->user->id]);
        $menu = [
            [
                'label' => 'Usuarios',
                'url' => ['/usuarios/index'],
                'encode' => false
            ],
            [
                'label' => 'Social',
                'url' => ['/estados/index'],
                'encode' => false
            ],
            [
                'label' => 'Autores',
                'url' => ['/autores/index'],
                'encode' => false
            ],
            [
                'label' => 'Libros',
                 'url' => ['/libros/index'],
                 'encode' => false
            ],
            [
                'label' => 'Mi Perfil',
                 'url' => ['/usuarios/view', 'id' => $usuario->id],
                 'encode' => false,
            ],
            [
                'label' => "Logout ($usuario->login)",
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'POST'],
                'encode' => false,
            ],
        ];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menu,
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
