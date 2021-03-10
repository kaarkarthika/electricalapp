<?php
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   use yii\widgets\Breadcrumbs;
   use yii\helpers\Url;
   use backend\models\TechnicianMaster;
   use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\StatusModule */

?>
<link type="text/css" href="css/bootstrap.min.css" />
<link type="text/css" href="css/bootstrap-timepicker.min.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-timepicker.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
<link href='bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css' rel='stylesheet' type='text/css'>
<script src='bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
<div class="status-module-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin(['action' => Url::to(['status-module/reschedule-status','id' => $model->auto_id]),'options' => ['method' => 'post']]) ?>
        <div class="row">
                   <div class='col-sm-6 form-group' >
                   <?= $form->field($model, 're_date')->textInput(['maxlength' => true,'required'=>true,'id'=>'datepicker','autocomplete'=>'off']) ?>
                  </div>
                 <div class=" col-sm-6 form-group input-group bootstrap-timepicker timepicker" style="width: 47%;">
                   <?= $form->field($model, 're_time')->textInput(['maxlength' => true,'id'=>'timepicker1','class'=>'form-control input-small','required'=>true,'autocomplete'=>'off']) ?>
                 </div>
               </div>
                 <div class="panel-footer text-right">
             <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success clssdyna' : 'btn btn-primary','required'=>true]) ?>
            </div>
                 <?php ActiveForm::end(); ?>
</div>
<script type="text/javascript">
    $('#timepicker1').timepicker();
    $(document).ready(function(){
    $('#datepicker').datepicker(); 
    });
</script>