<?php

namespace andahrm\positionSalary\controllers;

use Yii;
use andahrm\positionSalary\models\PersonPostionSalary;
use andahrm\positionSalary\models\PersonPostionSalarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use andahrm\edoc\models\Edoc;
use andahrm\structure\models\Position;

/**
 * DefaultController implements the CRUD actions for PersonPostionSalary model.
 */
class DefaultController extends Controller
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
     * Lists all PersonPostionSalary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonPostionSalarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PersonPostionSalary model.
     * @param integer $user_id
     * @param integer $position_id
     * @return mixed
     */
    public function actionView($user_id, $position_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($user_id, $position_id),
        ]);
    }

    /**
     * Creates a new PersonPostionSalary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $modelEdoc = new Edoc();
        $model = new PersonPostionSalary();
      

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'position_id' => $model->position_id]);
        } 
            return $this->render('create', [
                'model' => $model,
                'modelEdoc' => $modelEdoc,
            ]);
        
    }

    /**
     * Updates an existing PersonPostionSalary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $user_id
     * @param integer $position_id
     * @return mixed
     */
    public function actionUpdate($user_id, $position_id)
    {
        $model = $this->findModel($user_id, $position_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $model->user_id, 'position_id' => $model->position_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PersonPostionSalary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $user_id
     * @param integer $position_id
     * @return mixed
     */
    public function actionDelete($user_id, $position_id)
    {
        $this->findModel($user_id, $position_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PersonPostionSalary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $position_id
     * @return PersonPostionSalary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $position_id)
    {
        if (($model = PersonPostionSalary::findOne(['user_id' => $user_id, 'position_id' => $position_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
