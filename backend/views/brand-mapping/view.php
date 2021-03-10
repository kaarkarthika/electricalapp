<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\BrandMapping */

// $this->title = $model->autoid;
// $this->params['breadcrumbs'][] = ['label' => 'Brand Mappings', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="brand-mapping-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'autoid',
            'service_id',
            'brands',
            'description',
            //'created_at',
            //'updated_at',
        ],
    ]) ?>

</div>
