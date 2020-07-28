<?php

/**
 * This is the model class for table "{{registration_memo}}".
 *
 * The followings are the available columns in table '{{registration_memo}}':
 * @property integer $id
 * @property string $memo
 * @property integer $registration_transaction_id
 * @property string $date_time
 * @property integer $user_id
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property RegistrationTransaction $registrationTransaction
 */
class RegistrationMemo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RegistrationMemo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{registration_memo}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('memo, registration_transaction_id, date_time, user_id', 'required'),
			array('registration_transaction_id, user_id', 'numerical', 'integerOnly'=>true),
			array('memo', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, memo, registration_transaction_id, date_time, user_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'registrationTransaction' => array(self::BELONGS_TO, 'RegistrationTransaction', 'registration_transaction_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'memo' => 'Memo',
			'registration_transaction_id' => 'Registration Transaction',
			'date_time' => 'Date Time',
			'user_id' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('registration_transaction_id',$this->registration_transaction_id);
		$criteria->compare('date_time',$this->date_time,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}