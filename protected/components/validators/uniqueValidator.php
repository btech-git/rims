<?php

  class uniqueValidator extends CValidator
    {
        public $attributeName;
        public $quiet = false; //future bool for quiet validation error -->not complete
    /**
     * Validates the attribute of the object.
     * If there is any error, the error message is added to the object.
     * @param CModel $object the object being validated
     * @param string $attribute the attribute being validated
     */
    protected function validateAttribute($object,$attribute)
    {
        // build criteria from attribute(s) using Yii CDbCriteria
        $criteria=new CDbCriteria();
        foreach ( $this->attributeName as $name )
            $criteria->addSearchCondition( $name, $object->$name, false  );

        // use exists with $criteria to check if the supplied keys combined are unique
        if ( $object->exists( $criteria ) ) {
            $this->addError($object,$attribute, 
              $attribute .' "'. $object->$attribute . '" has already been taken.');
        }
    }

}
?>
