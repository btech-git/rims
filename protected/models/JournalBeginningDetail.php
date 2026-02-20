<?php

/**
 * This is the model class for table "{{journal_beginning_detail}}".
 *
 * The followings are the available columns in table '{{journal_beginning_detail}}':
 * @property integer $id
 * @property string $current_balance
 * @property string $adjustment_balance
 * @property string $difference_balance
 * @property string $memo
 * @property integer $coa_id
 * @property integer $journal_beginning_header_id
 * @property integer $is_inactive
 *
 * The followings are the available model relations:
 * @property Coa $coa
 * @property JournalBeginningHeader $journalBeginningHeader
 */
class JournalBeginningDetail extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{journal_beginning_detail}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('coa_id, journal_beginning_header_id, is_inactive', 'required'),
            array('coa_id, journal_beginning_header_id, is_inactive', 'numerical', 'integerOnly' => true),
            array('current_balance, adjustment_balance, difference_balance', 'length', 'max' => 18),
            array('memo', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, current_balance, adjustment_balance, difference_balance, coa_id, journal_beginning_header_id, is_inactive, memo', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
            'journalBeginningHeader' => array(self::BELONGS_TO, 'JournalBeginningHeader', 'journal_beginning_header_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'current_balance' => 'Current Balance',
            'adjustment_balance' => 'Adjustment Balance',
            'difference_balance' => 'Difference Balance',
            'memo' => 'Memo',
            'coa_id' => 'Coa',
            'journal_beginning_header_id' => 'Journal Beginning',
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
        $criteria->compare('current_balance', $this->current_balance, true);
        $criteria->compare('adjustment_balance', $this->adjustment_balance, true);
        $criteria->compare('difference_balance', $this->difference_balance, true);
        $criteria->compare('memo', $this->memo, true);
        $criteria->compare('coa_id', $this->coa_id);
        $criteria->compare('journal_beginning_header_id', $this->journal_beginning_header_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JournalBeginningDetail the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getBalanceDifference() {
        
        return $this->adjustment_balance - $this->current_balance;
    }
}
