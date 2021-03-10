<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\DropdownManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dropdown Managements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dropdown-management-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Dropdown Management', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'value',
            'key',
            'is_active',
            'created_at',
            // 'updated_at',
            // 'ip_address',
            // 'system_name',
            // 'user_id',
            // 'user_role',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
