<?php

namespace andahrm\positionSalary\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use andahrm\positionSalary\models\PersonPositionSalary;
use andahrm\positionSalary\models\PersonPositionSalarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use andahrm\edoc\models\Edoc;
use andahrm\person\models\Person;

use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;

use beastbytes\wizard\WizardBehavior;


use yii\helpers\Json;
use andahrm\structure\models\BaseSalary;
use andahrm\structure\models\Structure;
use andahrm\structure\models\FiscalYear;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\Position;

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
    
    
     public function beforeAction($action)
    {
        $config = [];
        switch ($action->id) {
            case 'create':
                $config = [
                    'steps' => [
                        Yii::t('andahrm/position-salary','Topic') => 'topic', 
                        Yii::t('andahrm/position-salary','Select Person') => 'person', 
                        Yii::t('andahrm/position-salary','Assign') => 'assign', 
                        Yii::t('andahrm/position-salary','Confirm') => 'confirm',
                        ],
                    'events' => [
                        WizardBehavior::EVENT_WIZARD_STEP => [$this, $action->id.'WizardStep'],
                        WizardBehavior::EVENT_AFTER_WIZARD => [$this, $action->id.'AfterWizard'],
                        WizardBehavior::EVENT_INVALID_STEP => [$this, 'invalidStep']
                    ]
                ];
                break;
           
            case 'resume':
                $config = ['steps' => []]; // force attachment of WizardBehavior
                
            default:
                break;
        }

        if (!empty($config)) {
            $config['class'] = WizardBehavior::className();
            $config['sessionKey'] = 'Wizard-position-salary';
            $this->attachBehavior('wizard', $config);
        }

        return parent::beforeAction($action);
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
    
    public function actionBindPerson($selection=null,$section_id=null,$person_type_id=null,$position_line_id=null)
    {
        
        $query = PersonPositionSalary::find()->joinWith('position', false, 'INNER JOIN')
                 //->where(['position.section_id'=>$section_id])
                 ->andFilterWhere(['position.section_id'=>$section_id])
                 ->andFilterWhere(['position.person_type_id'=>$person_type_id])
                 ->andFilterWhere(['position.position_line_id'=>$position_line_id])
                ->groupBy([
                    //'position.id',
                    'user_id',
                ])
                ->orderBy(['position_id'=>SORT_ASC,'adjust_date'=>SORT_ASC]);
                //print_r($query);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                //'pageSize' => 10,
            ],
            // 'sort' => [
            //     'defaultOrder' => [
            //         'created_at' => SORT_DESC,
            //         'title' => SORT_ASC, 
            //     ]
            // ],
        ]);
        
        $selection = $selection?json_decode($selection):'';
        //print_r($selection);
        return $this->renderPartial('bind-person', [
            //'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'selection' => $selection
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
    // public function actionCreate()
    // {
    //     //$model = new PersonPositionSalary();
    //     $model = new Edoc();
    //     $model->scenario = 'insert';
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['assign-person', 'edoc_id' => $model->id]);
    //     } 
    //         return $this->render('create', [
    //             'model' => $model,
    //             //'modelEdoc'=> $modelEdoc
    //         ]);
        
    // }
  
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
    
    
     ###########################################################
    ###########################################################
    ###########################################################
    
    public function actionCreate($step = null)
    {
        // print_r(Yii::$app->session);
        // exit();
        //if ($step===null) $this->resetWizard();
        
        if ($step=='reset') $this->resetWizard();
        return $this->step($step);
    }
    
    /**
    * Process wizard steps.
    * The event handler must set $event->handled=true for the wizard to continue
    * @param WizardEvent The event
    */
    public function createWizardStep($event)
    {
        
        
        if (empty($event->stepData)) {
            $modelName = '\andahrm\positionSalary\models\\'.ucfirst($event->step);
            $model = new $modelName();
            $model->scenario = 'insert';
        } else {
            $model = $event->stepData;
        }

        $post = Yii::$app->request->post();
       
        if (isset($post['cancel'])) {
            $event->continue = false;
        } elseif (isset($post['prev'])) {
            $event->nextStep = WizardBehavior::DIRECTION_BACKWARD;
            $event->handled  = true;
        } elseif ($model->load($post) && $model->validate()) {
            
            
            
            $event->data    = $model;
            $event->handled = true;

            if (isset($post['pause'])) {
                $event->continue = false;
            } elseif ($event->n < 2 && isset($post['add'])) {
                $event->nextStep = WizardBehavior::DIRECTION_REPEAT;
            }
            
             if($post){
                print_r($post);
                //exit();
            }
        } else {
            // if($model->hasErrors()){
            //     echo "DefaultController : ";
            //     print_r($model->getErrors());
            //     //exit();
            // }
                
            $event->data = $this->render('wizard/'.$event->step, compact('event', 'model'));
        }
    }

    /**
    * @param WizardEvent The event
    */
    public function invalidStep($event)
    {
        $event->data = $this->render('wizard/invalidStep', compact('event'));
        $event->continue = false;
        return $this->redirect(['create']);
    }

    /**
    * Registration wizard has ended; the reason can be determined by the
    * step parameter: TRUE = wizard completed, FALSE = wizard did not start,
    * <string> = the step the wizard stopped at
    * @param WizardEvent The event
    */
    public function createAfterWizard($event)
    {
        if (is_string($event->step)) {
            $uuid = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
            );

            $registrationDir = Yii::getAlias('@runtime/wizard/position-salary');
            $registrationDirReady = true;
            if (!file_exists($registrationDir)) {
                if (!mkdir($registrationDir) || !chmod($registrationDir, 0775)) {
                    $registrationDirReady = false;
                }
            }
            if ($registrationDirReady && file_put_contents(
                $registrationDir.DIRECTORY_SEPARATOR.$uuid,
                $event->sender->pauseWizard()
            )) {
                $event->data = $this->render('wizard/paused', compact('uuid'));
            } else {
                $event->data = $this->render('wizard/notPaused');
            }
        } elseif ($event->step === null) {
            $event->data = $this->render('wizard/cancelled');
        } elseif ($event->step) {
            
            
            
            $modelTopic = $event->stepData['topic'][0];
            $modelPerson= $event->stepData['person'][0];
            $modelAssign = $event->stepData['assign'][0];
             //print_r($modelTopic);
            // exit();
            $flag = false;
            $err=[];
            if(isset($modelTopic) && isset($modelPerson) && isset($modelAssign) ){
                
                //  print_r($modelAssign->scenario);
                //  exit();
                foreach ($modelPerson->selection as $key => $user_id) {
                    $modelPersonPositionSalary = new PersonPositionSalary(['scenario'=>$modelAssign->scenario]);
                    $modelPersonPositionSalary->user_id = $modelAssign->user_id[$user_id];
                    $modelPersonPositionSalary->position_id = $modelAssign->new_position_id[$user_id]?$modelAssign->new_position_id[$user_id]:$modelAssign->position_id[$user_id];
                    $modelPersonPositionSalary->edoc_id = $modelTopic->edoc_id;
                    $modelPersonPositionSalary->title = $modelTopic->title;
                    $modelPersonPositionSalary->status = $modelTopic->status;
                    $modelPersonPositionSalary->level = $modelAssign->new_level[$user_id]?$modelAssign->new_level[$user_id]:$modelAssign->level[$user_id];
                    $modelPersonPositionSalary->step = $modelAssign->new_step[$user_id]?$modelAssign->new_step[$user_id]:$modelAssign->step[$user_id];
                    $modelPersonPositionSalary->step_adjust = $modelAssign->step_adjust[$user_id];
                    $modelPersonPositionSalary->salary = $modelAssign->new_salary[$user_id]?$modelAssign->new_salary[$user_id]:$modelAssign->salary[$user_id];
                    $modelPersonPositionSalary->adjust_date = $modelTopic->adjust_date;
                    
                   if (($flag = $modelPersonPositionSalary->save()) === false) {
                       $err[] = $modelPersonPositionSalary->getErrors();
                    }
                }
                
                //exit();
                
                
               if($flag){
                  $event->data = $this->render('wizard/complete', [
                    'data' => $event->stepData
                    ]);
               }else{
                   echo $flag;
                   echo "save";
                   print_r($err);
                   //exit();
                //$event->continue = false;
               }
                
            }
        } else {
            
            $event->data = $this->render('wizard/notStarted');
        }
    }

    /**
    * Method description
    *
    * @return mixed The return value
    */
    public function actionResume($uuid)
    {
        $registrationFile = Yii::getAlias('@runtime/wizard/leave').DIRECTORY_SEPARATOR.$uuid;
        if (file_exists($registrationFile)) {
            $this->resumeWizard(@file_get_contents($registrationFile));
            unlink($registrationFile);
            $this->redirect(['create']);
        } else {
            return $this->render('wizard/notResumed');
        }
    }
    
    
    ####################################################
    ####################################################
    #### Get Data Json
    
    
    protected function MapData($datas,$fieldId,$fieldName){
     $obj = [];
     foreach ($datas as $key => $value) {
         array_push($obj, ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}]);
     }
     return $obj;
    }
 
 ###############
     public function actionGetPersonType() {
     $out = [];
      $post = Yii::$app->request->post();
     if ($post['depdrop_parents']) {
         $parents = $post['depdrop_parents'];
         if ($parents != null) {
             $section_id = $parents[0];
             $out = $this->getPersonType($section_id);
             echo Json::encode(['output'=>$out, 'selected'=>'']);
             return;
         }
         }
         echo Json::encode(['output'=>'', 'selected'=>'']);
     }

      protected function getPersonType($section_id){
         $datas = Position::find()->where(['section_id'=>$section_id])->groupBy('person_type_id')->all();
         return $this->MapData($datas,'person_type_id','personTypeTitle');
     }
 
 #############
    public function actionGetPositionLine() {
     $out = [];
      $post = Yii::$app->request->post();
     if (isset($post['depdrop_parents'])) {
         $parents = $post['depdrop_parents'];
         $section_id = null;
         $person_type_id = null;
         if (isset($parents) && $parents != null) {
             $section_id = $parents[0];
             if(isset($parents[1]))
             $person_type_id = $parents[1];
             
             $out = $this->getPositionLine($section_id,$person_type_id);
             echo Json::encode(['output'=>$out, 'selected'=>'']);
             return;
         }
         }
         echo Json::encode(['output'=>'', 'selected'=>'']);
     }

      protected function getPositionLine($section_id,$person_type_id=null){
         $datas = PositionLine::find()
         ->joinWith('position')->where([
             'position.section_id'=>$section_id,
             ])
         ->andFilterWhere(['position.person_type_id'=>$person_type_id])
         ->all();
         return $this->MapData($datas,'id','title');
     }
     
  
}
