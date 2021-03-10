<?php

namespace backend\controllers;

use Yii;
use backend\models\StatusModule;
use backend\models\StatusModuleSearch;
use backend\models\TechnicianMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * StatusModuleController implements the CRUD actions for StatusModule model.
 */
class StatusModuleController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StatusModule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StatusModuleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StatusModule model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StatusModule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StatusModule();
       if($model->load(Yii::$app->request->post())) {
         $product_id =$model->product_id;
         $brand_id =$model->brand_id;
         $service_type =$model->service_type;
         $date =$model->date;
         $time =$model->time;
         $address =$model->address;
         $remarks =$model->remarks;
         $model->status="Pending";
         $model->save();
        return $this->redirect(['index']); 
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Updates an existing StatusModule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
     public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
         $product_id =$model->product_id;
         $brand_id =$model->brand_id;
         $service_type =$model->service_type;
         $date =$model->date;
         $time =$model->time;
         $address =$model->address;
         $remarks =$model->remarks;
         $status =$model->status;
         $model->save();
         return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StatusModule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StatusModule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StatusModule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StatusModule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

 public function actionApprove($id)
   {
        
        StatusModule::updateAll(['status'=>'Approved'],['auto_id'=>$id]);
        return $this->redirect(['index']);
   }

    public function actionTechnicianList($id)
    {
        return $this->renderAjax('view-technician', [
            'model' => $this->findModel($id),
        ]);
    }
   public function actionTechnicianListAssign($id)
   {
        $technician_id = $_POST['StatusModule']['technician_id'];
         StatusModule::updateAll(['status'=>'Assigned','technician_id'=>$technician_id],['auto_id'=>$id]);
        return $this->redirect(['index']);
   }

   public function actionCancelStatus($id)
   {
        $cancel_remarks = $_POST['StatusModule']['cancel_remarks'];
        StatusModule::updateAll(['status'=>'Cancelled','cancel_remarks'=>$cancel_remarks],['auto_id'=>$id]);
        return $this->redirect(['index']);
   }

   public function actionRescheduleStatus($id)
   {
        $re_date = $_POST['StatusModule']['re_date'];
        $re_time = $_POST['StatusModule']['re_time'];
         StatusModule::updateAll(['status'=>'Reschedule','re_date'=>$re_date,'re_time'=>$re_time],['auto_id'=>$id]);
        return $this->redirect(['index']);
   }

    public function actionReschedule($id)
    {
        return $this->renderAjax('view-reschedule', [
            'model' => $this->findModel($id),
        ]);
    }

     public function actionCancel($id)
    {
        return $this->renderAjax('view-cancel', [
            'model' => $this->findModel($id),
        ]);
    }

}
