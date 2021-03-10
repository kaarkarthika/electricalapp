<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\ServiceModule */

// $this->title = $model->auto_id;
// $this->params['breadcrumbs'][] = ['label' => 'Service Modules', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-module-view">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'auto_id',
            'service_id',
            'service_type',
            'description',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
