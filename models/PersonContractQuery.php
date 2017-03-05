<?php

namespace andahrm\positionSalary\models;

/**
 * This is the ActiveQuery class for [[PersonContract]].
 *
 * @see PersonContract
 */
class PersonContractQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return PersonContract[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return PersonContract|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
    
     public function check($user_id,$position_id,$edoc_id)
    {
        return $this->andWhere(['user_id'=>$user_id,'position_id'=>$position_id,'edoc_id'=>$edoc_id])->one();
    }
}
