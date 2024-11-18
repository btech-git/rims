<?php

/**
 * This is the model class for table "{{payment_out_approval}}".
 *
 * The followings are the available columns in table '{{payment_out_approval}}':
 * @property integer $id
 * @property integer $payment_out_id
 * @property integer $revision
 * @property string $approval_type
 * @property string $date
 * @property integer $supervisor_id
 * @property string $note
 *
 * The followings are the available model relations:
 * @property PaymentOut $paymentOut
 * @property Users $supervisor
 */
class PaymentOutApproval extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{payment_out_approval}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('payment_out_id, revision, approval_type, date, supervisor_id', 'required'),
            array('payment_out_id, revision, supervisor_id', 'numerical', 'integerOnly' => true),
            array('approval_type', 'length', 'max' => 30),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, payment_out_id, revision, approval_type, date, supervisor_id, note', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'paymentOut' => array(self::BELONGS_TO, 'PaymentOut', 'payment_out_id'),
            'supervisor' => array(self::BELONGS_TO, 'Users', 'supervisor_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'payment_out_id' => 'Payment Out',
            'revision' => 'Revision',
            'approval_type' => 'Approval Type',
            'date' => 'Date',
            'supervisor_id' => 'Supervisor',
            'note' => 'Note',
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
        $criteria->compare('payment_out_id', $this->payment_out_id);
        $criteria->compare('revision', $this->revision);
        $criteria->compare('approval_type', $this->approval_type, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('supervisor_id', $this->supervisor_id);
        $criteria->compare('note', $this->note, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PaymentOutApproval the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterSave() {
        parent::afterSave();

        $history = new TransactionLog();
        $history->transaction_number = $this->paymentOut->payment_number;
        $history->transaction_date = $this->paymentOut->payment_date;
        $history->log_date = date("Y-m-d");
        $history->log_time = date("H:i:s");
        $history->table_name = $this->tableName();
        $history->table_id = $this->id;
        $history->new_data = serialize($this->attributes);

        $history->save();
    }

}
