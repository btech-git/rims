<?php

/**
 * This is the model class for table "{{journal_beginning_approval}}".
 *
 * The followings are the available columns in table '{{journal_beginning_approval}}':
 * @property integer $id
 * @property integer $revision
 * @property string $approval_type
 * @property string $date
 * @property string $time
 * @property string $note
 * @property integer $journal_beginning_header_id
 * @property integer $user_id_approval
 *
 * The followings are the available model relations:
 * @property JournalBeginningHeader $journalBeginningHeader
 * @property Users $userIdApproval
 */
class JournalBeginningApproval extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{journal_beginning_approval}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('approval_type, date, time, journal_beginning_header_id, user_id_approval', 'required'),
            array('revision, journal_beginning_header_id, user_id_approval', 'numerical', 'integerOnly' => true),
            array('approval_type', 'length', 'max' => 20),
            array('note', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, revision, approval_type, date, time, note, journal_beginning_header_id, user_id_approval', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'journalBeginningHeader' => array(self::BELONGS_TO, 'JournalBeginningHeader', 'journal_beginning_header_id'),
            'userIdApproval' => array(self::BELONGS_TO, 'Users', 'user_id_approval'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'revision' => 'Revision',
            'approval_type' => 'Approval Type',
            'date' => 'Date',
            'time' => 'Time',
            'note' => 'Note',
            'journal_beginning_header_id' => 'Journal Beginning Header',
            'user_id_approval' => 'User Id Approval',
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
        $criteria->compare('revision', $this->revision);
        $criteria->compare('approval_type', $this->approval_type, true);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('note', $this->note, true);
        $criteria->compare('journal_beginning_header_id', $this->journal_beginning_header_id);
        $criteria->compare('user_id_approval', $this->user_id_approval);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return JournalBeginningApproval the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
