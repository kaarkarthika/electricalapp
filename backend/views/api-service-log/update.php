<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Update Api Service Log';
$this->params['breadcrumbs'][] = ['label' => 'Update Api Service Log', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Api Service Log';
?>
  <div class="api-service-log-update">
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