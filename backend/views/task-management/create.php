<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CategoryManagement */

$this->title = 'Create Task Management';
$this->params['breadcrumbs'][] = ['label' => 'Task Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
 
<div class=" ">
<div class="category-management-create  ">
  <div class="box-body no-pad">
     <div class="box box-primary  ">
    	<div class="box-header with-border box-header-bg">
         <h3 class="box-title pull-left"> <i class="fa fa-fw fa-plus-square"></i> <?= Html::encode($this->title) ?></h3>
        </div>
     </div>

   
   <?= $this->render('_form', [
        'model' => $model,
         'customermaster'=>$customermaster,
         'executivemaster'=>$executivemaster,
         'servicetype'=>$servicetype,
    ]) ?>
  </div>
</div>
</div>
