<?php

/**
 * @package common.extensions.behaviors
 * @author Riko Nagatama
 * @version 1.0
 * @modified_by Riko Nagatama
 * @modified_date 2013-05-29
 */
class SoftDeleteBehavior extends CActiveRecordBehavior
{
    /**
     * @var string
     */
    public $flagField = 'is_deleted';
    public $deletedAt = 'deleted_at';
    public $deletedBy = 'deleted_by';

    /**
     * @return CComponent
     */
    public function remove() {
        $this->getOwner()->{$this->flagField} = 1;
        $this->getOwner()->{$this->deletedAt} = date('Y-m-d H:i:s');
        $this->getOwner()->{$this->deletedBy} = Yii::app()->user->id;
        $this->getOwner()->save();
        return $this->getOwner();
    }

    // public function beforeFind($event)
    // {
    //     // if ($this->getEnabled()) {
    //         $criteria = new CDbCriteria;
    //         $criteria->condition = "{$this->owner->tableAlias}.{$this->flagField} = 0";
    //         $this->owner->dbCriteria->mergeWith($criteria);
    //     // }
    // }

    /**
     * @return CComponent
     */
    public function restore() {
        $this->getOwner()->{$this->flagField} = 0;
        $this->getOwner()->save();
        return $this->getOwner();
    }

    /**
     * @return CComponent
     */
    public function notRemoved() {
        $this->getOwner()->getDbCriteria()->mergeWith(array(
            'condition'=>$this->flagField.' = 0',
            'params'=>array(),
        ));

        return $this->getOwner();
        /*
        $criteria = $this->getOwner()->getDbCriteria();
        $criteria->compare('t.' . $this->flagField, 0);
        return $this->getOwner();
        */
    }

    /**
     * @return CComponent
     */
    public function removed() {
        $this->getOwner()->getDbCriteria()->mergeWith(array(
            'condition'=>$this->flagField.' = 1',
            'params'=>array(),
        ));

        return $this->getOwner();
        /*
        $criteria = $this->getOwner()->getDbCriteria();
        $criteria->compare('t.' . $this->flagField, 1);
        return $this->getOwner();
        */
    }

    /**
     * @return bool
     */
    public function isRemoved() {
        return (boolean)$this->getOwner()->{$this->flagField};
    }


}
