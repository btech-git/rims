<?php

/**
 * @package common.extensions.behaviors
 *
 * @author Riko Nagatama
 * @version 1.0
 *
 * @modified_by Riko Nagatama
 * @modified_date 2013-04-15
 */
class HasCreatedByBehavior extends CActiveRecordBehavior
{
    public function attach($owner)
    {
        parent::attach($owner);
        $this->owner->getMetaData()->addRelation('userCreate', array(CActiveRecord::BELONGS_TO, 'User', 'created_by'));
    }

    public function beforeValidate($event)
    {
        if ($this->owner->isNewRecord) {
            if($this->owner->created_by==NULL || $this->owner->created_by== '')$this->owner->created_by = UserHelper::getCurrentUserId();
        }

        return parent::beforeValidate($event);
    }
}