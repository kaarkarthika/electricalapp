<?php

namespace backend\controllers;

use Yii;
use backend\models\ExecutiveMaster;
use backend\models\ExecutiveMasterSearch;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use backend\models\CategoryManagement;
use backend\models\ExecutiveMasterServicetype;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\ErrorException;
/**
 * ExecutiveMasterController implements the CRUD actions for ExecutiveMaster model.
 */
class ExecutiveMasterController extends Controller
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
     * Lists all ExecutiveMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExecutiveMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ExecutiveMaster model.
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
     * Creates a new ExecutiveMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ExecutiveMaster();
        $servicetype=ArrayHelper::map(CategoryManagement::find()->where(['active_status'=>1])->asArray()->all(), 'auto_id', 'category_name');
        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($model);
           }
            $model->auth_key=Yii::$app->security->generateRandomString(); 
            $model->password= Yii::$app->security->generatePasswordHash($_POST['ExecutiveMaster']['password']);
            $model->designation=$_POST['ExecutiveMaster']['designation'];
       
        if ($model->save()) {
         if(isset($_POST['ExecutiveMaster']['service_type'])){
         $vall = $_POST['ExecutiveMaster']['service_type'];
         if(!empty($vall)){
         foreach ($vall as $key => $value) {
           $model1 = new ExecutiveMasterServicetype();
           $model1->exe_id = $model->id;
           $model1->name = $_POST['ExecutiveMaster']['name'];
           $model1->service_type = $value;
           if($model1->save()){}else{}
         }
       }}

                Yii::$app->getSession()->setFlash('success', 'Saved successfully.');
                return $this->redirect(['index']); 
               }

            else {   
            Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
            return $this->redirect(['index']); 
                }
          
        } else {
            return $this->render('create', [
                'model' => $model,
                'servicetype'=>$servicetype,
            ]);
        }
    }

    /**
     * Updates an existing ExecutiveMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
$servicetype=ArrayHelper::map(CategoryManagement::find()->where(['active_status'=>1])->asArray()->all(), 'auto_id', 'category_name');
        if ($model->load(Yii::$app->request->post())) {
              if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return ActiveForm::validate($model);
           }
                      $password=$_POST['ExecutiveMaster']['password'];
                      $model->designation=$_POST['ExecutiveMaster']['designation'];

            if($password!=""){ 
            $model->password= Yii::$app->security->generatePasswordHash($_POST['ExecutiveMaster']['password']);
            }else{
             $model12 = $this->findModel($id);
             $model->password=$model12->password;
            }

            if ($model->save()) {
                if(isset($_POST['ExecutiveMaster']['service_type'])){
             //echo "<pre>";   print_r($_POST['ExecutiveMaster']['service_type']);die;
              ExecutiveMasterServicetype::deleteAll(['exe_id'=>$id]);    
                $vall = $_POST['ExecutiveMaster']['service_type'];
                 if(!empty($vall)){
            foreach ($vall as $key => $value) {
                $model1 = new ExecutiveMasterServicetype();
           $model1->exe_id = $model->id;
           $model1->name = $_POST['ExecutiveMaster']['name'];
           $model1->service_type = $value;
        if($model1->save()){
                    
                }else{

                    echo "<pre>";print_r($model1->getErrors());die;
                    
                }
            }
                }
            }
                Yii::$app->getSession()->setFlash('success', 'Saved successfully.');
               return $this->redirect(['index']); } 
            else {
               
               Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
           return $this->render('create', [
           'model' => $model,
            ]);
                }
        } else {
            return $this->render('update', [
                'model' => $model,
                'servicetype'=>$servicetype,
            ]);
        }
    }

    /**
     * Deletes an existing ExecutiveMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    try{
        // delete command here
        $this->findModel($id)->delete();
         Yii::$app->getSession()->setFlash('success', 'Data Deleted Successfully');
               return $this->redirect(['index']);
    }catch(\yii\db\Exception $e) {
        if($e->errorInfo[1] == 1451) {
           // throw new \yii\web\HttpException(400, 'Failed to delete the object.');
           Yii::$app->getSession()->setFlash('danger', 'Data Does Not Delete its Used in Another Reference');
               return $this->redirect(['index']); 
        }else{
         throw $e;
        }
    }
       
    }

    public function actionDelete1($id)

    {

        $connection = Yii::$app->db;

        $transaction = $connection->beginTransaction();

        try {

            $connection->createCommand()->delete('executive_master', ['id' => $id])->execute();

            $transaction->commit();

            

            return $this->redirect(['index']);

            

        } catch (Exception $e) {

            $transaction->rollBack();

        }

    }

    /**
     * Finds the ExecutiveMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ExecutiveMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ExecutiveMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
