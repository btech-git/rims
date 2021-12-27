<?php

class IdempotentManager {

    const TOKEN_NAME = '__idempotent_token__';
    
    public static function build() {
        $idempotent = new Idempotent;
        $idempotent->form_token = $_POST[self::TOKEN_NAME];
        $idempotent->form_name = Yii::app()->controller->module->id  . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id;
        $idempotent->posting_date = date('Y-m-d');
        return $idempotent;
    }
    
    public static function check() {
        return isset($_POST[self::TOKEN_NAME]);
    }
    
    public static function generate() {
        return CHtml::hiddenField(self::TOKEN_NAME, rand(1, 1000000000));
    }
}
