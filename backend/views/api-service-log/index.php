<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoryManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Api Service Logs';
$this->params['breadcrumbs'][] = $this->title;
  session_start();
   if(isset($_SESSION['color_code'])){

   $color_code=$_SESSION['color_code'];
 }else{
  $color_code="#ed1c24";
 }
?>
<style type="text/css">
  .text-wrap{max-width:"100px";, height:"100px"}
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
<div class="api-service-index">

    <div class="box box-primary" style="overflow: auto;">
      <div class=" ">
   
        <div class=" box-header with-border box-header-bg">


   <h3 class="box-title pull-left " ><?= Html::encode($this->title) ?></h3>
   <?= Html::a('Add Api Service Logs', ['create'], ['class' => 'btn btn-success pull-right']) ?>
    </div>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            
           // 'autoid',
            //'request_data:ntext',
            [
            'attribute' => 'request_data',
            'headerOptions' =>['style'=>'color:#ff0000;'],
            'format' => 'html',
            'value' => function($model, $key, $index)
            {
                if($model->request_data!='')
                {
                    return  "<pre style='white-space:normal;width:200px;height:200px;'> ".$model->request_data ."</pre>";
                }else{
                  return '-';
                }

            },
            ],
            'event_key',
            [
            'attribute' => 'response_data',
            'headerOptions' =>['style'=>'color:#ff0000;'],
            'format' => 'html',
            'value' => function($model, $key, $index)
            {
                if($model->response_data!='')
                {
                    return  "<pre style='white-space:normal;width:200px;height:200px;'> ".$model->response_data ."</pre>";
                }else{
                  return '-';
                }

            },
            ],
            //'status',
             'created_at',
            // 'modified_at',

          
         /* ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{view}{update}{delete}',
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
                          ] ],*/
        ],
    ]); ?>
<?php Pjax::end(); ?></div></div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader_large').html('<span> <i class="fa fa-fw fa-th-large"></i>View Api</span>');
             $('#operationalmodal_large').modal('show').find('#modalContenttwo_large').load(url);
             return false;
         });
</script>
