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
class HasModifiedByBehavior extends CActiveRecordBehavior
{
    public function attach($owner)
    {
        parent::attach($owner);
        $this->owner->getMetaData()->addRelation('userModify', array(CActiveRecord::BELONGS_TO, 'User', 'modified_by'));
    }

    public function beforeValidate($event)
    {
        if (!$this->owner->isNewRecord) {
            $this->owner->modified_by = UserHelper::getCurrentUserId();
        }

        return parent::beforeValidate($event);
    }
}