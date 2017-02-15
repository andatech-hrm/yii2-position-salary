<?php

namespace andahrm\positionSalary\controllers;

use Yii;
use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\positionSalary\models\PersonPositionSalarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use andahrm\edoc\models\Edoc;
use andahrm\person\models\Person;

use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for PersonPositionSalary model.
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
     * Lists all PersonPositionSalary models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PersonPositionSalarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        //$dataProvider->sort->defaultOrder = ['edoc.updated_at'=>SORT_ASC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PersonPositionSalary model.
     * @param integer $user_id
     * @param integer $position_id
     * @param integer $edoc_id
     * @return mixed
     */
    public function actionView($edoc_id)
    {
        $modelEdoc = Edoc::find()->where(['id'=>$edoc_id])->one();      
        $searchModel = new PersonPositionSalarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->where(['edoc_id' => $edoc_id]);

        return $this->render('view', [
            'modelEdoc' => $modelEdoc,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new PersonPositionSalary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //$model = new PersonPositionSalary();
        $model = new Edoc();
        $model->scenario = 'insert';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['assign-person', 'edoc_id' => $model->id]);
        } 
            return $this->render('create', [
                'model' => $model,
                //'modelEdoc'=> $modelEdoc
            ]);
        
    }
  
  public function actionAssignPerson($edoc_id,$mode=null,$user_id=null)
    {
        $model = new PersonPositionSalary();
        $modelEdoc = Edoc::find()->where(['id'=>$edoc_id])->one();
       
      
          $post = Yii::$app->request->post();
         
           if(isset($post['PersonPositionSalary'])){
        //      echo "<pre>";
        //     print_r($post);
           
        //   exit();
          $flag=true;
             PersonPositionSalary::deleteAll(['edoc_id'=>$modelEdoc->id]);
             foreach($post['PersonPositionSalary'] as $key => $item){
//                $newModel = PersonPositionSalary::find()->where(['edoc_id'=>$modelEdoc->id,'user_id'=>$item['user_id']])->one();
//                if(!$newModel){
//                  $newModel = new PersonPositionSalary();
//                  $newModel->edoc_id = $item['edoc_id'];
//                  $newModel->user_id = $item['user_id'];
//                }               
               //$newModel->load($item);
               if($key == 'status')
               continue;
               
               $newModel = new PersonPositionSalary();
               $newModel->load($item);
               $newModel->edoc_id = $item['edoc_id'];
               $newModel->user_id = $item['user_id'];
               $newModel->title = $modelEdoc->title;               
               $newModel->position_id = $item['position_id'];
               $newModel->level = $item['level'];
               $newModel->salary = $item['salary'];
               $newModel->adjust_date = date('Y-m-d');
               if($flag=$newModel->save(false)){
                 
               }
               
             }
           
           
           if($flag) {
             Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
             return $this->redirect(['view', 'edoc_id' => $modelEdoc->id]);
            } 
         } else{
            return $this->render('assign-person', [
                'model' => $model,
                'modelEdoc'=> $modelEdoc,
                'edoc_id' => $edoc_id,
                'person' => $this->bindPerson($edoc_id,$mode,$user_id),
            ]);
         }
        
    }
  
  

    /**
     * Updates an existing PersonPositionSalary model.
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
     * Deletes an existing PersonPositionSalary model.
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
     * Finds the PersonPositionSalary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $user_id
     * @param integer $position_id
     * @param integer $edoc_id
     * @return PersonPositionSalary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $position_id, $edoc_id)
    {
        if (($model = PersonPositionSalary::findOne(['user_id' => $user_id, 'position_id' => $position_id, 'edoc_id' => $edoc_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
  
  
  /**
     * 
     * @param type $model
     * @param type $mode
     * @param type $user_id
     * @param type $id
     * @return ArrayDataProvider
     */
    public function bindPerson($edoc_id,$mode = null, $user_id = null, $id = null) {
        $session = Yii::$app->session;
        //$id = $model->isNewRecord ? 'new' : $id;
        //$session->destroy('person_position');
//        echo "<pre>";
//            print_r($session['person_position']);
//            echo "</pre><hr/>";
//            exit();
//            
        # if have not this session
        if (!$session->has('person_position')) {
            $session->set('person_position', []);
        }
      
      # if have not key $id
        if (!ArrayHelper::keyExists($edoc_id, $session['person_position'])) {
            $newPersons = [];
            if ($id != 'new') {
                $modelPerson = PersonPositionSalary::find()->where(['edoc_id' => $edoc_id])->orderBy(['user_id' => SORT_ASC])->all();
                if ($modelPerson) {
                    $oldPer = $modelPerson[0]->user_id;
                    //$char = [];
                    foreach ($modelPerson as $per) {
                        //echo "<br/>".$oldPer ." == ".$per->user_id."<br/>";                
                        if ($oldPer != $per->user_id) {
                            $oldPer = $per->user_id;
                            $char = [];
                        }
                        //$char[] = $per->dev_activity_char_id;
                        //print_r($char);
                        $newPersons[$per->user_id] = [
                            'user_id' => $per->user_id,
                            'fullname' => ($per->user ? $per->user->fullname : null),
                            'position_id' => $per->position_id,
                            'salary' => $per->salary,
                            'level' => $per->level,                            
                        ];
                    }
                }
            }
            $session->set('person_position', [$edoc_id => $newPersons]);
        }
      
        
// echo "<pre>";
//        print_r($session['person_position']);
//        echo "</pre><hr/>";
//        exit();
        
        if (isset($mode) && $mode == 'add') { # Event mode Add person
            $person = Person::findOne(['user_id' => $user_id]);
            $test = $session['person_position'];
            $test[$edoc_id][$user_id] = [
                'user_id' => $user_id,
                'fullname' => $person->getInfoMedia('#',[
                    'wrapper' => true,
                    'wrapperTag' => 'div'
                    ]),
                'position_id' => $person->position->id,
                'salary' => '',
                'level' => '', 
            ];
            //$session->destroy('person_position');
            $session->set('person_position', $test);
        
        }elseif (isset($mode) && $mode == 'del') { # Event mode delete person
            $del = $session['person_position'];
            unset($del[$edoc_id][$user_id]);
            $session->set('person_position', $del);
        } elseif (isset($mode) && $mode == 'clear') {
            $session->destroy('person_position');
        }
        # Get Person All
        $person = Person::find()->orderBy('user_id')->all();
        $resPerson = [];
        foreach ($person as $data) {
            $resPerson[$data->user_id] = [
                'edoc_id' => $edoc_id,
                'user_id' => $data->user_id,
                'fullname' => $data->getInfoMedia('#',[
                    'wrapper' => true,
                    'wrapperTag' => 'div'
                    ]),                
                'selected' => false
            ];
        }
        # Check person selected
        $person = $resPerson;
        $modelPerson = $session['person_position'][$edoc_id];
        foreach ($modelPerson as $user_id => $data) {
            if (isset($person[$user_id]))
                $person[$user_id]['selected'] = true;
        }
        $person = new ArrayDataProvider([
            'allModels' => $person,
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);
        return $person;
    }
  
}
