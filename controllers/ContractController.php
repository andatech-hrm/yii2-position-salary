<?php

namespace andahrm\positionSalary\controllers;

use Yii;
use andahrm\positionSalary\models\PersonContract;
use andahrm\positionSalary\models\PersonContractSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContractController implements the CRUD actions for PersonContract model.
 */
class ContractController extends Controller
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
     * Lists all PersonContract models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonContractSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PersonContract model.
     * @param integer $user_id
     * @param integer $position_id
     * @param integer $edoc_id
     * @return mixed
     */
    public function actionView($user_id, $position_id, $edoc_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $position_id, $edoc_id),
        ]);
    }

    /**
     * Creates a new PersonContract model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PersonContract();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'position_id' => $model->position_id, 'edoc_id' => $model->edoc_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PersonContract model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param integer $position_id
     * @param integer $edoc_id
     * @return mixed
     */
    public function actionUpdate($user_id, $position_id, $edoc_id)
    {
        $model = $this->findModel($user_id, $position_id, $edoc_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'position_id' => $model->position_id, 'edoc_id' => $model->edoc_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PersonContract model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param integer $position_id
     * @param integer $edoc_id
     * @return mixed
     */
    public function actionDelete($user_id, $position_id, $edoc_id)
    {
        $this->findModel($user_id, $position_id, $edoc_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PersonContract model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $position_id
     * @param integer $edoc_id
     * @return PersonContract the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $position_id, $edoc_id)
    {
        if (($model = PersonContract::findOne(['user_id' => $user_id, 'position_id' => $position_id, 'edoc_id' => $edoc_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
