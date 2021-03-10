<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\DropdownManagement */

$this->title = 'Create Dropdown Management';
$this->params['breadcrumbs'][] = ['label' => 'Dropdown Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dropdown-management-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
