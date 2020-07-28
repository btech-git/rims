<?php

class MyActiveRecord extends CActiveRecord
{
    /**
     * The name of the selected database
     * @var string
     */
    private static $dbName = 'db';
    public $oldItem = null;
    public $logDescription = "";

    /**
     * Select a database which is defined in the configuration file
     * @param string $dbName
     */
    public static function selectDb($dbName) {
        self::$dbName = $dbName;

        self::$db = Yii::app()->$dbName;
        self::$db->setActive(true);
    }

    public function getDbConnection() {
        if (self::$db === null) {
            $dbName = self::$dbName;
            self::$db = Yii::app()->$dbName;
            if (self::$db instanceof CDbConnection === false) {
                throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
            }
        }

        return self::$db;
    }

    public function log($action, $oldModel=null) {
        if (Yii::app()->params['rims_log']) {
            $log = new Log();
            $log->table_name = $this->tableName();
            if(!is_array($this->getPrimaryKey())){
                $log->table_id = $this->getPrimaryKey();
            }
            else{
                foreach ($this->getPrimaryKey() as $key=>$value){
                    $log->table_id .= ($key.':'.$value.';');
                }
            }
            $log->action = $action;
            $log->description = $this->logDescription($oldModel);
            $log->user_id = Yii::app()->user->id == null ? 0 : Yii::app()->user->id;
            $log->date = DateHelper::now();
            $triger = NULL;
            if(isset(Yii::app()->controller)){
                $triger .= 'Controller : ['.Yii::app()->controller->id.']';
                if(isset(Yii::app()->controller->action)){
                    $triger .= ', Action :['.Yii::app()->controller->action->id.']';

                }
            }
            $log->trigger = $triger;
            $log->url = Yii::app()->request->requestUri;
            $log->save();
        }
    }

    public function getPrimaryKey() {
        $table = $this->getMetaData()->tableSchema;
        if (is_string($table->primaryKey)) {
            return $this->{$table->primaryKey};
        } else if (is_array($table->primaryKey)) {
            $arr = array();
            foreach ($table->primaryKey as $primaryKey) {
                array_push($arr, $this->$primaryKey);
            }
            return implode(',', $arr);
        }

        return "";
    }

    public function logDescription($oldModel=null) {
        $description = "";
        if ($oldModel !== null) {
            $description .=
                "BEFORE\n" .
                "================\n" .
                $oldModel->logDescriptionAttribute() .
                "\n\nAFTER\n" .
                "================\n";
        }

        $description .= $this->logDescriptionAttribute();

        return $description;
    }

    public function logDescriptionAttribute() {
        $arr = array();
        $table = $this->getMetaData()->tableSchema;

        foreach ($this->attributeNames() as $attribute) {
            $includeAttribute = true;
            if (is_string($table->primaryKey)) {
                if ($table->primaryKey == $attribute)
                    $includeAttribute = false;
            } else if (is_array($table->primaryKey)) {
                foreach ($table->primaryKey as $primaryKey) {
                    if ($primaryKey == $attribute) {
                        $includeAttribute = false;
                        break;
                    }
                }
            }

            if ($includeAttribute)
                array_push($arr, $this->getAttributeLabel($attribute) . " : " . $this->$attribute);
        }
        return implode("\n", $arr);
    }

    protected function afterFind ()
    {
        $this->oldItem = clone $this;
        parent::afterFind ();
    }

    protected function afterSave()
    {
        $this->log($this->scenario, $this->oldItem);
        parent::afterSave();
    }

    protected function afterDelete()
    {
        $this->log('Delete', $this->oldItem);
        parent::afterDelete();
    }


    /**
     * @param null $prefix
     * @param string $translationContext
     * @return array
     */
    public static function getConstants($prefix=null, $translationContext='string')
    {
        $class = static::model();
        $reflection = new ReflectionClass( get_class( $class ) );

        $list = array();
        $constants = $reflection->getConstants();

        foreach ($constants as $key=>$constant) {
            if ($prefix === null || ($prefix !== null && strpos(strtolower($key), strtolower($prefix)) === 0)) {
                $list[$constant] = Yii::t($translationContext,$constant);
            }
        }

        return $list;
    }

    /**
     * Get new instance statically
     * @return mixed
     */
    public static function instance()
    {
        $className = get_called_class();
        return new $className();
    }

    /**
     * @param string $translationContext
     * @return array
     */
    public static function getList($translationContext='string')
    {
        $class = self::instance();
        $reflection = new ReflectionClass( get_class( $class ) );

        $list = array();
        $constants = $reflection->getConstants();

        foreach ($constants as $constant) {
            $list[$constant] = Yii::t($translationContext,$constant);
        }

        return $list;
    }

    public static function getLabel($id)
    {
        $list = static::getList();
        if (isset($list[$id])) {
            return $list[$id];
        }

        return '-';
    }

    /**
     * Return all error message
     * @return string
     */
    public function getAllErrorMessage(){
        $message = '';
        foreach($this->getErrors() as $error){
            foreach($error as $msg){
                $message.= $msg.' ';
            }
        }
        return $message;
    }

    /**
     * @param string $id
     * @param string $label
     * @param CDbCriteria|string|null $criteria
     * @return array
     */
    public static function toArray($id, $label, $criteria=null)
    {
        $models = static::model()->findAll($criteria);
        return CHtml::listData($models, $id, $label);
    }
}