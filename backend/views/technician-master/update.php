<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Update Technician';
$this->params['breadcrumbs'][] = ['label' => 'Update Technician', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
  <div class="technician-master-update">
     <div class="box box-primary">
	    <div class=" ">
    	  <div class=" box-header with-border box-header-bg">
             <h3 class="box-title "><?= Html::encode($this->title) ?></h3>
          </div>
	    </div>
	</div>
	
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

  </div>