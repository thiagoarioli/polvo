<?php
namespace app\models\base;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecordInterface;
use yii\db\Expression;

class BaseModel extends \yii\db\ActiveRecord {

    public $alias = null;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()')
            ],
        ];
    }

    public function delete($realDelete = false){
        if($realDelete){
            parent::delete();
        }else{
            $this->is_deleted = 1;
            if($this->save()){
                return true;
            }else{
                return false;
            }

        }
    }

    public function afterSave ($insert, $changedAttributes)
    {
        $this->refresh();
        parent::afterSave($insert,$changedAttributes);
    }

}