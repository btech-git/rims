<?php

/**
 * This is the model class for table "{{cash_daily_images}}".
 *
 * The followings are the available columns in table '{{cash_daily_images}}':
 * @property integer $id
 * @property integer $cash_daily_summary_id
 * @property string $extension
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property CashDailySummary $cashDailySummary
 */
class CashDailyImages extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CashDailyImages the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{cash_daily_images}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cash_daily_summary_id, extension', 'required'),
            array('cash_daily_summary_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('extension', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, cash_daily_summary_id, extension, is_inactive', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cashDailySummary' => array(self::BELONGS_TO, 'CashDailySummary', 'cash_daily_summary_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'cash_daily_summary_id' => 'Cash Daily Summary',
            'extension' => 'Extension',
            'is_inactive' => 'Is Inactive',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('cash_daily_summary_id', $this->cash_daily_summary_id);
        $criteria->compare('extension', $this->extension, true);
        $criteria->compare('is_inactive', $this->is_inactive);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getFilename() {
        return $this->id . '-realization.' . $this->extension;
    }

}
