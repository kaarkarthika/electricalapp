<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Service Api List';
$this->params['breadcrumbs'][] = ['label' => 'Service Api List', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Service Api List';
?>
  <div class="status-module-update">
     <div class="box box-primary">
	    <div class=" ">
    	  <div class=" box-header with-border box-header-bg">
             <h3 class="box-title "><?= Html::encode($this->title) ?></h3>
          </div>
	    </div>
	</div>
	
    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

  </div>