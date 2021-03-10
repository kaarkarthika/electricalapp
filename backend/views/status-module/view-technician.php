<?php
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   use yii\widgets\Breadcrumbs;
   use yii\helpers\Url;
   use backend\models\TechnicianMaster;
   use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\StatusModule */

// $this->title = $model->auto_id;
// $this->params['breadcrumbs'][] = ['label' => 'Status Modules', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-module-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['action' => Url::to(['status-module/technician-list-assign','id' => $model->auto_id]),'options' => ['method' => 'post']]) ?>
        <div class="row">
                  <div class='col-sm-6 form-group' >
                    <?php 
                     $technician_list =  ArrayHelper::map(TechnicianMaster::find()->where(['active_status'=>"1"])->all(),'auto_id','technician_name');
                     ?>
                     <?= $form->field($model, 'technician_id')->dropDownList($technician_list,['prompt'=>'--Select Product--','maxlength' => true,'required'=>true]) ?>
                  </div>
                </div>
                 <div class="panel-footer text-right">
             <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success clssdyna' : 'btn btn-primary','required'=>true]) ?>
            </div>
                 <?php ActiveForm::end(); ?>
</div>
