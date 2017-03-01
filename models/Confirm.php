<?php

namespace andahrm\insignia\models;

use Yii;

/**
 * This is the model class for table "insignia_request".
 *
 * @property integer $id
 * @property integer $person_type_id
 * @property string $year
 * @property integer $insignia_type_id
 * @property integer $gender
 * @property integer $status
 * @property integer $certificate_offer_name
 * @property string $certificate_offer_date
 * @property integer $edoc_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property InsigniaPerson[] $insigniaPeople
 * @property InsigniaPerson[] $insigniaPeople0
 * @property InsigniaType $insigniaType
 */
class Confirm extends InsigniaRequest
{
    public function rules()
    {
        return [
            //[['person_type_id', 'year', 'certificate_offer_name'], 'required'],
        ];
    }
    
    
    
     public function scenarios(){
          $scenarios = parent::scenarios();
          $scenarios['insert'] = ['status'];
          return $scenarios;
    }
    
    
    
}
