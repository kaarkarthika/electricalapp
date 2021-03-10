<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TechnicianMaster */

// $this->title = $model->auto_id;
// $this->params['breadcrumbs'][] = ['label' => 'Technician Masters', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="technician-master-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'auto_id',
            'technician_name',
        //    'emp_id',
         //   'address',
         //   'phone_no',
            'email_id:email',
         //   'technician_image',
            'active_status',
            //'created_at',
           // 'updated_at',
        ],
    ]) ?>

</div>
