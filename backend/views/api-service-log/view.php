<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BrandMapping */

// $this->title = $model->autoid;
// $this->params['breadcrumbs'][] = ['label' => 'Brand Mappings', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-service-log-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'autoid',
            'request_data:ntext',
            'event_key',
            'response_data:ntext',
            'status',
            'created_at',
            'modified_at',
        ],
    ]) ?>

</div>
