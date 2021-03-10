<?php
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   use yii\widgets\Breadcrumbs;
   use yii\helpers\Url;
   use backend\models\CategoryManagement;
   use backend\models\BrandMapping;
   use backend\models\ServiceModule;
   use yii\helpers\ArrayHelper;

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
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
               <div class="row">
                  <div class='col-sm-6 form-group' >
                    <?php 
                     $product_type =  ArrayHelper::map(CategoryManagement::find()->where(['active_status'=>"1"])->all(),'auto_id','category_name');
                     ?>
                     <?= $form->field($model, 'product_id')->dropDownList($product_type,['prompt'=>'--Select Product--','maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                    <?php 
                     $brand_type =  ArrayHelper::map(BrandMapping::find()->all(),'autoid','brands');
                     ?>
                   <?= $form->field($model, 'brand_id')->dropDownList($brand_type,['prompt'=>'--Select Brand--','maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                    <?php 
                     $service_type =  ArrayHelper::map(ServiceModule::find()->all(),'auto_id','service_type');
                     ?>
                     <?= $form->field($model, 'service_type')->dropDownList($service_type,['prompt'=>'--Select Service--','maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <?= $form->field($model, 'date')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <?= $form->field($model, 'address')->textarea(['rows' => 6,'maxlength' => true]) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <?= $form->field($model, 'remarks')->textarea(['rows' => 6,'maxlength' => true]) ?>
                  </div>
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
<script type="text/javascript">
    $(function () {
          $('#datetimepicker1').datetimepicker();
      });
</script>