<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use backend\models\TechnicanMaster;

$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Service Api List';
$this->params['breadcrumbs'][] = $this->title;
  session_start();
   if(isset($_SESSION['color_code'])){

   $color_code=$_SESSION['color_code'];
 }else{
  $color_code="#ed1c24";
 }
?>
<style type="text/css">
   .btn-success{
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
</style>
<div class="status-module-index">
    <div class="box box-primary  ">
      <div class=" ">
        <div class=" box-header with-border box-header-bg">
<h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   <?//= Html::a('Add Status Module', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
    </div>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
            //'auto_id',
           'product_name',
            'brand_name',
            'service_name',
            //'date_time',
            // 'address',
            // 'remarks',
             //'status',
              ['attribute'=>'status',
              'filter'=>array('Pending'=>'Pending','Approved'=>'Approved','Assigned'=>'Assigned','Reschedule'=>'Reschedule','Cancelled'=>'Cancelled'),
             ],
            // 'created_at',
            // 'updated_at',
          ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{approve}{technician-list}{reschedule}{cancel}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                                   return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                                }, 
                             'update' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn btn-warning btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Update'),
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    },
                              
                                'delete' => function ($url, $model, $key) {
                                   return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete' ]);
                                  },
                                 'approve' => function ($url, $model, $key) {

                                  if($model->status=="Approved" || $model->status=="Cancelled" || $model->status=="Assigned"||$model->status=="Reschedule"){
                                    $disable =true;
                                    return Html::button('<i class="fa fa-check-circle"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-info btn-xs approve gridbtncustom modalDelete2', 'data-toggle'=>'tooltip', 'title' =>'Approved','disabled' => $disable ]);
                                  }else{
                                     return Html::button('<i class="fa fa-check-circle"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-info btn-xs approve gridbtncustom modalDelete2', 'data-toggle'=>'tooltip', 'title' =>'Approved']);
                                  }
                                }, 
                                'technician-list' => function ($url, $model, $key) {
                                  if($model->status=="Assigned" || $model->status=="Cancelled"||$model->status=="Reschedule"|| $model->status=="pending"){
                                    $disable =true;
                                    return Html::button('<i class="fa fa-user"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView1', 'data-toggle'=>'tooltip', 'title' =>'Assign Technician','disabled' => $disable ]);
                                  }else{
                                     return Html::button('<i class="fa fa-user"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView1', 'data-toggle'=>'tooltip', 'title' =>'Assign Technician']);
                                  }
                                }, 
                                'reschedule' => function ($url, $model, $key) {

                                  if($model->status=="Reschedule" || $model->status=="Cancelled" || $model->status=="pending"|| $model->status=="Approved"){
                                    $disable =true;
                                    return Html::button('<i class="fa fa-calendar"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-warning btn-xs approve gridbtncustom modalView2', 'data-toggle'=>'tooltip', 'title' =>'Reschedule','disabled' => $disable ]);
                                  }else{
                                     return Html::button('<i class="fa fa-calendar"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-warning btn-xs approve gridbtncustom modalView2', 'data-toggle'=>'tooltip', 'title' =>'Reschedule']);
                                  }
                                },

                                'cancel' => function ($url, $model, $key) {

                                  if($model->status=="Cancelled"){
                                    $disable =true;
                                    return Html::button('<i class="fa fa-close"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs approve gridbtncustom modalView3', 'data-toggle'=>'tooltip', 'title' =>'Cancel','disabled' => $disable ]);
                                  }else{
                                     return Html::button('<i class="fa fa-close"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs approve gridbtncustom modalView3', 'data-toggle'=>'tooltip', 'title' =>'Cancel']);
                                  }
                                }, 
                               
                          ] ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div>
<script type="text/javascript">
     $('body').on("click",".modalView",function(){
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Service Api List</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
      $('body').on("click",".modalView1",function(){
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View technician</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
      $('body').on("click",".modalView2",function(){
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Reschdule</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
      $('body').on("click",".modalView3",function(){
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>View Cancel</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
</script>

