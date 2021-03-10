<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TaskManagement */

$this->title = $model->task_id;
$this->params['breadcrumbs'][] = ['label' => 'Task Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-management-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->task_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->task_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'task_id',
            'task_name',
            'customer_id',
            'excutive_id',
            'service_date',
            'description:ntext',
            'reason:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
