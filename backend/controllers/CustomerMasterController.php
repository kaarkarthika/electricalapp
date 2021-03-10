<?php

namespace backend\controllers;

use Yii;
use backend\models\CustomerMaster;
use backend\models\CustomerMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerMasterController implements the CRUD actions for CustomerMaster model.
 */
class CustomerMasterController extends Controller
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
     * Lists all CustomerMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CustomerMaster model.
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
     * Creates a new CustomerMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CustomerMaster();

       if ($model->load(Yii::$app->request->post())) {
            
      // echo "<pre>";     print_r(Yii::$app->request->post());die;
                $model->platform="web";
                $model->email=Yii::$app->request->post()['CustomerMaster']['email'];
                $model->customer_name=Yii::$app->request->post()['CustomerMaster']['customer_name'];
               
                $model->auth_key=Yii::$app->security->generateRandomString();
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Saved successfully.');
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
            ]);
        }
    }

    /**
     * Updates an existing CustomerMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

       if ($model->load(Yii::$app->request->post())) {
            
                $model->platform="web";
                $model->auth_key=Yii::$app->security->generateRandomString();
                  $model->email=Yii::$app->request->post()['CustomerMaster']['email'];
                $model->customer_name=Yii::$app->request->post()['CustomerMaster']['customer_name'];
            if ($model->save()) {
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
            ]);
        }
    }

    /**
     * Deletes an existing CustomerMaster model.
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
     * Finds the CustomerMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CustomerMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
