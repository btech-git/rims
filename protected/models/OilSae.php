<?php

/**
 * This is the model class for table "{{oil_sae}}".
 *
 * The followings are the available columns in table '{{oil_sae}}':
 * @property integer $id
 * @property string $winter_grade
 * @property string $hot_grade
 *
 * The followings are the available model relations:
 * @property Product[] $products
 */
class OilSae extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{oil_sae}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('winter_grade, hot_grade', 'length', 'max' => 20),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, winter_grade, hot_grade', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'products' => array(self::HAS_MANY, 'Product', 'oil_sae_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'winter_grade' => 'Winter Grade',
            'hot_grade' => 'Hot Grade',
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
        $criteria->compare('winter_grade', $this->winter_grade, true);
        $criteria->compare('hot_grade', $this->hot_grade, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OilSae the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getOilName() {
        
        return $this->winter_grade . ' - ' . $this->hot_grade;
    }
}
