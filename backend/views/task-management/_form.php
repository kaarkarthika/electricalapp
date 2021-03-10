<?php
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   use yii\widgets\Breadcrumbs;
   use yii\helpers\Url;
   $session = Yii::$app->session;
   /* @var $this yii\web\View */
   /* @var $model backend\models\CategoryManagement */
   /* @var $form yii\widgets\ActiveForm */
session_start();
if(isset($_SESSION['color_code'])){
$color_code=$_SESSION['color_code'];
}
else
{
$color_code="#ed1c24";
}
?>
<style>
  .btn-success{
    background-color:<?php echo $color_code;?>;
   color: #fff;
   border-color: <?php echo $color_code;?>;
  }
  .clssdyna{
    background-color:<?php echo $color_code;?>;
   color: #fff;
   border-color: <?php echo $color_code;?>;
  }
  .btn-success:hover, .btn-success:active, .btn-success.hover {
    background-color:<?php echo $color_code;?>;
  }
  .btn-success:hover {   
    border-color:<?php echo $color_code;?>;
  }

   .score {
   background-color: #0c9cce;
   color: #fff;
   font-weight: 600;
   border-radius: 50%;
   width: 40px;
   height: 40px;
   line-height: 40px;
   text-align: center;
   margin: auto;
   /* padding: 21% 14%;*/
   }
   .checkbox input[type="checkbox"] {
   cursor: pointer;
   opacity: 0;
   z-index: 1;
   outline: none !important;
   }
   .upper {
   text-transform: uppercase;
   }
   .checkbox-custom input[type="checkbox"]:checked + label::before {
   background-color: #5fbeaa;
   border-color: #5fbeaa;
   }
   .checkbox label::before {
   -o-transition: 0.3s ease-in-out;
   -webkit-transition: 0.3s ease-in-out;
   background-color: #ffffff;
   /* border-radius: 3px; */
   border: 1px solid #cccccc;
   content: "";
   display: inline-block;
   height: 17px;
   left: 0!important;
   margin-left: -20px!important;
   position: absolute;
   transition: 0.3s ease-in-out;
   width: 17px;
   outline: none !important;
   }
   .checkbox input[type="checkbox"]:checked + label::after {
   content: "\f00c";
   font-family: 'FontAwesome';
   color: #fff;
   position: relative;
   right: 59px;
   bottom: 1px;
   }
   .checkbox label {
   display: inline-block;
   padding-left: 5px;
   position: relative;
   }
</style>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>


<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
               <div class="row">
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Name</h3> -->
                     <label class="control-label">Service Type</label>
                     <?php if($model->isNewRecord){ ?>
               <?php 
                  echo $form->field($model, 'task_name')->dropDownList($servicetype,['prompt'=>'--Select Service--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label(false);?>
               <?php }else{ ?>
               <?php 
                  echo $form->field($model, 'task_name')->dropDownList($servicetype,['prompt'=>'--Select Service--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label(false);?>
               <?php } ?>
                  </div>
                  
                   
                   <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">User Name</h3> -->
                   <label class="control-label">Customer Name</label>

                       <?php if($model->isNewRecord){ ?>
               <?php 
                  echo $form->field($model, 'customer_id')->dropDownList($customermaster,['prompt'=>'--Select Customer--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label(false);?>
               <?php }else{ ?>
               <?php 
                  echo $form->field($model, 'customer_id')->dropDownList($customermaster,['prompt'=>'--Select Customer--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label(false);?>
               <?php } ?>
                  </div>

                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">User Name</h3> -->
                   <label class="control-label">Executive Name</label>
                    
                           <?php if($model->isNewRecord){ ?>
               <?php 
                  echo $form->field($model, 'excutive_id')->dropDownList($executivemaster,['prompt'=>'--Select Executive--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label(false);?>
               <?php }else{ ?>
               <?php 
                  echo $form->field($model, 'excutive_id')->dropDownList($executivemaster,['prompt'=>'--Select Executive--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label(false);?>
               <?php } ?>

                  </div>
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Location</h3> -->
                     <label class="control-label">Description</label>
                     <?= $form->field($model, 'description')->textarea(['rows' => 6,'class'=>'form-control upper','placeholder'=>'Description'])->label(false) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">User Name</h3> -->
                   <label class="control-label">Appointment Date</label>
                    <?php if($model->isNewRecord){ ?>

                   
                  <?= $form->field($model, 'service_date')->textInput(['maxlength' => true,'id'=>'form_datetime'])->label(false)  ?>
                <?php }
                else{
                  ?>
                  <?= $form->field($model, 'service_date')->textInput(['maxlength' => true,'id'=>'form_datetime2'])->label(false)  ?>
             <?php   }
                ?>
                  </div>
                  

                  <!-- <div class='col-sm-6 form-group'>
                <label class="control-label">Status</label>
                     <?= $form->field($model, 'excutive_id')->textInput(['maxlength' => true])->label(false)  ?>
                  </div> -->
                </div>
            </div>
            <br>
            <br>
            <div class="panel-footer text-right">
               <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success clssdyna' : 'btn btn-primary','required'=>true]) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <nav></nav>
         </div>
      </div>
   </div>
</div>
</div>
<script>
  $(function() {
    $('#form_datetime').datetimepicker({
       format:'DD-MM-YYYY HH:mm:ss',
      minDate:new Date()
    });
  });
</script>
<script>
  $(function() {
    $('#form_datetime2').datetimepicker({
       format:'YYYY-MM-DD HH:mm:ss',
      
    });
  });
</script>