<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\StatusModule */

// $this->title = $model->auto_id;
// $this->params['breadcrumbs'][] = ['label' => 'Status Modules', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-module-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'auto_id',
            'product_id',
            'brand_id',
            'service_type',
            //'date_time',
            // 'address',
            // 'remarks',
             'status',
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
