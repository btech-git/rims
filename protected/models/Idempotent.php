<?php

/**
 * This is the model class for table "idempotent".
 *
 * The followings are the available columns in table 'idempotent':
 * @property integer $form_token
 * @property string $form_name
 * @property string $posting_date
 */
class Idempotent extends CActiveRecord {

    const TOKEN_NAME = '__idempotent_token__';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'idempotent';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('form_token, form_name, posting_date', 'required'),
            array('form_token', 'numerical', 'integerOnly' => true),
            array('form_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('form_token, form_name, posting_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'form_token' => 'Form Token',
            'form_name' => 'Form Name',
            'posting_date' => 'Posting Date',
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

        $criteria->compare('form_token', $this->form_token);
        $criteria->compare('form_name', $this->form_name, true);
        $criteria->compare('posting_date', $this->posting_date, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Idempotent the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function generateToken() {
        return random_int(1, 1000000000);
    }

}
