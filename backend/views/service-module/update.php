<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Update Service Module';
$this->params['breadcrumbs'][] = ['label' => 'Update Service Module', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Service Module';
?>
  <div class="service-module-update">
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