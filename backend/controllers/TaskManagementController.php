<?php

namespace backend\controllers;

use Yii;
use backend\models\TaskManagement;
use backend\models\TaskManagementSearch;
use backend\models\CustomerMaster;
use backend\models\ExecutiveMaster;
use backend\models\CategoryManagement;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskManagementController implements the CRUD actions for TaskManagement model.
 */
class TaskManagementController extends Controller
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
     * Lists all TaskManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TaskManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TaskManagement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TaskManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TaskManagement();
         $customermaster=ArrayHelper::map(CustomerMaster::find()->where(['active_status'=>1])->asArray()->all(), 'user_id', 'customer_name');
         $servicetype=ArrayHelper::map(CategoryManagement::find()->where(['active_status'=>1])->asArray()->all(), 'auto_id', 'category_name');
         $executivemaster=ArrayHelper::map(ExecutiveMaster::find()->where(['active_status'=>1])->asArray()->all(), 'id', 'name');
         if ($model->load(Yii::$app->request->post())) {
            // echo "<pre>";
            //print_r(Yii::$app->request->post());die;
            $date=$_POST['TaskManagement']['service_date'];
            $model->service_date=date('Y-m-d H:m:s',strtotime($date));
                $model->reason="Asigned";
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Task Created successfully.');
               return $this->redirect(['index']); } 
            else {
               
               Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
           return $this->render('create', [
           'model' => $model,
            ]);
                }
          
        } else {
            return $this->render('create', [
                'model' => $model,
                'customermaster'=>$customermaster,
                'executivemaster'=>$executivemaster,
                'servicetype'=>$servicetype,
            ]);
        }
    }

    /**
     * Updates an existing TaskManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
$customermaster=ArrayHelper::map(CustomerMaster::find()->where(['active_status'=>1])->asArray()->all(), 'user_id', 'customer_name');
$servicetype=ArrayHelper::map(CategoryManagement::find()->where(['active_status'=>1])->asArray()->all(), 'auto_id', 'category_name');
$executivemaster=ArrayHelper::map(ExecutiveMaster::find()->where(['active_status'=>1])->asArray()->all(), 'id', 'name');
        if ($model->load(Yii::$app->request->post())) {
            $date=$_POST['TaskManagement']['service_date'];
            //print_r($date);die;
            $model->service_date=date('Y-m-d H:m:s',strtotime($date));
             $model->reason="Asigned";
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Task Updated successfully.');
               return $this->redirect(['index']); } 
            else {
               
               Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
           return $this->render('create', [
           'model' => $model,
            'customermaster'=>$customermaster,
            ]);
                }
          
        } else {
            return $this->render('update', [
                'model' => $model,
                'customermaster'=>$customermaster,
                'executivemaster'=>$executivemaster,
                'servicetype'=>$servicetype,
            ]);
        }
    }

    /**
     * Deletes an existing TaskManagement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    //print_r($id);die;
    $command = Yii::$app->db->createCommand("UPDATE task_management SET reason='Completed' WHERE task_id=".$id);
    $command->execute();
    Yii::$app->getSession()->setFlash('success', 'Your task completd successfully.');
    return $this->redirect(['index']);
    }
    public function actionDeletein($id)
    {
    $command = Yii::$app->db->createCommand("UPDATE task_management SET reason='Started' WHERE task_id=".$id);
    $command->execute();
    Yii::$app->getSession()->setFlash('success', 'Your task completd successfully.');
    return $this->redirect(['index']);
    }

    /**
     * Finds the TaskManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TaskManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TaskManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
