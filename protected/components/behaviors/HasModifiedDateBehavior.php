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
class HasModifiedDateBehavior extends CActiveRecordBehavior
{
    public function beforeValidate($event)
    {
        if (!$this->owner->isNewRecord) {
            $this->owner->modified_date = DateHelper::now();
        }

        return parent::beforeValidate($event);
    }
}