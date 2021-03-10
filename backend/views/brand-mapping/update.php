<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Update Brand';
$this->params['breadcrumbs'][] = ['label' => 'Update Brand', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update Brand';
?>
  <div class="brand-mapping-update">
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