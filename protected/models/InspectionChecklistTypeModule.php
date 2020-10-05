<?php

/**
 * This is the model class for table "{{inspection_checklist_type_module}}".
 *
 * The followings are the available columns in table '{{inspection_checklist_type_module}}':
 * @property integer $id
 * @property integer $checklist_type_id
 * @property integer $checklist_module_id
 * @property integer $checklist_module_id_after_service
 *
 * The followings are the available model relations:
 * @property InspectionChecklistType $checklistType
 * @property InspectionChecklistModule $checklistModule
 * @property InspectionChecklistModule $checklistModuleAfterService
 */
class InspectionChecklistTypeModule extends CActiveRecord {

    public $checklist_module_name;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{inspection_checklist_type_module}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('checklist_type_id, checklist_module_id', 'required'),
            array('checklist_type_id, checklist_module_id, checklist_module_id_after_service', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, checklist_type_id, checklist_module_id, checklist_module_name, checklist_module_id_after_service', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'checklistType' => array(self::BELONGS_TO, 'InspectionChecklistType', 'checklist_type_id'),
            'checklistModule' => array(self::BELONGS_TO, 'InspectionChecklistModule', 'checklist_module_id'),
            'checklistModuleAfterService' => array(self::BELONGS_TO, 'InspectionChecklistModule', 'checklist_module_id_after_service'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'checklist_type_id' => 'Checklist Type',
            'checklist_module_id' => 'Checklist Module',
            'checklist_module_id_after_service' => 'Checklist Module',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('checklist_type_id', $this->checklist_type_id);
        $criteria->compare('checklist_module_id', $this->checklist_module_id);
        $criteria->compare('checklist_module_id_after_service', $this->checklist_module_id_after_service);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return InspectionChecklistTypeModule the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
